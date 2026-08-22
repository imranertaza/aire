<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\PaymentMethod;

class PaypalExpressService
{
    protected array $settings;

    public function __construct()
    {
        $paymentMethodObj = PaymentMethod::where('code', 'paypal')->orWhere('name', 'Paypal')->first();
        $this->settings = $paymentMethodObj ? ($paymentMethodObj->settings ?? []) : [];
    }

    /**
     * Perform an NVP API call to PayPal using API credentials.
     */
    public function hashCall(string $methodName, string $nvpStr): array
    {
        $apiUsername  = $this->settings['api_username'] ?? '';
        $apiPassword  = $this->settings['api_password'] ?? '';
        $apiSignature = $this->settings['api_signature'] ?? '';
        $isSandbox    = ($this->settings['api_url'] ?? 'sandbox') === 'sandbox';

        $endpoint = $isSandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';

        $nvpHeader = "&PWD=" . urlencode($apiPassword) . "&USER=" . urlencode($apiUsername) . "&SIGNATURE=" . urlencode($apiSignature);

        $nvpReq = "METHOD=" . urlencode($methodName) . "&VERSION=65.1" . $nvpHeader . $nvpStr;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpReq);

        $response = curl_exec($ch);
        curl_close($ch);

        return $this->deformatNvp($response ? $response : '');
    }

    /**
     * Convert NVP string into an associative array.
     */
    public function deformatNvp(string $nvpStr): array
    {
        $nvpArray = [];
        parse_str($nvpStr, $nvpArray);
        return $nvpArray;
    }

    /**
     * Initiate Express Checkout process (SetExpressCheckout).
     */
    public function processPayment(Order $order, float $amount): array
    {
        $isSandbox = ($this->settings['api_url'] ?? 'sandbox') === 'sandbox';
        $redirectUrl = $isSandbox
            ? 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='
            : 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';

        $returnUrl = route('order.confirm') . '?order_id=' . $order->id . '&payment=success';
        $cancelUrl = route('checkout') . '?payment=cancelled';

        $nvpStr = "&PAYMENTREQUEST_0_PAYMENTACTION=Sale"
                . "&PAYMENTREQUEST_0_AMT=" . number_format($amount, 2, '.', '')
                . "&PAYMENTREQUEST_0_CURRENCYCODE=USD"
                . "&RETURNURL=" . urlencode($returnUrl)
                . "&CANCELURL=" . urlencode($cancelUrl)
                . "&L_NAME0=" . urlencode('Aire Order #' . ($order->invoice_no ?? $order->id))
                . "&L_AMT0=" . number_format($amount, 2, '.', '')
                . "&L_QTY0=1";

        $resArray = $this->hashCall('SetExpressCheckout', $nvpStr);

        $ack = strtoupper($resArray['ACK'] ?? '');
        if (($ack === 'SUCCESS' || $ack === 'SUCCESSWITHWARNING') && !empty($resArray['TOKEN'])) {
            return [
                'success'      => true,
                'redirect_url' => $redirectUrl . trim($resArray['TOKEN']),
                'token'        => trim($resArray['TOKEN'])
            ];
        }

        return [
            'success' => false,
            'message' => $resArray['L_LONGMESSAGE0'] ?? 'PayPal Express initialization failed.',
            'raw'     => $resArray
        ];
    }

    /**
     * Confirm PayPal Express Checkout Payment (DoExpressCheckoutPayment).
     */
    public function confirmPayment(string $token, string $payerId, float $amount): array
    {
        $nvpStr = '&TOKEN=' . urlencode($token)
                . '&PAYERID=' . urlencode($payerId)
                . '&PAYMENTACTION=Sale'
                . '&AMT=' . number_format($amount, 2, '.', '')
                . '&CURRENCYCODE=USD';

        $resArray = $this->hashCall('DoExpressCheckoutPayment', $nvpStr);
        $ack = strtoupper($resArray['ACK'] ?? '');

        return [
            'success' => ($ack === 'SUCCESS' || $ack === 'SUCCESSWITHWARNING'),
            'data'    => $resArray
        ];
    }
}
