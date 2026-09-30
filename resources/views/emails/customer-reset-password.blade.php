<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1e293b;
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
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f1f5f9;
            padding: 40px 15px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 580px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 36px 40px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 22px;
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.3px;
        }
        .header p {
            color: #94a3b8;
            font-size: 13px;
            margin: 6px 0 0 0;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .content {
            padding: 40px 40px 32px;
        }
        .greeting {
            font-size: 17px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 16px;
        }
        .message-text {
            font-size: 14px;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 24px;
        }
        .btn-wrapper {
            text-align: center;
            margin: 32px 0;
        }
        .btn-reset {
            display: inline-block;
            background-color: #0f172a;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }
        .security-notice {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }
        .security-notice strong {
            color: #334155;
        }
        .link-fallback {
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            margin-top: 24px;
            font-size: 12px;
            color: #64748b;
            word-break: break-all;
        }
        .link-fallback a {
            color: #2563eb;
            text-decoration: underline;
        }
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 24px 40px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
        .footer p {
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" align="center" cellpadding="0" cellspacing="0" width="100%">
            <!-- Header -->
            <tr>
                <td class="header">
                    <h1>{{ $storeName }}</h1>
                    <p>Security & Access Control</p>
                </td>
            </tr>

            <!-- Body Content -->
            <tr>
                <td class="content">
                    <div class="greeting">
                        Hello {{ !empty($customer->firstname) ? $customer->firstname : 'Valued Customer' }},
                    </div>

                    <p class="message-text">
                        We received a request to reset the password associated with your <strong>{{ $storeName }}</strong> account ({{ $customer->email }}).
                    </p>

                    <div class="btn-wrapper">
                        <a href="{{ $resetUrl }}" class="btn-reset" target="_blank">
                            Reset Your Password &rarr;
                        </a>
                    </div>

                    <div class="security-notice">
                        <strong>Security Information:</strong>
                        <ul style="margin: 6px 0 0 0; padding-left: 18px;">
                            <li>This password reset link will expire in <strong>{{ $expireMinutes }} minutes</strong>.</li>
                            <li>If you did not initiate this password reset request, please disregard this email. Your password will remain unchanged and secure.</li>
                        </ul>
                    </div>

                    <div class="link-fallback">
                        If the button above does not work, copy and paste the following URL into your web browser:<br>
                        <a href="{{ $resetUrl }}" target="_blank">{{ $resetUrl }}</a>
                    </div>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p>&copy; {{ date('Y') }} {{ $storeName }}. All rights reserved.</p>
                    @if(!empty($storeAddress))
                        <p>{{ $storeAddress }}</p>
                    @endif
                    @if(!empty($storeEmail))
                        <p>Questions? Contact us at <a href="mailto:{{ $storeEmail }}" style="color: #64748b;">{{ $storeEmail }}</a></p>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
