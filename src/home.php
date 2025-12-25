<?php
// Initialize the application
include './core/init.php';

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

<body class="bg-black">
  <!-- Includes -->
  <?php include 'assets/_navbar.php'; ?>
  <?php include 'assets/_sidebar.php'; ?>
  <?php include 'core/connection.php'; ?>
  <?php include 'core/home/home_config.php'; ?>

  <main class="mt-8 p-7">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <?php
      $sql = "SELECT thumbnail, duration, channel_image, title, channel_name, views, uploaded_at FROM videos ORDER BY uploaded_at DESC";
      $result = $conn->query($sql);

      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
          ?>

          <div class="cursor-pointer">
            <!-- Thumbnail -->
            <div class="relative">
              <img src="<?php echo htmlspecialchars($row['thumbnail']); ?>" alt="video thumbnail"
                class="w-full h-auto rounded-2xl opacity-90" loading="lazy">
              <span class="absolute bottom-2 right-2 text-gray-200 text-xs px-1 py-[0.15rem] rounded-md bg-black/50">
                <?php echo htmlspecialchars(formatDuration($row['duration'])); ?>
              </span>
            </div>
            <!-- Info -->
            <div class="flex mt-2 gap-3">
              <img src="<?php echo htmlspecialchars($row['channel_image']); ?>" alt="channel"
                class="w-auto h-10 rounded-full opacity-90" loading="lazy">
              <div>
                <h3 class="text-md text-gray-200"><?php echo htmlspecialchars($row['title']); ?></h3>
                <p class="text-sm text-gray-400"><?php echo htmlspecialchars($row['channel_name']); ?></p>
                <p class="text-sm text-gray-400">
                  <?php echo htmlspecialchars(formatViews($row['views'])); ?> views •
                  <?php echo htmlspecialchars(timeAgo($row['uploaded_at'])); ?>
                </p>
              </div>
            </div>
          </div>

          <?php
        endwhile;
      else:
        echo "<p class='text-gray-400'>No videos found.</p>";
      endif;
      ?>

    </div>
  </main>

</body>

<!-- Scripts -->
<script src="assets/js/navbar_config.js"></script>
<script src="assets/js/sidebar_config.js"></script>

</html>