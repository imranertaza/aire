<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\EmailCampaign;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendMassEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaignId;
    public $audiences;
    public $subject;
    public $messageBody;

    protected $sentCount = 0;
    protected $failedCount = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $campaignId, array $audiences, string $subject, string $messageBody)
    {
        $this->campaignId = $campaignId;
        $this->audiences = $audiences;
        $this->subject = $subject;
        $this->messageBody = $messageBody;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign = EmailCampaign::find($this->campaignId);
        if (!$campaign) {
            return;
        }

        // 1. Chunk and send to Customers if requested (excluding unsubscribed customers)
        if (in_array('customer', $this->audiences)) {
            Customer::whereNotNull('email')
                ->where('status', 1)
                ->where(function ($query) {
                    $query->where('newsletter', 1)
                        ->orWhereNull('newsletter');
                })
                ->chunkById(500, function ($customers) use ($campaign) {
                    foreach ($customers as $customer) {
                        $unsubscribeUrl = $customer->getUnsubscribeUrl();
                        $this->sendEmail($customer->email, $unsubscribeUrl);
                    }
                    $campaign->increment('sent_count', $this->sentCount);
                    $campaign->increment('failed_count', $this->failedCount);
                    $this->sentCount = 0;
                    $this->failedCount = 0;
                });
        }

        // 2. Chunk and send to Active Subscribers if requested
        if (in_array('subscribe', $this->audiences)) {
            Newsletter::whereNotNull('email')
                ->where('status', 1)
                ->chunkById(500, function ($subscribers) use ($campaign) {
                    foreach ($subscribers as $subscriber) {
                        $unsubscribeUrl = $subscriber->getUnsubscribeUrl();
                        $this->sendEmail($subscriber->email, $unsubscribeUrl);
                    }
                    $campaign->increment('sent_count', $this->sentCount);
                    $campaign->increment('failed_count', $this->failedCount);
                    $this->sentCount = 0;
                    $this->failedCount = 0;
                });
        }

        // Mark campaign as completed
        $campaign->update(['status' => 'completed']);
    }

    /**
     * Send email with RFC 8058 One-Click List-Unsubscribe headers and footer.
     */
    private function sendEmail(string $email, ?string $unsubscribeUrl = null)
    {
        try {
            $formattedHtml = $this->buildEmailHtmlWithFooter($this->messageBody, $unsubscribeUrl);

            Mail::send([], [], function ($message) use ($email, $formattedHtml, $unsubscribeUrl) {
                $message->to($email)
                    ->subject($this->subject)
                    ->html($formattedHtml);

                // RFC 8058 - 1-Click List-Unsubscribe headers for Gmail, Yahoo, Apple Mail
                if ($unsubscribeUrl) {
                    $message->getHeaders()->addTextHeader('List-Unsubscribe', "<{$unsubscribeUrl}>");
                    $message->getHeaders()->addTextHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click');
                }
            });

            $this->sentCount++;
        } catch (\Exception $e) {
            Log::error("SendMassEmailJob: Failed to send email to {$email}: " . $e->getMessage());
            $this->failedCount++;
        }
    }

    /**
     * Build email HTML with CAN-SPAM compliant unsubscribe footer.
     */
    protected function buildEmailHtmlWithFooter(string $body, ?string $unsubscribeUrl = null): string
    {
        if (!$unsubscribeUrl) {
            return nl2br($body);
        }

        $appName = config('app.name', 'Aire');
        $footerHtml = '
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 35px; border-top: 1px solid #e5e7eb; padding-top: 20px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif;">
                <tr>
                    <td align="center" style="color: #6b7280; font-size: 12px; line-height: 18px;">
                        <p style="margin: 0 0 6px 0;">You received this email because you subscribed to updates from ' . e($appName) . '.</p>
                        <p style="margin: 0;">
                            <a href="' . e($unsubscribeUrl) . '" style="color: #4b5563; text-decoration: underline; font-weight: 500;">
                                Unsubscribe from these emails (1-Click)
                            </a>
                        </p>
                    </td>
                </tr>
            </table>';

        return nl2br($body) . $footerHtml;
    }
}
