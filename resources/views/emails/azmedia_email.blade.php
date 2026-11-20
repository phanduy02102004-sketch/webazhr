<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1e293b;
        }
        .wrapper {
            max-width: 620px;
            margin: 32px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        /* Header */
        .header {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
            padding: 32px 40px;
            text-align: center;
        }
        .header-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        .logo-box {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.25);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
            color: #fff;
            letter-spacing: -1px;
        }
        .logo-text {
            text-align: left;
        }
        .logo-text .brand {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }
        .logo-text .tagline {
            font-size: 11px;
            color: rgba(255,255,255,0.8);
            margin-top: 2px;
        }
        .header-title {
            color: #fff;
            font-size: 13px;
            opacity: 0.9;
            margin-top: 4px;
        }
        /* Body */
        .content {
            padding: 36px 40px;
        }
        /* Footer */
        .footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 40px;
            text-align: center;
        }
        .footer p {
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.8;
        }
        .footer .company {
            font-weight: 700;
            color: #64748b;
        }
        .footer .social a {
            display: inline-block;
            margin: 0 6px;
            color: #94a3b8;
            font-size: 11px;
            text-decoration: none;
        }
        /* Responsive */
        @media(max-width: 640px) {
            .wrapper { margin: 0; border-radius: 0; }
            .content, .footer { padding: 24px 20px; }
            .header { padding: 24px 20px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Header Brand -->
        <div class="header">
            <div class="header-logo">
                <div class="logo-box">AZ</div>
                <div class="logo-text">
                    <div class="brand">AZ<span style="color:#ffffff">HR</span></div>
                    <div class="tagline">Hệ Thống Tuyển Dụng Thực Tập Sinh AZ Media · Đà Nẵng</div>
                </div>
            </div>
            <div class="header-title">📩 Thư thông báo chính thức từ Ban Tuyển Dụng</div>
        </div>

        <!-- Dynamic Email Body from Template -->
        <div class="content">
            {!! $bodyHtml !!}
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="company">Công ty Cổ phần Truyền thông AZ Media</p>
            <p>84 Nguyễn Hữu Dật, P. Hòa Cường Nam, Q. Hải Châu, TP. Đà Nẵng</p>
            <p>📞 0236 XXXX XXX &nbsp;|&nbsp; 🌐 azmedia.com.vn &nbsp;|&nbsp; ✉️ hr@azmedia.com.vn</p>
            <div class="social" style="margin-top:8px;">
                <a href="https://www.facebook.com/share/1A5N2tisXh/?mibextid=wwXIfr" target="_blank">Facebook Fanpage</a> · <a href="https://azmedia.com.vn/" target="_blank">Website</a>
            </div>
            <p style="margin-top:10px; font-size:10px; color:#cbd5e1;">
                Email này được gửi tự động từ hệ thống. Vui lòng không trả lời trực tiếp email này.<br>
                © 2026 AZ Media Corporation. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
