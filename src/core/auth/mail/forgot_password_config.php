<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

function sendPasswordResetMail(string $email, string $username, string $otp): bool
{
    $mail = new PHPMailer(true);

    try {
        $domain = $_ENV['DOMAIN'];
        $appname = $_ENV['APP_NAME'];
        $projectStartYear = $_ENV['PROJECT_START_YEAR'];
        $currentYear = (int) date('Y');
        $startYear = min((int) $projectStartYear, $currentYear);
        $yearText = ($currentYear > $startYear)
            ? $startYear . '-' . substr((string) $currentYear, -2)
            : (string) $startYear;

        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port = (int) $_ENV['MAIL_PORT'];

        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = "Your {$appname} Account Password Reset OTP";

        $mail->Body = <<<HTML
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;600;700&display=swap');
        .body-font { font-family: 'Lexend Deca', -apple-system !important; }
        .heading-font { font-family: 'Lexend Deca', -apple-system !important; font-weight: 600; }
        a { color: #1d4ed8; }
    </style>
</head>
<body class="body-font" style="margin:0;padding:0;background-color:#ffffff;color:#0f172a;font-family:'Lexend Deca', -apple-system;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#ffffff;padding:24px 12px;font-family:'Lexend Deca', -apple-system;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" width="640" style="max-width:640px;width:100%;border-collapse:collapse;text-align:left;font-family:'Lexend Deca', -apple-system;">
                <tr>
                    <td style="padding-top:28px;padding-bottom:8px;text-align:center;">
                        <h1 class="heading-font" style="font-size:28px;line-height:34px;margin:0;font-weight:600;color:#0f172a;text-align:center;font-family:'Lexend Deca', -apple-system;">
                            Password Reset
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 16px 8px 16px;background:#ffffff;font-family:'Lexend Deca', -apple-system;">
                        <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                            Hi <strong style="color:#0f172a;">{$username}</strong>,
                        </p>
                        <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                            <strong style="color:#0f172a;">{$appname}</strong> received a request for resetting your password.
                            We're pleased to confirm that your <strong style="color:#0f172a;">{$appname}</strong>
                            account can be reset via OTP verification.
                        </p>
                        <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>
                        <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                            This request was received for the email address:
                            <a href="mailto:{$email}" style="color:#0f172a;">{$email}</a>.
                        </p>
                        <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                            ♻️ <strong style="color:#0f172a;">OTP:</strong> {$otp}<br>
                            📄 <strong style="color:#0f172a;">Validity:</strong> Expires within 3 minutes.<br>
                        </p>
                        <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>
                        <p style="font-size:14px;line-height:20px;color:#6b7280;margin:0 0 12px 0;">
                            If you did not make this request or believe unauthorised access has occurred, you may safely ignore this email.
                            Do not share this OTP with anyone, as it could allow them to access your account.
                        </p>
                        <p style="font-size:16px;line-height:18px;color:#475569;margin:18px 0 0 0;">
                            Sincerely,
                        </p>
                        <p style="font-size:16px;line-height:18px;color:#0f172a;font-weight:600;margin:6px 0 0 0;">
                            {$appname} Support
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:14px 12px 28px 12px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f8fafc;padding:12px;border-radius:6px;">
                            <tr>
                                <td style="text-align:center;font-size:12px;color:#6b7280;line-height:20px;">
                                    <div style="margin-bottom:4px;">
                                        <a href="https://{$domain}.in" style="color:inherit;text-decoration:none;">{$domain}</a> |
                                        <a href="https://{$domain}.in/support" style="color:inherit;text-decoration:none;">Support</a> |
                                        <a href="https://{$domain}.in/privacy-policy" style="color:inherit;text-decoration:none;">Privacy Policy</a>
                                    </div>
                                    <div style="font-size:12px;color:#475569;">
                                        &copy; {$yearText} {$appname}. All rights reserved.
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
HTML;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendPasswordResetSuccessMail(string $email, string $username): bool
{
    $mail = new PHPMailer(true);

    try {
        $domain = $_ENV['DOMAIN'];
        $appname = $_ENV['APP_NAME'];
        $projectStartYear = $_ENV['PROJECT_START_YEAR'];
        $currentYear = (int) date('Y');
        $startYear = min((int) $projectStartYear, $currentYear);
        $yearText = ($currentYear > $startYear)
            ? $startYear . '-' . substr((string) $currentYear, -2)
            : (string) $startYear;

        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port = (int) $_ENV['MAIL_PORT'];

        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = "Your {$domain} Account Password Was Reset";

        $mail->Body = <<<HTML
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Lexend+Deca&wght@300;400;600;700&display=swap');
        .body-font { font-family: 'Lexend Deca', -apple-system !important; }
        .heading-font { font-family: 'Lexend Deca', -apple-system !important; font-weight: 600; }
        a { color: #1d4ed8; }
    </style>
</head>
<body class="body-font" style="margin:0;padding:0;background-color:#ffffff;color:#0f172a;font-family:'Lexend Deca', -apple-system;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#ffffff;padding:24px 12px;font-family:'Lexend Deca', -apple-system;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" width="640" style="max-width:640px;width:100%;border-collapse:collapse;text-align:left;font-family:'Lexend Deca', -apple-system;">
                <tr>
                    <td style="padding-top:28px;padding-bottom:8px;text-align:center;">
                        <h1 class="heading-font" style="font-size:28px;line-height:34px;margin:0;font-weight:600;color:#0f172a;text-align:center;font-family:'Lexend Deca', -apple-system;">
                            Password Successfully Reset
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 16px 8px 16px;background:#ffffff;font-family:'Lexend Deca', -apple-system;">
                        <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                            Hi <strong style="color:#0f172a;">{$username}</strong>,
                        </p>
                        <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                            <strong style="color:#0f172a;">{$appname}</strong> received a request for resetting your password.
                            We're pleased to confirm that your <strong style="color:#0f172a;">{$appname}</strong>
                            account's password has been updated.
                        </p>
                        <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                            This request was received for the email address:
                            <a href="mailto:{$email}" style="color:#0f172a;">{$email}</a>.
                        </p>

                        <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>

                        <p style="font-size:14px;line-height:20px;color:#6b7280;margin:0 0 12px 0;">
                            If you did not make this request, or you believe an unauthorised person has accessed your data,
                            request an account recovery immediately by reaching out to us at this email address.
                        </p>
                        <p style="font-size:16px;line-height:18px;color:#475569;margin:18px 0 0 0;">
                            Sincerely,
                        </p>
                        <p style="font-size:16px;line-height:18px;color:#0f172a;font-weight:600;margin:6px 0 0 0;">
                            {$appname} Support
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:14px 12px 28px 12px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f8fafc;padding:12px;border-radius:6px;">
                            <tr>
                                <td style="text-align:center;font-size:12px;color:#6b7280;line-height:20px;">
                                    <div style="margin-bottom:4px;">
                                        <a href="https://{$domain}.in" style="color:inherit;text-decoration:none;">{$domain}</a> |
                                        <a href="https://{$domain}.in/support" style="color:inherit;text-decoration:none;">Support</a> |
                                        <a href="https://{$domain}.in/privacy-policy" style="color:inherit;text-decoration:none;">Privacy Policy</a>
                                    </div>
                                    <div style="font-size:12px;color:#475569;">
                                        &copy; {$yearText} {$appname}. All rights reserved.
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
HTML;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
