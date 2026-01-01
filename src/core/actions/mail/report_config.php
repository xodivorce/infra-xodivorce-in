<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require dirname(__DIR__, 2) . '/vendor/autoload.php';

define('IT_HELPDESK_EMAIL', $_ENV['IT_HELPDESK_EMAIL'] ?? '');
define('MANAGEMENT_EMAIL', $_ENV['MANAGEMENT_EMAIL'] ?? '');
define('HEALTH_EMAIL', $_ENV['HEALTH_EMAIL'] ?? '');
define('LIBRARY_EMAIL', $_ENV['LIBRARY_EMAIL'] ?? '');
define('SECURITY_EMAIL', $_ENV['SECURITY_EMAIL'] ?? '');

function getDepartmentEmail($category)
{
    switch ($category) {
        case 'Electrical Issue':
        case 'Water & Plumbing Issue':
        case 'HVAC (AC/Heating) Issue':
        case 'Furniture & Fixtures Issue':
        case 'Road & Pathway Damage Issue':
        case 'Cleaning & Janitorial Issue':
            return MANAGEMENT_EMAIL;

        case 'Security & Safety Issue':
        case 'Lost & Stolen Issue':
            return SECURITY_EMAIL;

        case 'WiFi & Network Issue':
            return IT_HELPDESK_EMAIL;

        case 'Library & Study Issue':
            return LIBRARY_EMAIL;

        case 'Medical/Health Issue':
            return HEALTH_EMAIL;

        case 'Other Issue':
        default:
            return IT_HELPDESK_EMAIL;
    }
}

function sendSMTP($toEmail, $toName, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port = $_ENV['MAIL_PORT'];

        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($toEmail, $toName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error to {$toEmail}: " . $mail->ErrorInfo);
        return false;
    }
}

function sendReportNotifications($report_id, $title, $category, $priority, $location, $username, $user_email, $image_path)
{

    $dept_email = getDepartmentEmail($category);

    $domain = $_ENV['DOMAIN'] ?? $_SERVER['HTTP_HOST'];
    $appname = $_ENV['APP_NAME'];

    $projectStartYear = $_ENV['PROJECT_START_YEAR'];
    $currentYear = (int) date('Y');
    $startYear = min((int) $projectStartYear, $currentYear);
    $yearText = ($currentYear > $startYear) ? "$startYear-" . substr((string) $currentYear, -2) : (string) $startYear;

    $isLocalhost = (
        $domain === 'localhost' ||
        str_starts_with($domain, 'localhost:') ||
        $domain === '127.0.0.1'
    );

    $scheme = $isLocalhost ? 'http://' : 'https://';

    $baseUrl = $scheme . $domain;
    $baseUrl = rtrim($baseUrl, '/');

    $viewLink = $baseUrl . "/core/actions/submit_report.php?view_id=" . urlencode($image_path);

    $dept_subject = "{$appname} - #{$report_id} New report submission received";
    $dept_message = <<<HTML
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
                                 New Report Form Submission Received
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 16px 8px 16px;background:#ffffff;font-family:'Lexend Deca', -apple-system;">
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                                Hi <strong style="color:#0f172a;">{$appname}</strong> Team,
                            </p>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                              <strong style="color:#0f172a;">{$appname}</strong> has received a report submission and the auto-email had sent a "<strong style="color:#0f172a;">Your Report Form Submission Received</strong>" template to the reporter.
                            </p>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                                The report submission details are as follows:
                            </p>
                            <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                                Report ID: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">#{$report_id}</span><br>
                                Reporter ID: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">{$username}</span><br>
                                Title: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">{$title}.</span><br>
                                Issue Category: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">{$category}.</span><br>
                                Priority: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">{$priority}.</span><br>
                                Image: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;"><a href='{$viewLink}' target='_blank' style='color: #0f172a; text-decoration: underline;'>View the attached image</a>.</span><br>
                                Location: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;"><a href='{$location}' target='_blank' style='color: #0f172a; text-decoration: underline;'>View the attached Location</a>.</span><br>
                            </p>
                             <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;">
                                This request was received for the email address:
                                <a href="mailto:{$user_email}" style="color:#0f172a;">{$user_email}</a>.
                            </p>
                            <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>
                            <p style="font-size:14px;line-height:20px;color:#6b7280;margin:0 0 12px 0;font-family:'Lexend Deca', -apple-system;">
                                This is an auto-generated email system for report submissions. If this email successfully reached you, review the details above also respond the issue ASAP & update dashboard.
                            </p>
                            <p style="font-size:16px;line-height:18px;color:#475569;margin:18px 0 0 0;font-family:'Lexend Deca', -apple-system;">
                                Sincerely,
                            </p>
                            <p style="font-size:16px;line-height:18px;color:#0f172a;font-weight:600;margin:6px 0 0 0;font-family:'Lexend Deca', -apple-system;">
                                {$appname} Support
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:14px 12px 28px 12px;font-family:'Lexend Deca', -apple-system;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f8fafc;padding:12px;border-radius:6px;font-family:'Lexend Deca', -apple-system;">
                                <tr>
                                    <td style="text-align:center;font-size:12px;color:#6b7280;line-height:20px;font-family:'Lexend Deca', -apple-system;">
                                        <div style="margin-bottom:4px;font-family:'Lexend Deca', -apple-system;">
                                            <a href="https://{$domain}" style="color:inherit;text-decoration:none;font-family:'Lexend Deca', -apple-system;">{$domain}</a> |
                                            <a href="https://{$domain}/support" style="color:inherit;text-decoration:none;font-family:'Lexend Deca', -apple-system;">Support</a> |
                                            <a href="https://{$domain}/privacy-policy" style="color:inherit;text-decoration:none;font-family:'Lexend Deca', -apple-system;">Privacy Policy</a>
                                        </div>
                                        <div style="font-size:12px;color:#475569;font-family:'Lexend Deca', -apple-system;">
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

    $user_subject = "{$appname} - #{$report_id} Your report submission received";

    $user_message = <<<HTML
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
                                 Your Report Form Submission Received
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 16px 8px 16px;background:#ffffff;font-family:'Lexend Deca', -apple-system;">
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                                Hi <strong style="color:#0f172a;">{$username}</strong>,
                            </p>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                              <strong style="color:#0f172a;">{$appname}</strong> has received a report submission on the platform. 
                              We're pleased to thank you for taking this issue seriously and reporting to us.
                            </p>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                                The report submission details are as follows:
                            </p>
                            <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                                Report ID: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">#{$report_id}</span><br>
                                Title: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">{$title}.</span><br>
                                Issue Category: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">{$category}.</span><br>
                                Priority: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;">{$priority}.</span><br>
                                Image: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;"><a href='{$viewLink}' target='_blank' style='color: #0f172a; text-decoration: underline;'>View the attached image</a>.</span><br>
                                Location: <span style="color:#0f172a;font-family:'Lexend Deca', -apple-system;"><a href='{$location}' target='_blank' style='color: #0f172a; text-decoration: underline;'>View the attached Location</a>.</span><br>
                            </p>
                            <p style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system;">
                                This request was received for the email address:
                                <a href="mailto:{$user_email}" style="color:#0f172a;">{$user_email}</a>.
                            </p>
                            <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>
                            <p style="font-size:14px;line-height:20px;color:#6b7280;margin:0 0 12px 0;font-family:'Lexend Deca', -apple-system;">
                                This is an auto-generated email system for report submissions.
                                If you did not make this report, or believe unauthorised access has occurred, kindly reach out to our IT Helpdesk as soon as possible.
                                However, if you have any new reports, feel free to submit them to us.
                            </p>
                            <p style="font-size:16px;line-height:18px;color:#475569;margin:18px 0 0 0;font-family:'Lexend Deca', -apple-system;">
                                Sincerely,
                            </p>
                            <p style="font-size:16px;line-height:18px;color:#0f172a;font-weight:600;margin:6px 0 0 0;font-family:'Lexend Deca', -apple-system;">
                                {$appname} Support
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:14px 12px 28px 12px;font-family:'Lexend Deca', -apple-system;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f8fafc;padding:12px;border-radius:6px;font-family:'Lexend Deca', -apple-system;">
                                <tr>
                                    <td style="text-align:center;font-size:12px;color:#6b7280;line-height:20px;font-family:'Lexend Deca', -apple-system;">
                                        <div style="margin-bottom:4px;font-family:'Lexend Deca', -apple-system;">
                                            <a href="https://{$domain}" style="color:inherit;text-decoration:none;font-family:'Lexend Deca', -apple-system;">{$domain}</a> |
                                            <a href="https://{$domain}/support" style="color:inherit;text-decoration:none;font-family:'Lexend Deca', -apple-system;">Support</a> |
                                            <a href="https://{$domain}/privacy-policy" style="color:inherit;text-decoration:none;font-family:'Lexend Deca', -apple-system;">Privacy Policy</a>
                                        </div>
                                        <div style="font-size:12px;color:#475569;font-family:'Lexend Deca', -apple-system;">
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

    $sentToDept = sendSMTP($dept_email, 'Campus Department', $dept_subject, $dept_message);
    $sentToUser = sendSMTP($user_email, $username, $user_subject, $user_message);

    return ($sentToDept && $sentToUser);
}
?>