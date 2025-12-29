<?php
session_start();

// Initialize the application
include './../core/init.php';
include './../core/connection.php';
include './../core/languages/language_config.php';

// Suppress all PHP errors in production environment
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Redirect if signup session is missing
if (empty($_SESSION['signup'])) {
    header('Location: create_account_info.php');
    exit;
}

// Handle language change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language']) && in_array($_POST['language'], $languages, true)) {
    $_SESSION['language'] = $_POST['language'];
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

$error = '';

$username = $_SESSION['signup']['username'];
$email = $_SESSION['signup']['email'];

// Check if username or email already exists
$stmt = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
if ($stmt) {
    $stmt->bind_param("ss", $username, $email);
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($existing_username, $existing_email);
            $stmt->fetch();

            if ($existing_username === $username) {
                $error = sprintf(t('username_taken'), htmlspecialchars($username));
            } elseif ($existing_email === $email) {
                $error = sprintf(t('email_taken'), htmlspecialchars($email));
            } else {
                $error = t('username_or_email_taken');
            }
        }
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error) && isset($_POST['password'], $_POST['confirm_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = t('passwords_do_not_match');
    } elseif (strlen($password) < 8) {
        $error = t('password_too_short');
    } else {
        $age = isset($_SESSION['signup']['age']) ? (int) $_SESSION['signup']['age'] : 0;
        $gender = isset($_SESSION['signup']['gender']) ? $_SESSION['signup']['gender'] : '';
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, age, gender, password_hash, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if ($stmt) {
            $stmt->bind_param("ssiss", $username, $email, $age, $gender, $password_hash);
            if ($stmt->execute()) {
                include './../core/auth/mail/create_account_config.php';
                sendAccountCreationMail($email, $username);

                unset($_SESSION['signup']);
                header('Location: sign_in_email.php');
                exit;
            } else {
                $error = t('account_creation_failed');
            }
            $stmt->close();
        } else {
            $error = t('database_prepare_failed');
        }
    }
}

if (empty($current_texts) && !empty($languages)) {
    $current_texts = getTranslations($conn, $languages[0]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta & Viewport -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon & PWA -->
    <link rel="icon" type="image/png" href="./../assets/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./../assets/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./../assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./../assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="./../assets/favicon/site.webmanifest" />
    <meta name="apple-mobile-web-app-title" content="<?php echo htmlspecialchars($_ENV['DOMAIN']); ?>" />

    <!-- TailwindCSS -->
    <link rel="stylesheet" href="./../src/output.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

    <!-- Title -->
    <title><?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?></title>

    <!-- Debug Kit -->
    <?php include './../assets/_debug_kit.php'; ?>
</head>

<body class="bg-neutral-900 text-gray-200 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-5xl mx-auto flex flex-col">
        <main class="bg-black border border-neutral-900 rounded-4xl w-full max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 min-h-[400px]">
                <!-- Left -->
                <div class="p-8 md:p-12 flex flex-col self-start text-center md:text-left items-center md:items-start">
                    <div class="flex items-center mb-6">
                        <img src="./../assets/images/logos/xovae.svg" class="h-14 w-auto rounded-full bg-neutral-900"
                            alt="xovae-logo" />
                    </div>
                    <h1 class="text-3xl font-normal text-gray-200 mb-2"><?php echo t('create_password_title'); ?></h1>
                    <p class="text-gray-400">
                        <?php echo t('continue_to'); ?>
                        <span class="font-youtube text-lg">
                            <?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?>
                        </span>
                    </p>
                </div>

                <!-- Right -->
                <div class="p-8 md:p-12 flex flex-col justify-center -mt-4 lg:mt-10">
                    <?php if (!empty($error)): ?>
                    <p class="text-red-500 text-sm mb-4 text-center md:text-left"><?php echo $error; ?></p>
                    <?php endif; ?>

                    <form method="post" class="w-full">
                        <div class="mb-4">
                            <input type="password" id="password" name="password" required minlength="8"
                                placeholder="<?php echo t('set_password_placeholder'); ?>"
                                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200" />
                        </div>
                        <div class="mb-4">
                            <input type="password" id="confirm_password" name="confirm_password" required
                                placeholder="<?php echo t('confirm_password_placeholder'); ?>"
                                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200" />
                        </div>

                        <p class="text-sm text-gray-200 mb-6">
                            <button type="button" id="togglePasswordBtn" data-show="<?php echo t('reveal_password'); ?>"
                                data-hide="<?php echo t('hide_password'); ?>"
                                class="text-sm font-medium text-gray-200 hover:underline bg-transparent border-none p-0 cursor-pointer self-start">
                                <?php echo t('reveal_password'); ?>
                            </button>
                            <button type="button" onclick="window.open('#','_blank')"
                                class="font-medium text-gray-400 hover:underline bg-transparent border-none p-0 cursor-pointer">
                                <?php echo t('learn_strong_password'); ?>
                            </button>
                        </p>

                        <div class="flex flex-row items-center justify-end gap-4">
                            <button type="button" onclick="location.href='create_account_info.php'"
                                class="text-gray-200 font-medium px-6 py-2.5 rounded-3xl transition duration-200 hover:bg-neutral-900 hover:text-gray-200 cursor-pointer">
                                <?php echo t('back_button'); ?>
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

        <!-- Footer -->
        <footer class="mt-0 w-full p-4">
            <div
                class="max-w-4xl mx-auto flex flex-col sm:flex-row justify-between items-center text-xs text-gray-400 space-y-2 sm:space-y-0">
                <div>
                    <form id="langForm" method="post" class="inline-block">
                        <select name="language" onchange="document.getElementById('langForm').submit()"
                            class="bg-transparent border-none text-gray-200 focus:outline-none pr-2 cursor-pointer">
                            <?php foreach ($languages as $lang): ?>
                            <option value="<?php echo htmlspecialchars($lang); ?>"
                                <?php echo isset($selected_language) && $selected_language === $lang ? 'selected' : ''; ?>>
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
<script src="./../assets/js/create_account_config.js"></script>

</html>