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

$error = '';
$input = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input'])) {
    $input = trim($_POST['input']);

    if (empty($input)) {
        $error = t('empty_input_error');
    } else {
        // Check if input matches either email or username
        $stmt = $conn->prepare("SELECT id, email FROM users WHERE email = ? OR username = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("ss", $input, $input);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Fetch the email to pass to next step
                $stmt->bind_result($user_id, $email);
                $stmt->fetch();

                $_SESSION['signin_email'] = $email;
                header('Location: sign_in_password.php');
                exit;
            } else {
                $error = t('account_not_found');
            }

            $stmt->close();
        } else {
            $error = t('database_prepare_failed');
        }
    }
}

// Handle language selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language']) && in_array($_POST['language'], $languages, true)) {
    $_SESSION['language'] = $_POST['language'];
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
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
          <form action="#" method="post" class="w-full">

            <?php if (!empty($error)): ?>
              <p class="text-red-500 text-sm mb-2"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <div class="mb-1">
              <input type="text" id="input" name="input" placeholder="<?php echo t('email_placeholder'); ?>"
                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-gray-200 placeholder-gray-200 focus:outline-none transition duration-200 form-input"
                value="<?php echo htmlspecialchars($input); ?>">
            </div>

            <div class="mb-6">
              <button type="button" onclick="location.href='forgot_email.php'"
                class="text-sm text-gray-400 hover:underline bg-transparent border-none p-0 cursor-pointer">
                <?php echo t('forgot_email'); ?>
              </button>
            </div>

            <p class="text-sm text-gray-200 mb-6">
              <?php echo t('guest_mode'); ?>
              <button type="button" onclick="window.open('https://support.google.com/chrome/answer/6130773','_blank')"
                class="font-medium text-gray-400 hover:underline bg-transparent border-none p-0 cursor-pointer">
                <?php echo t('learn_more'); ?>
              </button>
            </p>

            <div class="flex flex-row items-center justify-end gap-4">
              <button type="button" onclick="location.href='create_account_info.php'"
                class="text-gray-200 font-medium px-6 py-2.5 rounded-3xl transition duration-200 hover:bg-neutral-900 hover:text-gray-200 cursor-pointer">
                <?php echo t('create_account'); ?>
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
<script src="assets/js/sign_in_config.js"></script>

</html>