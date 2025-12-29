<?php
ob_start();
session_start();

// Initialize the application
include './../core/init.php';
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
  <title><?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?></title>

  <!-- Debug Kit: Optional outline borders (toggled via .env DEBUG_MODE) -->
  <?php include './../assets/_debug_kit.php'; ?>
</head>

<body class="bg-neutral-900 text-gray-200 flex items-center justify-center min-h-screen p-4">
    <!-- Includes -->
         <?php include './../core/connection.php'; ?>
         <?php include './../core/languages/language_config.php';?>
         <?php include './../core/feedback/mail/feedback_config.php';?>

    <?php
    // Handles the language selection
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formType = $_POST['form_type'] ?? '';

        if ($formType === 'lang') {
            $lang = $_POST['language'] ?? '';
            if (!empty($lang) && !empty($languages) && in_array($lang, $languages, true)) {
                $_SESSION['language'] = $lang;
            }
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        if ($formType === 'feedback') {
            handleFeedbackForm($languages);
        }
    }

    $selected_language = !empty($_SESSION['language']) && in_array($_SESSION['language'], $languages, true)
        ? $_SESSION['language']
        : ($languages[0] ?? null);

    if (!empty($selected_language) && function_exists('getTranslations')) {
        $current_texts = getTranslations($conn, $selected_language);
    }
    ?>
    
    <div class="w-full max-w-5xl mx-auto flex flex-col">
        <main class="bg-black border border-neutral-900 rounded-4xl w-full max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 min-h-[400px]">

                <!-- Left -->
                <div class="p-8 md:p-12 flex flex-col self-start text-center md:text-left items-center md:items-start">
                    <div class="flex items-center mb-6">
                        <img src="./../assets/images/logos/xovae.svg" class="h-14 w-auto rounded-full bg-neutral-900" alt="xovae-logo" />
                    </div>
                    <h1 class="text-3xl font-normal text-gray-200 mb-2">Language Support</h1>
                    <p class="text-gray-400">
                        Share your feedback & help us improve <span class="font-youtube text-lg"><?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?></span> for everyone.
                    </p>

                    <?php
                    $maxVisibleContributors = $_ENV['MAX_VISIBLE_CONTRIBUTORS'] ?? 'UNKNOWN VALUE';
                    $stmt = $conn->prepare("SELECT language, img, points FROM contributors ORDER BY points DESC, added_at ASC");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>
                    <div class="mt-6">
                        <h2 class="text-2xl text-gray-200 mb-6">Top Contributors</h2>
                        <div class="grid grid-cols-6 gap-4">
                            <?php
                            if ($result && $result->num_rows > 0) {
                                $contributors = $result->fetch_all(MYSQLI_ASSOC);
                                $total = count($contributors);
                                foreach ($contributors as $index => $c) {
                                    $language = htmlspecialchars($c['language']);
                                    $img = htmlspecialchars($c['img']);
                                    if ($maxVisibleContributors === 'UNKNOWN VALUE' || $index < (int)$maxVisibleContributors) {
                                        echo '<div class="relative h-10 w-10 sm:h-11 sm:w-11 md:h-12 md:w-12 rounded-full border-2 border-neutral-600 overflow-hidden group cursor-pointer">
                                                <img src="' . $img . '" alt="' . $language . '" class="h-full w-full object-cover transition-all duration-300">
                                                <div class="absolute inset-0 flex items-center justify-center text-xs sm:text-sm text-gray-100 opacity-0 group-hover:opacity-100 bg-black bg-opacity-80 text-center px-2 rounded transition-opacity duration-300">
                                                    ' . $language . '
                                                </div>
                                            </div>';
                                    } elseif ($index === (int)$maxVisibleContributors) {
                                        $moreCount = $total - (int)$maxVisibleContributors;
                                        $lastContributor = $c;
                                        echo '<div class="relative h-10 w-10 sm:h-11 sm:w-11 md:h-12 md:w-12 rounded-full border-2 border-neutral-600 overflow-hidden">
                                                <img src="' . htmlspecialchars($lastContributor['img']) . '" alt="' . htmlspecialchars($lastContributor['language']) . '" class="h-full w-full object-cover opacity-60 filter blur-sm">
                                                <div class="absolute inset-0 flex items-center justify-center text-xs sm:text-sm md:text-base text-gray-200">+' . $moreCount . '</div>
                                            </div>';
                                        break;
                                    }
                                }
                            } else {
                                echo '<p class="text-gray-400 col-span-6 text-center">No contributors found.</p>';
                            }
                            $stmt->close();
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Right (language + feedback) -->
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <?php if (!empty($feedbackMessage)): ?>
                        <div class="mb-4 text-base border border-neutral-800 text-center px-4 py-2 rounded bg-neutral-800 text-gray-200">
                            <?php echo $feedbackMessage; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Language form (separate, small form) -->
                    <form id="langForm" action="feedback.php" method="post" class="w-full mb-4">
                        <input type="hidden" name="form_type" value="lang" />
                        <select name="language" onchange="document.getElementById('langForm').submit()"
                            class="w-full bg-transparent text-base text-gray-200 rounded-md py-3.5 focus:outline-none">
                            <?php foreach ($languages as $lang): ?>
                                <option value="<?php echo htmlspecialchars($lang); ?>"
                                    <?php echo ($selected_language === $lang) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($lang); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>

                    <!-- Feedback form -->
                    <form action="feedback.php" method="post" class="w-full">
                        <input type="hidden" name="form_type" value="feedback" />
                        <input type="hidden" name="language" value="<?php echo htmlspecialchars($selected_language); ?>" />

                        <div class="mb-4">
                            <textarea id="feedback" name="feedback" rows="5" placeholder="Tell us what could be improved or corrected..."
                                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-base text-gray-200 placeholder-gray-200 focus:outline-none"></textarea>
                        </div>

                        <div class="mb-6">
                            <input type="email" id="email" name="email" placeholder="Enter your email to take part (optional)"
                                class="w-full bg-transparent border border-neutral-600 rounded-md px-4 py-3.5 text-base text-gray-200 placeholder-gray-200 focus:outline-none">
                        </div>

                        <div class="flex flex-row items-center justify-end gap-4">
                            <button type="button" 
                            onclick="window.location.href='sign_in_email.php'" class="text-gray-200 font-medium px-6 py-2.5 rounded-3xl transition duration-200 hover:bg-neutral-900 hover:text-gray-200 cursor-pointer">
                                Back
                            </button>
                            <button type="submit" id="nextBtn"
                            class="bg-neutral-800 hover:bg-neutral-700 text-gray-200 font-medium px-6 py-2.5 rounded-3xl transition duration-200 cursor-pointer">
                                Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <footer class="mt-0 w-full p-4">
            <div class="max-w-4xl mx-auto flex flex-col sm:flex-row justify-between items-center text-xs text-gray-400 space-y-2 sm:space-y-0">
                <div>
                    <button type="button" onclick="window.location.href='<?php echo $mailto; ?>'" class="hover:text-gray-200 bg-transparent border-none p-0 text-xs cursor-pointer">
                        Be part of us? We’re hiring!
                    </button>
                </div>

                <div class="flex space-x-6">
                    <button type="button" 
                    class="hover:text-gray-200 bg-transparent border-none p-0 text-xs cursor-pointer">Support</button>
                    <button type="button" 
                    class="hover:text-gray-200 bg-transparent border-none p-0 text-xs cursor-pointer">Privacy Policy</button>
                    <button type="button" 
                    class="hover:text-gray-200 bg-transparent border-none p-0 text-xs cursor-pointer">Terms of Service</button>
                    <button type="button" 
                    class="hover:text-gray-200 bg-transparent border-none p-0 text-xs cursor-pointer">
                        STD: <?php echo htmlspecialchars($selected_language ?? 'English (UK)'); ?>
                    </button>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>