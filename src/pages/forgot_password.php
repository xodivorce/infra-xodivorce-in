<?php
// Start the session
session_start();

// Initialize the application
include './../core/init.php';
include './../core/connection.php';
include './../core/languages/language_config.php';
include './../core/auth/mail/forgot_password_config.php';  // sendPasswordResetSuccessMail() - success mail

// Suppress all PHP errors in production environment
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

$error = '';
$reset_notice = '';

// Ensure the email session exists (same as in sign_in_password.php)
if (empty($_SESSION['signin_email'])) {
  header('Location: sign_in_email.php');
  exit;
}

$email = $_SESSION['signin_email'];

// Language handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language']) && in_array($_POST['language'], $languages, true)) {
  $_SESSION['language'] = $_POST['language'];
  header('Location: ' . $_SERVER['REQUEST_URI']);
  exit;
}

$current_language = $_SESSION['language'] ?? $languages[0];
$current_texts = getTranslations($conn, $current_language);
$selected_language = $current_language;

// If we came from previous page after first send, show that notice (PERSIST across refresh)
if (!empty($_SESSION['reset_notice'])) {
  $reset_notice = $_SESSION['reset_notice']; // no unset anymore
}

// cooldown remaining seconds for resend button (persists across refresh)
$cooldown_remaining = 0;
if (!empty($_SESSION['resend_cooldown_until'])) {
  $cooldown_remaining = $_SESSION['resend_cooldown_until'] - time();
  if ($cooldown_remaining <= 0) {
    $cooldown_remaining = 0;
    unset($_SESSION['resend_cooldown_until']);
  }
}

/**
 * Handle "Resend email" – generate a new OTP, store in DB, send mail, show notice.
 */
if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  && isset($_POST['action'])
  && $_POST['action'] === 'resend_email'
) {
  // If cooldown is still active, just re-show the static notice (no countdown here)
  if ($cooldown_remaining > 0) {
    $defaultNotice = t('reset_email_sent_notice');
    if (empty($_SESSION['reset_notice'])) {
      $_SESSION['reset_notice'] = $current_texts['reset_email_sent_notice'] ?? $defaultNotice;
    }
    $reset_notice = $_SESSION['reset_notice'];
  } else {
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

        if (!function_exists('sendPasswordResetMail')) {
          $error = t('email_send_failed');
        } else {
          $displayName = $username ?: explode('@', $email)[0];

          $sent = sendPasswordResetMail($email, $displayName, $otp);

          if ($sent) {
            // Static notice (no countdown text here)
            $defaultNotice = t('reset_email_sent_notice');
            $_SESSION['reset_notice'] = $current_texts['reset_email_sent_notice'] ?? $defaultNotice;
            $reset_notice = $_SESSION['reset_notice'];

            // 2-minute resend cooldown (only affects the bottom area)
            $_SESSION['resend_cooldown_until'] = time() + 120;
            $cooldown_remaining = 120;
          } else {
            $error = t('email_send_failed');
          }
        }
      }
    } catch (Throwable $e) {
      $error = t('unexpected_error');
    }
  }
}

/**
 * Handle "Verify OTP + Update Password"
 * This runs when the main "Next" button is clicked (no action=resend_email).
 */
if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  && (!isset($_POST['action']) || $_POST['action'] !== 'resend_email')
  && !isset($_POST['language']) // not the language switch form
) {
  try {
    $otp = isset($_POST['otp']) ? trim($_POST['otp']) : '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($otp === '' || !preg_match('/^\d{6}$/', $otp)) {
      $error = t('invalid_otp');
    } elseif ($password === '' || strlen($password) < 8) {
      $error = t('weak_password');
    } elseif ($password !== $confirm_password) {
      $error = t('passwords_do_not_match');
    } else {
      $resetStmt = $conn->prepare("
                SELECT id, user_id, token_hash, token_salt, expires_at, attempts, used
                FROM password_resets
                WHERE email = ?
                ORDER BY id DESC
                LIMIT 1
            ");

      if (!$resetStmt) {
        $error = t('database_prepare_failed');
      } else {
        $resetStmt->bind_param("s", $email);
        $resetStmt->execute();
        $resetStmt->bind_result($reset_id, $reset_user_id, $db_token_hash, $db_token_salt, $db_expires_at, $db_attempts, $db_used);
        $hasRow = $resetStmt->fetch();
        $resetStmt->close();

        if (!$hasRow) {
          $error = t('invalid_otp');
        } elseif ((int) $db_used === 1) {
          $error = t('otp_already_used');
        } elseif ((int) $db_attempts >= 5) {
          $error = t('too_many_attempts');
        } else {
          $now = new DateTime('now');
          $expiryTime = new DateTime($db_expires_at);

          if ($now > $expiryTime) {
            $error = t('otp_expired');
          } else {
            $check_hash = hash('sha256', $db_token_salt . $otp);

            if (!hash_equals($db_token_hash, $check_hash)) {
              $incStmt = $conn->prepare("UPDATE password_resets SET attempts = attempts + 1 WHERE id = ?");
              if ($incStmt) {
                $incStmt->bind_param("i", $reset_id);
                $incStmt->execute();
                $incStmt->close();
              }

              $error = t('invalid_otp');
            } else {
              $password_hash = password_hash($password, PASSWORD_DEFAULT);

              $updateUserStmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
              if (!$updateUserStmt) {
                $error = t('database_prepare_failed');
              } else {
                $updateUserStmt->bind_param("ss", $password_hash, $email);
                $updateUserStmt->execute();
                $updateUserStmt->close();

                $markUsedStmt = $conn->prepare("UPDATE password_resets SET used = 1 WHERE id = ?");
                if ($markUsedStmt) {
                  $markUsedStmt->bind_param("i", $reset_id);
                  $markUsedStmt->execute();
                  $markUsedStmt->close();
                }

                $user_id_for_session = $reset_user_id;
                $username_for_session = null;

                if ($user_id_for_session !== null) {
                  $userFetchStmt = $conn->prepare("SELECT username FROM users WHERE id = ? LIMIT 1");
                  if ($userFetchStmt) {
                    $userFetchStmt->bind_param("i", $user_id_for_session);
                    $userFetchStmt->execute();
                    $userFetchStmt->bind_result($f_username);
                    if ($userFetchStmt->fetch()) {
                      $username_for_session = $f_username;
                    }
                    $userFetchStmt->close();
                  }
                } else {
                  $userFetchStmt = $conn->prepare("SELECT id, username FROM users WHERE email = ? LIMIT 1");
                  if ($userFetchStmt) {
                    $userFetchStmt->bind_param("s", $email);
                    $userFetchStmt->execute();
                    $userFetchStmt->bind_result($f_id, $f_username);
                    if ($userFetchStmt->fetch()) {
                      $user_id_for_session = $f_id;
                      $username_for_session = $f_username;
                    }
                    $userFetchStmt->close();
                  }
                }

                if ($user_id_for_session !== null) {
                  $_SESSION['user_id'] = $user_id_for_session;
                  $_SESSION['username'] = $username_for_session ?: explode('@', $email)[0];
                  $_SESSION['user_email'] = $email;

                  if (function_exists('sendPasswordResetSuccessMail')) {
                    $displayName = $_SESSION['username'];
                    sendPasswordResetSuccessMail($email, $displayName);
                  }

                  // Clear signin and reset_notice when done
                  unset($_SESSION['signin_email']);
                  unset($_SESSION['reset_notice']);
                  unset($_SESSION['resend_cooldown_until']);

                  header('Location: sign_in_email.php');
                  exit;
                } else {
                  $error = t('unexpected_error');
                }
              }
            }
          }
        }
      }
    }
  } catch (Throwable $e) {
    $error = t('unexpected_error');
  }
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
  <link rel="icon" type="image/png" href="./../assets/favicon/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="./../assets/favicon/favicon.svg" />
  <link rel="shortcut icon" href="./../assets/favicon/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="./../assets/favicon/apple-touch-icon.png" />
  <link rel="manifest" href="./../assets/favicon/site.webmanifest" />
  <meta name="apple-mobile-web-app-title" content="<?php echo htmlspecialchars($_ENV['DOMAIN']); ?>" />

  <!-- Main Stylesheet (Tailwind CSS) -->
  <link rel="stylesheet" href="./../src/output.css">

  <!-- Google Fonts: Lexend Deca -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

  <!-- Dynamic Page Title (from .env DOMAIN variable) -->
    <title><?php echo htmlspecialchars($_ENV['APP_NAME'] . ' - Authentication'); ?></title>

  <!-- Debug Kit: Optional outline borders (toggled via .env DEBUG_MODE) -->
  <?php include './../assets/_debug_kit.php'; ?>
</head>

<body class="bg-neutral-900 text-gray-200 flex items-center justify-center min-h-screen p-4">
  <div class="w-full max-w-5xl mx-auto flex flex-col">
    <main class="bg-black border border-neutral-900 rounded-4xl w-full max-w-5xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 min-h-[400px]">
        <!-- Left Side Content -->
        <div class="p-8 md:p-12 flex flex-col self-start text-center md:text-left items-center md:items-start">
          <div class="flex items-center mb-6">
            <img src="./../assets/images/logos/xovae.png" class="h-14 w-auto rounded-full bg-neutral-900"
              alt="xovae-logo" />
          </div>
          <h1 class="text-3xl font-normal text-gray-200 mb-2"><?php echo t('reset_password_title'); ?></h1>
          <p class="text-gray-400">
            <?php echo t('continue_to'); ?>
            <span
              class="font-youtube text-lg"><?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?></span>
          </p>
        </div>

        <!-- Right Side Content -->
        <div class="p-8 md:p-12 flex flex-col justify-center -mt-4 lg:mt-10">
          <form action="#" method="post" class="w-full">

            <?php if (!empty($error)): ?>
              <p class="text-sm text-red-400 mb-4">
                <?php echo htmlspecialchars($error); ?>
              </p>
            <?php elseif (!empty($reset_notice)): ?>
              <p class="text-sm text-green-400 mb-4">
                <?php echo htmlspecialchars($reset_notice); ?>
              </p>
            <?php endif; ?>

            <div class="mb-4">
              <input type="text" id="otp" name="otp" maxlength="6"
                placeholder="<?php echo t('enter_otp_placeholder'); ?>"
                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200 form-input">
            </div>

            <div class="mb-4">
              <input type="password" id="password" name="password" required minlength="8"
                placeholder="<?php echo t('set_password_placeholder'); ?>"
                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200 form-input" />
            </div>

            <div class="mb-4">
              <input type="password" id="confirm_password" name="confirm_password" required
                placeholder="<?php echo t('confirm_password_placeholder'); ?>"
                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200 form-input" />
            </div>

            <p class="text-sm text-gray-200 mt-6 mb-6">
              <?php echo t('not_received_email'); ?>
              <span id="resend-container"
                data-resend-label="<?php echo htmlspecialchars(t('resend_email'), ENT_QUOTES); ?>">

                <?php if ($cooldown_remaining > 0): ?>
                  <span id="countdown-wrapper" class="text-red-400">
                    Please wait <span id="countdown"><?php echo $cooldown_remaining; ?></span> seconds before requesting
                    again.
                  </span>
                <?php else: ?>
                  <button type="submit" name="action" value="resend_email" formnovalidate
                    class="font-medium text-gray-400 hover:underline bg-transparent border-none p-0 cursor-pointer">
                    <?php echo t('resend_email'); ?>
                  </button>
                <?php endif; ?>

              </span>
            </p>

            <div class="flex flex-row items-center justify-end gap-4">
              <button type="button" onclick="location.href='sign_in_email.php'"
                class="text-gray-200 font-medium px-6 py-2.5 rounded-3xl transition duration-200 hover:bg-neutral-900 hover:text-gray-200 cursor-pointer">
                <?php echo t('back'); ?>
              </button>
              <button type="submit" id="nextBtn"
                class="bg-neutral-800 hover:bg-neutral-700 text-gray-200 font-medium px-6 py-2.5 rounded-3xl transition duration-200 cursor-pointer">
                <?php echo t('next'); ?>
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>

    <footer class="mt-0 w-full p-4">
      <div
        class="max-w-4xl mx-auto flex flex-col sm:flex-row justify-between items-center text-xs text-gray-400 space-y-2 sm:space-y-0">
        <div>
          <form id="langForm" method="post" class="inline-block">
            <select name="language" onchange="document.getElementById('langForm').submit()"
              class="bg-transparent border-none text-gray-200 focus:outline-none pr-2 cursor-pointer">
              <?php foreach ($languages as $lang): ?>
                <option value="<?php echo htmlspecialchars($lang); ?>" <?php echo $selected_language === $lang ? 'selected' : ''; ?>>
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
<script src="./../assets/js/forgot_password_config.js"></script>

</html>