<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation #{{ $order->id }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        td {
            padding: 0;
        }
        img {
            border: 0;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f6f8;
            padding-bottom: 40px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 640px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 30px 40px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 26px;
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header p {
            color: #94a3b8;
            margin: 8px 0 0 0;
            font-size: 14px;
        }
        .content {
            padding: 35px 40px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 15px;
        }
        .lead-text {
            color: #475569;
            font-size: 15px;
            margin-bottom: 25px;
        }
        .meta-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 18px 20px;
            margin-bottom: 30px;
        }
        .meta-table {
            width: 100%;
        }
        .meta-table td {
            padding: 5px 0;
            font-size: 13px;
        }
        .meta-label {
            color: #64748b;
            font-weight: 600;
            width: 38%;
        }
        .meta-value {
            color: #1e293b;
            font-weight: 500;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .addresses-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .address-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px;
            font-size: 13px;
            color: #334155;
            vertical-align: top;
            width: 48%;
        }
        .address-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
        }
        .items-table {
            width: 100%;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }
        .items-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table td {
            padding: 14px;
            font-size: 13px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        .item-name {
            font-weight: 600;
            color: #0f172a;
        }
        .item-options {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }
        .totals-table {
            width: 100%;
            margin-top: 15px;
        }
        .totals-table td {
            padding: 6px 14px;
            font-size: 13px;
        }
        .totals-label {
            text-align: right;
            color: #64748b;
            width: 70%;
        }
        .totals-value {
            text-align: right;
            color: #0f172a;
            font-weight: 600;
        }
        .grand-total td {
            padding-top: 12px;
            border-top: 2px solid #e2e8f0;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 25px 40px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
        .footer a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <center>
            <table class="main" width="100%">
                <!-- Header -->
                <tr>
                    <td class="header">
                        <h1>{{ $storeName }}</h1>
                        <p>{{ $isAdminNotification ? 'New Customer Order Notification' : 'Order Confirmation & Receipt' }}</p>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td class="content">
                        @if ($isAdminNotification)
                            <div class="greeting">Hello Admin,</div>
                            <div class="lead-text">
                                A new order <strong>#{{ $order->id }}</strong> has been placed by <strong>{{ $order->firstname }} {{ $order->lastname }}</strong>. Below are the order and delivery details:
                            </div>
                        @else
                            <div class="greeting">Hello {{ $order->firstname }},</div>
                            <div class="lead-text">
                                Thank you for your order! We have received your purchase and our team is preparing it for fulfillment. Below is your detailed order receipt:
                            </div>
                        @endif

                        <!-- Meta Info Card -->
                        <div class="meta-card">
                            <table class="meta-table">
                                <tr>
                                    <td class="meta-label">Order Number:</td>
                                    <td class="meta-value"><strong>#{{ $order->id }}</strong> (Invoice: #{{ $order->invoice_no ?: $order->id }})</td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Order Date:</td>
                                    <td class="meta-value">{{ $order->created_at ? $order->created_at->format('F d, Y - h:i A') : date('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Payment Method:</td>
                                    <td class="meta-value">{{ $order->payment_method ?: 'Credit Card' }}</td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Payment Status:</td>
                                    <td class="meta-value">
                                        <span class="badge {{ strtolower($order->payment_status) === 'paid' ? 'badge-paid' : 'badge-pending' }}">
                                            {{ $order->payment_status ?: 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Shipping Method:</td>
                                    <td class="meta-value">{{ $order->shipping_method ?: 'Standard Delivery' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Customer & Shipping Addresses -->
                        <table class="addresses-table">
                            <tr>
                                <td class="address-box">
                                    <div class="address-title">Billing Details</div>
                                    <strong>{{ $order->payment_firstname }} {{ $order->payment_lastname }}</strong><br>
                                    {{ $order->payment_address_1 }}<br>
                                    @if (!empty($order->payment_address_2))
                                        {{ $order->payment_address_2 }}<br>
                                    @endif
                                    {{ $order->payment_city }} {{ $order->payment_postcode ? '- ' . $order->payment_postcode : '' }}<br>
                                    {{ $order->payment_country ?: 'Bangladesh' }}<br>
                                    <strong>Phone:</strong> {{ $order->payment_phone }}<br>
                                    <strong>Email:</strong> {{ $order->payment_email }}
                                </td>
                                <td width="4%">&nbsp;</td>
                                <td class="address-box">
                                    <div class="address-title">Shipping Details</div>
                                    <strong>{{ $order->shipping_firstname }} {{ $order->shipping_lastname }}</strong><br>
                                    {{ $order->shipping_address_1 }}<br>
                                    @if (!empty($order->shipping_address_2))
                                        {{ $order->shipping_address_2 }}<br>
                                    @endif
                                    {{ $order->shipping_city }} {{ $order->shipping_postcode ? '- ' . $order->shipping_postcode : '' }}<br>
                                    {{ $order->shipping_country ?: 'Bangladesh' }}<br>
                                    <strong>Phone:</strong> {{ $order->shipping_phone ?: $order->payment_phone }}
                                </td>
                            </tr>
                        </table>

                        <!-- Order Items Table -->
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Item Details</th>
                                    <th style="text-align: center; width: 60px;">Qty</th>
                                    <th style="text-align: right; width: 85px;">Price</th>
                                    <th style="text-align: right; width: 95px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($order->items && $order->items->count() > 0)
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="item-name">{{ $item->name ?: ($item->product->name ?? 'Product') }}</div>
                                                @if (!empty($item->model))
                                                    <div style="font-size: 11px; color: #64748b;">SKU/Model: {{ $item->model }}</div>
                                                @endif
                                                @if ($item->options && $item->options->count() > 0)
                                                    <div class="item-options">
                                                        @foreach ($item->options as $opt)
                                                            <span style="display: inline-block; background: #e2e8f0; padding: 1px 6px; border-radius: 3px; margin-right: 4px; margin-top: 2px;">
                                                                {{ ucfirst($opt->name) }}: {{ $opt->value }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">{{ $item->quantity }}</td>
                                            <td style="text-align: right;">{{ $currency }}{{ number_format($item->price, 2) }}</td>
                                            <td style="text-align: right; font-weight: 600;">{{ $currency }}{{ number_format($item->final_price ?: ($item->price * $item->quantity), 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <!-- Order Totals Table -->
                        <table class="totals-table">
                            <tr>
                                <td class="totals-label">Subtotal:</td>
                                <td class="totals-value">{{ $currency }}{{ number_format($order->total, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="totals-label">Shipping:</td>
                                <td class="totals-value">
                                    {{ $order->shipping_charge > 0 ? $currency . number_format($order->shipping_charge, 2) : 'Free' }}
                                </td>
                            </tr>
                            @if ($order->discount > 0)
                                <tr>
                                    <td class="totals-label" style="color: #16a34a;">Discount / Coupon:</td>
                                    <td class="totals-value" style="color: #16a34a;">-{{ $currency }}{{ number_format($order->discount, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="grand-total">
                                <td class="totals-label">Total Amount:</td>
                                <td class="totals-value" style="color: #2563eb;">{{ $currency }}{{ number_format($order->final_amount, 2) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td class="footer">
                        <p style="margin: 0 0 6px 0;">If you have any questions regarding your order, feel free to reply directly to this email.</p>
                        @if (!empty($storePhone))
                            <p style="margin: 0 0 6px 0;">Hotline: {{ $storePhone }} | Support Email: <a href="mailto:{{ $storeEmail }}">{{ $storeEmail }}</a></p>
                        @endif
                        <p style="margin: 10px 0 0 0; color: #94a3b8;">&copy; {{ date('Y') }} {{ $storeName }}. All rights reserved.</p>
                    </td>
                </tr>
            </table>
        </center>
    </div>
</body>
</html>
