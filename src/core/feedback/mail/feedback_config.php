<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

function sendFeedbackMail(string $lang, string $feedback, string $userEmail = ''): bool
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
        $mail->addAddress($_ENV['MAIL_TO']);

        if (!empty($userEmail)) {
            $mail->addReplyTo($userEmail);
        }

        $domain = $_ENV['DOMAIN'];
        $appname = $_ENV['APP_NAME'];

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = "Language Feedback ({$lang})";

        $projectStartYear = $_ENV['PROJECT_START_YEAR'] ?? 2025;
        $currentYear = (int) date("Y");
        $startYear = min((int) $projectStartYear, $currentYear);
        $yearText = ($currentYear > $startYear) ? "$startYear-" . substr($currentYear, -2) : $startYear;

        $safeLang = htmlspecialchars($lang, ENT_QUOTES, 'UTF-8');
        $safeFeedback = nl2br(htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8'));
        $safeEmail = $userEmail ? htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') : 'anonymous-user@mail.in';


$mail->Body = <<<HTML
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!-- Google Fonts: Lexend Deca (some clients will load this) -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;600;700&display=swap"
        rel="stylesheet" />
    <style type="text/css">
    /* Some clients support @import in style blocks inside the head */
    @import url('https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;600;700&display=swap');

    /* Fallback-safe font stacks */
    .body-font {
        font-family: 'Lexend Deca', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
    }

    .heading-font {
        font-family: 'Lexend Deca', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        font-weight: 600;
    }

    /* Small email client safe reset */
    a {
        color: #1d4ed8;
    }
    </style>
</head>

<body class="body-font" style="margin:0;padding:0;background-color:#ffffff;color:#0f172a;">

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
        style="background:#ffffff;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" width="640"
                    style="max-width:640px;width:100%;border-collapse:collapse;text-align:left;">

                    <!-- TITLE -->
                    <tr>
                        <td style="padding-top:28px;padding-bottom:8px;text-align:center;">
                            <h1 class="heading-font"
                                style="font-size:28px;line-height:34px;margin:0;font-weight:600;color:#0f172a;text-align:center;">
                                Feedback Received
                            </h1>
                        </td>
                    </tr>

                    <!-- MAIN CONTENT -->
                    <tr>
                        <td style="padding:18px 16px 8px 16px;background:#ffffff;">
                            <p
                                style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
                                Hi <strong style="color:#0f172a;">Admin</strong>,
                            </p>

                            <p
                                style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
                                <strong style="color:#0f172a;">{$appname}</strong> received a request regarding fix the platform
                                language.
                                We're pleased to confirm that your <strong style="color:#0f172a;">{$appname}</strong>
                                platform has received a greeting or feedback that have been successfully received.
                            </p>

                            <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>

                            <p
                                style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
                                This request was received by the email address:
                                <a href="mailto:{$safeEmail}" style="color:#0f172a;">{$safeEmail}</a>.
                            </p>

                            <p
                                style="font-size:16px;line-height:22px;color:#475569;margin:0 0 16px 0;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
                                🪢 <strong style="color:#0f172a;">Language:</strong> {$safeLang}<br>
                                📄 <strong style="color:#0f172a;">Feedback:</strong> {$safeFeedback}
                            </p>

                            <div style="height:1px;background:#e6e9ef;margin:20px 0;"></div>

                            <p
                                style="font-size:14px;line-height:20px;color:#6b7280;margin:0 0 12px 0;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
                                If you believe this request is invalid or the user has used inappropriate, abusive, harassing or sexual languages
                                in here, delete this mail immediately or reply the user at <a href="mailto:{$safeEmail}" style="color:#0f172a;">{$safeEmail}</a>.
                            </p>

                            <p
                                style="font-size:16px;line-height:18px;color:#475569;margin:18px 0 0 0;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
                                Sincerely,</p>
                            <p
                                style="font-size:16px;line-height:18px;color:#0f172a;font-weight:600;margin:6px 0 0 0;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
                                {$appname} Support</p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="padding:14px 12px 28px 12px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                style="background:#f8fafc;padding:12px;border-radius:6px;">
                                <tr>
                                    <td
                                        style="text-align:center;font-size:12px;color:#6b7280;line-height:20px;font-family:'Lexend Deca', -apple-system, BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">

                                        <div style="margin-bottom:4px;">
                                            <a href="https://{$domain}.in"
                                                style="color:inherit;text-decoration:none;">{$domain}</a> |
                                            <a href="https://{$domain}.in/support"
                                                style="color:inherit;text-decoration:none;">Support</a> |
                                            <a href="https://{$domain}.in/privacy-policy"
                                                style="color:inherit;text-decoration:none;">Privacy Policy</a>
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
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
        }
    }

/**
 * Handle feedback form submission
 * Assumes this is only called for POST feedback submissions
 */
function handleFeedbackForm(array $languages): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        return;

    $lang = $_POST['language'] ?? ($_SESSION['language'] ?? ($languages[0] ?? ''));
    $appname = $_ENV['APP_NAME'];
    $feedback = trim($_POST['feedback']);
    $userEmailInput = trim($_POST['email']);

    // Validate email properly
    $userEmail = '';
    if (!empty($userEmailInput) && filter_var($userEmailInput, FILTER_VALIDATE_EMAIL)) {
        $userEmail = $userEmailInput;
    }

    if ($feedback !== '') {
        $ok = sendFeedbackMail($lang, $feedback, $userEmail);
        $_SESSION['feedbackMessage'] = $ok
            ? "✅ Thanks for your feedback!"
            : "❌ Error sending feedback, try again.";
    } else {
        $_SESSION['feedbackMessage'] = "⚠️ Feedback cannot be empty.";
    }

    header("Location: feedback.php");
    exit;
}

$feedbackMessage = $_SESSION['feedbackMessage'] ?? '';
unset($_SESSION['feedbackMessage']);

// Footer mailto link for contributions
$projectStartYear = isset($_ENV['PROJECT_START_YEAR']) ? (int) $_ENV['PROJECT_START_YEAR'] : 2025;
$yearText = getYearText($projectStartYear);

function getYearText(int $startYear): string
{
    $currentYear = (int) date("Y");
    return ($currentYear > $startYear) ? "$startYear-" . substr($currentYear, -2) : (string) $startYear;
}

function getContributionMailto(string $recipient, string $name, string $country, string $yearText): string
{
    $body = <<<BODY
Hi,

I am interested in contributing on Infra-xodivorce-in, an open-source project intended to help the community and improve public infrastructure transparency. I understand that this is a voluntary, unpaid, open-source contribution and that the project is not intended for revenue generation, ownership claims, or profit-sharing.

I confirm that I have basic knowledge of HTML5, TailwindCSS, JavaScript, Node.js, PHP, and MySQL and I’m comfortable collaborating through GitHub.

I acknowledge that the repository is under the MIT license and Copyright © $yearText Infra-xodivorce-in.

Regards,
$name
$country
BODY;

    return "mailto:$recipient?subject=" . rawurlencode("Infra-xodivorce-in Contribution Application") .
        "&body=" . rawurlencode($body);
}

// Usage
$mailto = getContributionMailto($_ENV['MAIL_TO'], "[Your Name]", "[Your Country/Region]", $yearText);