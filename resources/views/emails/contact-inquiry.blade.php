<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Inquiry</title>
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
            max-width: 600px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 32px 36px;
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
            color: #38bdf8;
            font-size: 12px;
            margin: 6px 0 0 0;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 600;
        }
        .content {
            padding: 36px 36px 28px 36px;
        }
        .badge {
            display: inline-block;
            background-color: #e0f2fe;
            color: #0369a1;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .meta-table {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-top: 16px;
            margin-bottom: 24px;
        }
        .meta-table td {
            padding: 12px 18px;
            border-bottom: 1px solid #edf2f7;
            font-size: 14px;
        }
        .meta-table tr:last-child td {
            border-bottom: none;
        }
        .meta-label {
            width: 32%;
            font-weight: 600;
            color: #64748b;
        }
        .meta-value {
            color: #0f172a;
            font-weight: 500;
        }
        .message-box {
            background-color: #fdfdfd;
            border-left: 4px solid #0284c7;
            border-top: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 0 10px 10px 0;
            padding: 18px 20px;
            font-size: 14px;
            color: #334155;
            line-height: 1.7;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .btn-reply {
            display: inline-block;
            background: #0284c7;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 24px;
        }
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 24px 36px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table role="presentation" class="main" align="center">
            <!-- Header -->
            <tr>
                <td class="header">
                    <h1>{{ $storeName }}</h1>
                    <p>New Storefront Inquiry Notification</p>
                </td>
            </tr>

            <!-- Content -->
            <tr>
                <td class="content">
                    <span class="badge">Customer Support</span>
                    <h2 style="font-size: 18px; margin: 0 0 8px 0; color: #0f172a; font-weight: 700;">
                        You have received a new contact message
                    </h2>
                    <p style="color: #64748b; font-size: 13px; margin: 0 0 16px 0;">
                        Received on {{ $submittedAt }} via the website contact form.
                    </p>

                    <!-- Sender Info -->
                    <table class="meta-table" role="presentation">
                        <tr>
                            <td class="meta-label">Full Name</td>
                            <td class="meta-value">{{ $contact['name'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Email Address</td>
                            <td class="meta-value">
                                <a href="mailto:{{ $contact['email'] ?? '' }}" style="color: #0284c7; text-decoration: none; font-weight: 600;">
                                    {{ $contact['email'] ?? 'N/A' }}
                                </a>
                            </td>
                        </tr>
                        @if(!empty($contact['phone']))
                        <tr>
                            <td class="meta-label">Phone Number</td>
                            <td class="meta-value">
                                <a href="tel:{{ $contact['phone'] }}" style="color: #334155; text-decoration: none;">
                                    {{ $contact['phone'] }}
                                </a>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="meta-label">Subject / Topic</td>
                            <td class="meta-value" style="font-weight: 600; color: #0f172a;">
                                {{ $contact['subject'] ?? 'General Inquiry' }}
                            </td>
                        </tr>
                    </table>

                    <!-- Message Section -->
                    <h3 style="font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin: 20px 0 8px 0;">
                        Message Content
                    </h3>
                    <div class="message-box">{{ $contact['message'] ?? '' }}</div>

                    <!-- Direct Reply Action -->
                    <div style="text-align: center;">
                        <a href="mailto:{{ $contact['email'] }}?subject={{ rawurlencode('Re: ' . ($contact['subject'] ?? 'Your inquiry at ' . $storeName)) }}" class="btn-reply">
                            Reply to {{ $contact['name'] ?? 'Sender' }} &rarr;
                        </a>
                    </div>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="footer">
                    <p style="margin: 0 0 6px 0;">
                        This automated notification was generated by the <strong>{{ $storeName }}</strong> storefront system.
                    </p>
                    <p style="margin: 0;">
                        Need assistance? Contact <a href="mailto:{{ $storeEmail }}" style="color: #64748b;">{{ $storeEmail }}</a>
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
