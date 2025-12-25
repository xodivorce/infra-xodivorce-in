<?php
session_start();

// Initialize the application
include './core/init.php';
include './core/connection.php';
include './core/languages/language_config.php';
include './core/auth/mail/forgot_password_config.php';

// Suppress all PHP errors in production environment
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

$error = '';
$username = null; // for mail display name

// Ensure the email session exists
if (empty($_SESSION['signin_email'])) {
    header('Location: sign_in_email.php');
    exit;
}

$email = $_SESSION['signin_email'];

// Fetch current translations (if needed)
$current_language = $_SESSION['language'] ?? $languages[0];
$current_texts = getTranslations($conn, $current_language);

/**
 * Handle "Forgot password" – generate OTP, store in DB, send mail, redirect.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'forgot_password') {
    try {
        // Fetch user id + username
        $user_id = null;
        $username = null;

        $userStmt = $conn->prepare("SELECT id, username FROM users WHERE email = ? LIMIT 1");
        if ($userStmt) {
            $userStmt->bind_param("s", $email);
            $userStmt->execute();
            $userStmt->bind_result($uid, $uname);
            if ($userStmt->fetch()) {
                $user_id = $uid;
                $username = $uname;
            }
            $userStmt->close();
        }

        // 6-digit OTP
        $otp = (string) random_int(100000, 999999);

        // Salt + hash
        $token_salt = bin2hex(random_bytes(16)); // 32 chars
        $token_hash = hash('sha256', $token_salt . $otp);

        // Expiry (3 minutes)
        $expires_at = (new DateTime('+3 minutes'))->format('Y-m-d H:i:s');

        // IP + user agent
        $ip_address = !empty($_SERVER['REMOTE_ADDR']) ? inet_pton($_SERVER['REMOTE_ADDR']) : null;
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $ip_for_db = $ip_address !== null ? $ip_address : '';

        // Insert into password_resets
        $resetStmt = $conn->prepare("
            INSERT INTO password_resets (user_id, email, token_hash, token_salt, expires_at, attempts, ip_address, user_agent, used)
            VALUES (?, ?, ?, ?, ?, 0, ?, ?, 0)
        ");

        if (!$resetStmt) {
            $error = t('database_prepare_failed');
        } else {
            $resetStmt->bind_param(
                "issssss",
                $user_id,
                $email,
                $token_hash,
                $token_salt,
                $expires_at,
                $ip_for_db,
                $user_agent
            );
            $resetStmt->execute();
            $resetStmt->close();

            // Make sure the mailer function exists
            if (!function_exists('sendPasswordResetMail')) {
                $error = t('email_send_failed');
            } else {
                // fall back to email local-part if username is null
                $displayName = $username ?: explode('@', $email)[0];

                $sent = sendPasswordResetMail($email, $displayName, $otp);

                if ($sent) {
                    // Store success notice for next page
                    $_SESSION['reset_notice'] = t('reset_email_sent_notice');

                    // Only redirect when mail actually sent
                    header('Location: forgot_password.php');
                    exit;
                } else {
                    $error = t('email_send_failed');
                }
            }
        }
    } catch (Throwable $e) {
        $error = t('unexpected_error');
    }
}

/**
 * Handle normal password verification (login)
 */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action']) && $_POST['action'] === 'login' &&
    isset($_POST['password'])
) {
    $password = trim($_POST['password']);

    if (empty($password)) {
        $error = t('empty_password_error');
    } else {
        $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE email = ? LIMIT 1");

        if (!$stmt) {
            $error = t('database_prepare_failed');
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_email'] = $email;

                    // Fetch username for display
                    $user_stmt = $conn->prepare("SELECT username FROM users WHERE id = ? LIMIT 1");
                    $user_stmt->bind_param("i", $user_id);
                    $user_stmt->execute();
                    $user_stmt->bind_result($username);
                    $user_stmt->fetch();
                    $_SESSION['user_name'] = $username;
                    $user_stmt->close();

                    unset($_SESSION['signin_email']);
                    header('Location: home.php');
                    exit;
                } else {
                    $error = t('incorrect_password');
                }
            } else {
                $error = t('account_not_found');
            }

            $stmt->close();
        }
    }
}

// Handle language selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language']) && in_array($_POST['language'], $languages, true)) {
    $_SESSION['language'] = $_POST['language'];
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta & Viewport Configuration -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon & PWA Assets -->
    <link rel="icon" type="image/png" href="./assets/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./assets/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="./assets/favicon/site.webmanifest" />
    <meta name="apple-mobile-web-app-title" content="SteamsTube" />

    <!-- Main Stylesheet (Tailwind CSS) -->
    <link rel="stylesheet" href="./src/output.css">

    <!-- Google Fonts: Lexend Deca -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

    <!-- Dynamic Page Title (from .env DOMAIN variable) -->
    <title><?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?></title>

    <!-- Debug Kit: Optional outline borders (toggled via .env DEBUG_MODE) -->
    <?php include 'assets/_debug_kit.php'; ?>
</head>

<body class="bg-neutral-900 text-gray-200 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-5xl mx-auto flex flex-col">
        <main class="bg-black border border-neutral-900 rounded-4xl w-full max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 min-h-[400px]">

                <!-- Left Side -->
                <div class="p-8 md:p-12 flex flex-col self-start text-center md:text-left items-center md:items-start">
                    <div class="flex items-center mb-6">
                        <img src="./assets/images/logos/xovae.svg" class="h-14 w-auto rounded-full bg-neutral-900"
                            alt="xovae-logo" />
                    </div>
                    <h1 class="text-3xl font-normal text-gray-200 mb-2"><?php echo t('sign_in'); ?></h1>
                    <p class="text-gray-400">
                        <?php echo t('continue_to'); ?>
                        <span
                            class="font-youtube text-lg"><?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?></span>
                    </p>
                </div>

                <!-- Right Side -->
                <div class="p-8 md:p-12 flex flex-col justify-center -mt-4 lg:mt-10">
                    <form method="post" class="w-full">

                        <?php if (!empty($error)): ?>
                            <p class="text-red-500 text-sm mb-2"><?php echo htmlspecialchars($error); ?></p>
                        <?php endif; ?>

                        <div class="mb-1">
                            <input type="password" id="password" name="password"
                                placeholder="<?php echo t('password_placeholder'); ?>"
                                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200 form-input">
                        </div>

                        <div class="mb-6">
                            <!-- Forgot password now submits this form with action=forgot_password -->
                            <button type="submit" name="action" value="forgot_password"
                                class="text-sm text-gray-400 hover:underline bg-transparent border-none p-0 cursor-pointer">
                                <?php echo t('forgot_password'); ?>
                            </button>
                        </div>

                        <p class="text-sm text-gray-200 mb-6">
                            <button type="button" id="togglePasswordBtn" data-show="<?php echo t('reveal_password'); ?>"
                                data-hide="<?php echo t('hide_password'); ?>"
                                class="text-sm font-medium text-gray-200 hover:underline bg-transparent border-none p-0 cursor-pointer self-start">
                                <?php echo t('reveal_password'); ?>
                            </button>

                            <button type="button"
                                onclick="window.open('https://support.google.com/chrome/answer/6130773','_blank')"
                                class="font-medium text-gray-400 hover:underline bg-transparent border-none p-0 cursor-pointer">
                                <?php echo t('learn_more'); ?>
                            </button>
                        </p>

                        <div class="flex flex-row items-center justify-end gap-4">
                            <button type="button" onclick="window.location.href='sign_in_email.php'"
                                class="text-gray-200 font-medium px-6 py-2.5 rounded-3xl transition duration-200 hover:bg-neutral-900 hover:text-gray-200 cursor-pointer">
                                <?php echo t('back'); ?>
                            </button>
                            <button type="submit" name="action" value="login" id="nextBtn"
                                class="bg-neutral-800 hover:bg-neutral-700 text-gray-200 font-medium px-6 py-2.5 rounded-3xl transition duration-200 cursor-pointer">
                                <?php echo t('proceed'); ?>
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-0 w-full p-4">
            <div
                class="max-w-4xl mx-auto flex flex-col sm:flex-row justify-between items-center text-xs text-gray-400 space-y-2 sm:space-y-0">
                <div>
                    <form id="langForm" method="post" class="inline-block">
                        <select name="language" onchange="document.getElementById('langForm').submit()"
                            class="bg-transparent border-none text-gray-200 focus:outline-none pr-2 cursor-pointer">
                            <?php foreach ($languages as $lang): ?>
                                <option value="<?php echo htmlspecialchars($lang); ?>" <?php echo ($current_language === $lang) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($lang); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <div class="flex space-x-6">
                    <button type="button"
                        class="hover:text-gray-200 bg-transparent border-none p-0 text-xs cursor-pointer"><?php echo nl2br(t('help')); ?></button>
                    <button type="button"
                        class="hover:text-gray-200 bg-transparent border-none p-0 text-xs cursor-pointer"><?php echo nl2br(t('privacy')); ?></button>
                    <button type="button"
                        class="hover:text-gray-200 bg-transparent border-none p-0 text-xs cursor-pointer"><?php echo nl2br(t('terms')); ?></button>
                    <button type="button" onclick="window.location.href='feedback.php'"
                        class="hover:text-gray-200 bg-transparent border-none p-0 text-xs whitespace-preline text-left cursor-pointer"><?php echo nl2br(t('bug')); ?></button>
                </div>
            </div>
        </footer>
    </div>

</body>

<!-- Scripts -->
<script src="assets/js/sign_in_config.js"></script>

</html>