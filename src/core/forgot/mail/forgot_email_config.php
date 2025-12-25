<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

function sendForgotEmail(string $email, string $username): bool
{
    $mail = new PHPMailer(true);

    try {
        $domain           = $_ENV['DOMAIN'];
        $company          = $_ENV['COMPANY_NAME'];
        $projectStartYear = $_ENV['PROJECT_START_YEAR'];
        $currentYear      = (int) date('Y');
        $startYear        = min((int) $projectStartYear, $currentYear);
        $domainLower      = strtolower($domain);
        $yearText         = ($currentYear > $startYear)
            ? "$startYear-" . substr((string) $currentYear, -2)
            : (string) $startYear;

        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port       = (int) $_ENV['MAIL_PORT'];

        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = "Your {$domain} Account Confirmation";

        $mail->Body = <<<HTML
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;600;700&display=swap');
        .body-font {
            font-family: 'Lexend Deca', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
        .heading-font {
            font-family: 'Lexend Deca', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            font-weight: 600;
        }
        a { color: #1d4ed8; }
    </style>
</head>
<body class="body-font" style="margin:0;padding:0;background-color:#ffffff;color:#0f172a;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#ffffff;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" width="640" style="max-width:640px;width:100%;border-collapse:collapse;text-align:left;">
                    <tr>
                        <td style="padding-top:28px;padding-bottom:8px;text-align:center;">
                            <h1 class="heading-font" style="font-size:28px;line-height:34px;margin:0;font-weight:600;color:#0f172a;text-align:center;">
                                Account Confirmation
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 16px 8px 16px;background:#ffffff;">
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                                Hi <strong style="color:#0f172a;">{$username}</strong>,
                            </p>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                                <strong style="color:#0f172a;">{$domain}</strong> received a request to recover your email. We're pleased to confirm that your
                                <strong style="color:#0f172a;">{$domain}</strong> account has been successfully reached.
                            </p>
                            <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                                This request was received for the email address:
                                <a href="mailto:{$email}" style="color:#0f172a;">{$email}</a>.
                            </p>
                            <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>
                            <p style="font-size:14px;line-height:20px;color:#6b7280;margin:0 0 12px 0;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
                                If you did not make this request or believe unauthorised access has occurred, you may safely ignore this email, 
                                as no further action is required on your part.
                            </p>
                            <p style="font-size:16px;line-height:18px;color:#475569;margin:18px 0 0 0;">
                                Sincerely,
                            </p>
                            <p style="font-size:16px;line-height:18px;color:#0f172a;font-weight:600;margin:6px 0 0 0;">
                                {$domain} Support
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
                                            &copy; {$yearText} {$domain}. All rights reserved.
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
        error_log('Failed to send forgot email: ' . $e->getMessage());
        return false;
    }
}
