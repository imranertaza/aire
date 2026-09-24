<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update #{{ $order->id }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
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
            max-width: 600px;
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
            font-size: 24px;
            margin: 0;
            font-weight: 700;
        }
        .content {
            padding: 35px 40px;
        }
        .status-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }
        .status-label {
            font-size: 13px;
            color: #3b82f6;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .status-badge {
            font-size: 22px;
            font-weight: 800;
            color: #1e40af;
        }
        .comment-card {
            background-color: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 16px 20px;
            border-radius: 0 6px 6px 0;
            margin-bottom: 25px;
            font-size: 14px;
            color: #334155;
        }
        .comment-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .order-meta {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        .order-meta td {
            padding: 10px 14px;
            font-size: 13px;
            border-bottom: 1px solid #f1f5f9;
        }
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 25px 40px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
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
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td class="content">
                        <h2 style="font-size: 18px; color: #0f172a; margin-top: 0;">Hello {{ $order->firstname }},</h2>
                        <p style="color: #475569; font-size: 15px;">
                            The status of your order <strong>#{{ $order->id }}</strong> has been updated.
                        </p>

                        <!-- Status Highlight -->
                        <div class="status-box">
                            <div class="status-label">Current Order Status</div>
                            <div class="status-badge">{{ $statusName }}</div>
                        </div>

                        <!-- Admin Note / Comment -->
                        @if (!empty($comment))
                            <div class="comment-card">
                                <div class="comment-title">Message from Store:</div>
                                {{ $comment }}
                            </div>
                        @endif

                        <!-- Brief Meta Info -->
                        <table class="order-meta">
                            <tr>
                                <td style="color: #64748b; width: 40%;"><strong>Order ID:</strong></td>
                                <td style="color: #0f172a;">#{{ $order->id }} (Invoice: #{{ $order->invoice_no ?: $order->id }})</td>
                            </tr>
                            <tr>
                                <td style="color: #64748b;"><strong>Order Date:</strong></td>
                                <td style="color: #0f172a;">{{ $order->created_at ? $order->created_at->format('F d, Y') : date('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td style="color: #64748b;"><strong>Total Amount:</strong></td>
                                <td style="color: #0f172a; font-weight: 700;">{{ $currency }}{{ number_format($order->final_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="color: #64748b;"><strong>Payment Status:</strong></td>
                                <td style="color: #0f172a;">{{ $order->payment_status ?: 'Pending' }}</td>
                            </tr>
                        </table>

                        <p style="color: #64748b; font-size: 13px; margin-bottom: 0;">
                            Thank you for shopping with us! If you have any inquiries, feel free to reply directly to this email.
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td class="footer">
                        @if (!empty($storePhone))
                            <p style="margin: 0 0 6px 0;">Phone: {{ $storePhone }} | Support: {{ $storeEmail }}</p>
                        @endif
                        <p style="margin: 0; color: #94a3b8;">&copy; {{ date('Y') }} {{ $storeName }}. All rights reserved.</p>
                    </td>
                </tr>
            </table>
        </center>
    </div>
</body>
</html>
