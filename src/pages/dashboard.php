<?php
// Initialize the application
include './core/init.php';
include './core/connection.php';
include './core/router.php';

// Suppress all PHP errors in production environment
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
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
    <meta name="apple-mobile-web-app-title" content="<?php echo htmlspecialchars($_ENV['DOMAIN']); ?>" />

    <!-- Main Stylesheet (Tailwind CSS) -->
    <link rel="stylesheet" href="./src/output.css">

    <!-- Google Fonts: Lexend Deca -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

    <!-- Dynamic Page Title (from .env DOMAIN variable) -->
    <title><?php echo htmlspecialchars($_ENV['DOMAIN'] . ' - Dashboard'); ?></title>

    <!-- Debug Kit: Optional outline borders (toggled via .env DEBUG_MODE) -->
    <?php include './assets/_debug_kit.php'; ?>
</head>


<body class="bg-neutral-900 text-gray-200 antialiased">
    <?php include './assets/_navbar.php'; ?>

    <div class="flex h-screen overflow-hidden">
        

        <?php include './assets/_sidebar.php'; ?>

        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto space-y-6">
                <?php include $current_route['file']; ?>
            </div>
        </main>

    </div>

    <script src="./assets/js/dashboard_config.js"></script>
</body>

</html>