<?php
session_start();

// Initialize the application
include './core/init.php';
include './core/connection.php';
include './core/languages/language_config.php';

// Suppress all PHP errors in production environment
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Handle language change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language']) && in_array($_POST['language'], $languages, true)) {
    $_SESSION['language'] = $_POST['language'];
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

// Handle Step 1 form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['email'], $_POST['age'], $_POST['gender'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $age = intval($_POST['age']);
    $gender = trim($_POST['gender']);

    if ($username && $email && $age && $gender) {
        $_SESSION['signup'] = [
            'username' => htmlspecialchars($username, ENT_QUOTES, 'UTF-8'),
            'email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
            'age' => $age,
            'gender' => htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'),
        ];
        header('Location: create_account_password.php');
        exit;
    } else {
        $error = t('all_fields_required');
    }
}

if (empty($current_texts) && !empty($languages)) {
    $current_texts = getTranslations($conn, $languages[0]);
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

                <!-- Left Section -->
                <div class="p-8 md:p-12 flex flex-col self-start text-center md:text-left items-center md:items-start">
                    <div class="flex items-center mb-6">
                        <img src="./assets/images/logos/xovae.svg" class="h-14 w-auto rounded-full bg-neutral-900"
                            alt="xovae-logo" />
                    </div>
                    <h1 class="text-3xl font-normal text-gray-200 mb-2"><?php echo t('create_an_account'); ?></h1>
                    <p class="text-gray-400">
                        <?php echo t('continue_to'); ?>
                        <span class="font-youtube text-lg">
                            <?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?>
                        </span>
                    </p>
                </div>

                <!-- Right Section -->
                <div class="p-8 md:p-12 flex flex-col justify-center -mt-4 lg:mt-10">
                    <?php if (!empty($error)): ?>
                        <p class="text-red-500 text-sm mb-4 text-center"><?php echo htmlspecialchars($error); ?></p>
                    <?php endif; ?>

                    <form method="post" action="" class="w-full">

                        <!-- Username -->
                        <div class="mb-4">
                            <input type="text" id="username" name="username" required minlength="3" maxlength="50"
                                placeholder="<?php echo t('username_placeholder'); ?>"
                                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200 form-input" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <input type="email" id="email" name="email" required
                                placeholder="<?php echo t('create_account_email'); ?>"
                                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200 form-input" />
                        </div>

                        <!-- Age & Gender -->
                        <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <input type="text" id="age" name="age" required inputmode="numeric" pattern="[0-9]*"
                                    placeholder="<?php echo t('age_placeholder'); ?>"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,2);"
                                    class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200" />
                            </div>
                            <div>
                                <select id="gender" name="gender" required
                                    class="w-full bg-transparent rounded-md px-4 py-3 text-gray-200 focus:outline-none transition duration-200">
                                    <option value="male"><?php echo t('gender_male'); ?></option>
                                    <option value="female"><?php echo t('gender_female'); ?></option>
                                    <option value="prefer_not"><?php echo t('gender_prefer_not'); ?></option>
                                </select>
                            </div>
                        </div>

                        <p class="text-sm text-gray-200 mb-6">
                            <?php echo t('consent_text'); ?>
                            <button type="button" onclick="window.open('#','_blank')"
                                class="font-medium text-gray-400 hover:underline bg-transparent border-none p-0 cursor-pointer">
                                <?php echo t('consent_link'); ?>
                            </button>
                        </p>

                        <!-- Actions -->
                        <div class="flex flex-row items-center justify-end gap-4">
                            <button type="button" onclick="location.href='sign_in_email.php'"
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
                                <option value="<?php echo htmlspecialchars($lang); ?>" <?php echo isset($selected_language) && $selected_language === $lang ? 'selected' : ''; ?>>
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
<script src="assets/js/create_account_config.js"></script>

</html>