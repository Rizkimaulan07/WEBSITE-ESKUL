<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
</head>
<body style="margin:0;padding:0;background-color:#f0f7ff;font-family:'Segoe UI',Helvetica,Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0f7ff;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 12px 40px rgba(14,165,233,0.12);">
                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#0c4a6e,#0ea5e9);padding:36px 32px;text-align:center;">
                            <div style="font-size:20px;font-weight:800;color:#ffffff;letter-spacing:1px;">SIMSKUL</div>
                            <div style="font-size:12px;color:rgba(255,255,255,0.8);margin-top:4px;">Sistem Manajemen Ekstrakurikuler</div>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding:36px 32px;">
                            <h2 style="margin:0 0 8px;color:#0f172a;font-size:20px;">Yth. {{ $nama ?? 'Pengguna' }},</h2>
                            <p style="margin:0 0 20px;color:#475569;font-size:14px;line-height:1.6;">
                                Kami menerima permintaan untuk <strong>reset password</strong> akun Anda di <strong>SIMSKUL</strong>.
                            </p>

                            <p style="margin:0 0 12px;color:#475569;font-size:14px;">Gunakan kode OTP berikut untuk melanjutkan:</p>

                            <div style="background:#f0f9ff;border:2px dashed #0ea5e9;border-radius:14px;padding:24px;text-align:center;margin:0 0 20px;">
                                <span style="font-size:36px;font-weight:800;letter-spacing:10px;color:#0ea5e9;">{{ $otp }}</span>
                            </div>

                            <p style="margin:0 0 6px;font-size:13px;color:#475569;line-height:1.6;">
                                <strong>Penting:</strong> Kode ini berlaku selama <strong>{{ $expiry }} menit</strong>. Jangan bagikan kepada siapa pun.
                            </p>
                            <p style="margin:0;font-size:13px;color:#475569;line-height:1.6;">
                                Jika Anda tidak melakukan permintaan ini, Anda dapat mengabaikan email ini.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8fafc;padding:18px 32px;text-align:center;border-top:1px solid #eef2f7;">
                            <p style="margin:0;color:#64748b;font-size:12px;">&copy; {{ date('Y') }} SIMSKUL &middot; SMK BPPI Baleendah</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
