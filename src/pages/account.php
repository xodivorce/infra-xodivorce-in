<?php
session_start();
include './../core/init.php';
include './../core/connection.php';

ini_set('display_errors', 0);
error_reporting(0);

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: ./../index.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: ./../index.php");
    exit;
}

$username = 'Unknown';
$email = 'Unknown';
$is_admin = false;

$stmt = $conn->prepare("SELECT username, email, is_admin FROM users WHERE id = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($db_username, $db_email, $db_is_admin);
    if ($stmt->fetch()) {
        $username = $db_username;
        $email = $db_email;
        $is_admin = ((int) $db_is_admin === 1);
    }
    $stmt->close();
}

$email_initial = strtoupper(substr($email, 0, 1));

$helpdesk_email = $_ENV['HELPDESK_EMAIL'];
$helpdesk_phone = $_ENV['HELPDESK_PHONE'];

$management_email = $_ENV['MANAGEMENT_EMAIL'];
$management_phone = $_ENV['MANAGEMENT_PHONE'];

$health_email = $_ENV['HEALTH_EMAIL'];
$health_phone = $_ENV['HEALTH_PHONE'];

$library_email = $_ENV['LIBRARY_EMAIL'];
$library_phone = $_ENV['LIBRARY_PHONE'];

$security_email = $_ENV['SECURITY_EMAIL'];
$security_phone = $_ENV['SECURITY_PHONE'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="./../assets/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./../assets/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./../assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./../assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="./../assets/favicon/site.webmanifest" />
    <meta name="apple-mobile-web-app-title" content="<?php echo htmlspecialchars($_ENV['DOMAIN']); ?>" />
    <link rel="stylesheet" href="./../src/output.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

    <title><?php echo htmlspecialchars(($_ENV['DOMAIN']) . ' - Account'); ?></title>

    <?php include './../assets/_debug_kit.php'; ?>
</head>

<body class="bg-neutral-900 text-gray-200 min-h-screen flex flex-col antialiased selection:bg-blue-500/30"
    style="font-family: 'Lexend Deca', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;">

    <div class="h-[140px] md:h-[150px] w-full bg-neutral-900 relative overflow-hidden border-b border-neutral-800">


        <div class="absolute top-4 left-4 md:top-6 md:left-6 z-20">
            <button onclick="window.location.href='./../index.php';" class="group flex items-center gap-2 px-4 py-2 bg-blue-500/10 backdrop-blur-xl
            border border-blue-500/40 rounded-xl text-sm text-neutral-300
            hover:text-white hover:bg-blue-500/20
            transition-all duration-300 active:scale-95">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Dashboard
            </button>
        </div>
    </div>

    <div class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 md:-mt-20 relative z-10 pb-12">

        <div class="flex flex-col md:flex-row items-center md:items-end gap-4 md:gap-8 mb-8 md:mb-12">

            <div class="relative shrink-0 group">
                <div
                    class="w-28 h-28 md:w-44 md:h-44 rounded-full bg-neutral-900 border-4 md:border-[6px] border-neutral-900 shadow-2xl flex items-center justify-center relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-neutral-800 via-neutral-700 to-neutral-600 group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <span class="relative z-10 text-4xl md:text-6xl font-bold text-white drop-shadow-lg">
                        <?php echo $email_initial; ?>
                    </span>
                </div>
                <div class="absolute bottom-1 right-1 md:bottom-3 md:right-3 bg-neutral-900 rounded-full p-1 md:p-1.5">
                    <div
                        class="w-4 h-4 md:w-6 md:h-6 bg-green-500 rounded-full border-2 md:border-[3px] border-neutral-900 flex items-center justify-center shadow-lg shadow-green-500/50">
                        <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-white rounded-full opacity-70 animate-pulse"></div>
                    </div>
                </div>
            </div>

            <div class="flex-1 w-full text-center md:text-left pb-0 md:pb-4">
                <h1 class="text-2xl md:text-5xl font-bold text-white tracking-tight mb-3 break-all md:break-normal">
                    <?php echo htmlspecialchars($email); ?>
                </h1>

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 md:gap-3">


                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border bg-green-500/10 border-green-500/20 text-green-400 text-[10px] md:text-xs font-bold uppercase tracking-wider backdrop-blur-md">
                        <svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Verified
                    </span>
                </div>
            </div>

            <div class="w-full md:w-auto pb-0 md:pb-4 mt-2 md:mt-0">
                <form method="get" action="">
                    <button type="submit" name="action" value="logout"
                        class="w-full md:w-auto flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/80 hover:text-white hover:shadow-lg hover:shadow-red-500/20 transition-all duration-300 font-medium text-sm active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 md:gap-8">

            <div class="xl:col-span-2 space-y-6">
                <div
                    class="bg-neutral-900/60 backdrop-blur-xl border border-neutral-800 rounded-2xl p-5 md:p-8 shadow-xl relative overflow-hidden h-full">

                    <div
                        class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-500 via-neutral-600 to-transparent">
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg md:text-xl font-bold text-white">Your Identification</h2>
                            <p class="text-xs text-neutral-400 mt-1">View the University credentials & access details
                            </p>
                        </div>
                        <div class="p-2 bg-neutral-800/50 rounded-lg border border-neutral-700/50">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .6.4 1 1 1 1 1 0 0 1 1 1v3" />
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5">

                        <div class="group">
                            <label
                                class="block text-[10px] font-bold text-neutral-500 uppercase tracking-widest mb-1.5 ml-1">Username/
                                University ID/ Student ID</label>
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1 min-w-0">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-blue-400 transition-colors" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div
                                        class="w-full bg-black/40 border border-neutral-800 text-neutral-200 text-sm rounded-xl py-3.5 pl-9 pr-4 font-mono truncate group-hover:border-neutral-700 transition-colors">
                                        <?php echo htmlspecialchars($username); ?>
                                    </div>
                                </div>
                                <button id="btn-user"
                                    onclick="copyToClipboard('<?php echo htmlspecialchars($username, ENT_QUOTES); ?>', 'btn-user')"
                                    class="shrink-0 p-3.5 bg-neutral-800 border border-neutral-700 rounded-xl text-neutral-400 hover:text-white hover:bg-neutral-700 hover:border-neutral-600 transition-all shadow-sm active:scale-95"
                                    title="Copy ID">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="group">
                            <label
                                class="block text-[10px] font-bold text-neutral-500 uppercase tracking-widest mb-1.5 ml-1">Authenticated
                                Email Address</label>
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1 min-w-0">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-blue-400 transition-colors" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div
                                        class="w-full bg-black/40 border border-neutral-800 text-neutral-200 text-sm rounded-xl py-3.5 pl-9 pr-4 font-mono truncate group-hover:border-neutral-700 transition-colors">
                                        <?php echo htmlspecialchars($email); ?>
                                    </div>
                                </div>
                                <button id="btn-email"
                                    onclick="copyToClipboard('<?php echo htmlspecialchars($email, ENT_QUOTES); ?>', 'btn-email')"
                                    class="shrink-0 p-3.5 bg-neutral-800 border border-neutral-700 rounded-xl text-neutral-400 hover:text-white hover:bg-neutral-700 hover:border-neutral-600 transition-all shadow-sm active:scale-95"
                                    title="Copy Email">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <div
                                class="p-4 rounded-xl bg-neutral-800/30 border border-neutral-800 flex items-center justify-between group hover:border-green-500/20 transition-colors">

                                <div>
                                    <p class="text-[10px] text-neutral-500 uppercase font-bold">Account Status</p>
                                    <p class="text-xs font-semibold text-neutral-200 mt-1">
                                        Activated
                                    </p>
                                </div>

                                <svg class="w-5 h-5 text-green-400 drop-shadow-[0_0_6px_rgba(34,197,94,0.45)]"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                            </div>

                            <div
                                class="p-4 rounded-xl bg-neutral-800/30 border border-neutral-800 flex items-center justify-between group hover:border-blue-500/20 transition-colors">
                                <div>
                                    <p class="text-[10px] text-neutral-500 uppercase font-bold">CAMPUS ROLE</p>
                                    <p class="text-xs font-semibold text-white mt-1">
                                        <?php echo $is_admin ? 'Administrator' : 'Student'; ?>
                                    </p>
                                </div>
                                <svg class="w-5 h-5 text-blue-400 opacity-90 transition-colors" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="space-y-3">

                <a
                    class="group flex items-center gap-4 p-4 rounded-xl bg-neutral-800/30 border border-neutral-800 hover:border-blue-500/30 hover:bg-neutral-800/50 transition-all duration-300">
                    <div
                        class="p-2.5 bg-blue-500/10 rounded-lg text-blue-400 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-xs font-bold text-white uppercase tracking-wide group-hover:text-blue-400 transition-colors">
                            IT Helpdesk Support</p>
                        <div class="text-[10px] text-neutral-400 mt-0.5">
                            <p><?php echo htmlspecialchars($helpdesk_email); ?></p>
                            <p><?php echo htmlspecialchars($helpdesk_phone); ?></p>
                        </div>
                    </div>
                </a>

                <div
                    class="group flex items-center gap-4 p-4 rounded-xl bg-neutral-800/30 border border-neutral-800 hover:border-purple-500/30 hover:bg-neutral-800/50 transition-all duration-300">
                    <div
                        class="p-2.5 bg-purple-500/10 rounded-lg text-purple-400 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-xs font-bold text-white uppercase tracking-wide group-hover:text-purple-400 transition-colors">
                            Management Support</p>
                        <div class="text-[10px] text-neutral-400 mt-0.5">
                            <p><?php echo htmlspecialchars($management_email); ?></p>
                            <p><?php echo htmlspecialchars($management_phone); ?></p>
                        </div>
                    </div>
                </div>

                <div
                    class="group flex items-center gap-4 p-4 rounded-xl bg-neutral-800/30 border border-neutral-800 hover:border-emerald-500/30 hover:bg-neutral-800/50 transition-all duration-300">
                    <div
                        class="p-2.5 bg-emerald-500/10 rounded-lg text-emerald-400 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-xs font-bold text-white uppercase tracking-wide group-hover:text-emerald-400 transition-colors">
                            Health & Food Support</p>
                        <div class="text-[10px] text-neutral-400 mt-0.5">
                            <p><?php echo htmlspecialchars($health_email); ?></p>
                            <p><?php echo htmlspecialchars($health_phone); ?></p>
                        </div>
                    </div>
                </div>

                <div
                    class="group flex items-center gap-4 p-4 rounded-xl bg-neutral-800/30 border border-neutral-800 hover:border-amber-500/30 hover:bg-neutral-800/50 transition-all duration-300">
                    <div
                        class="p-2.5 bg-amber-500/10 rounded-lg text-amber-400 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-xs font-bold text-white uppercase tracking-wide group-hover:text-amber-400 transition-colors">
                            Library & Books Support</p>
                        <div class="text-[10px] text-neutral-400 mt-0.5">
                            <p><?php echo htmlspecialchars($library_email); ?></p>
                            <p><?php echo htmlspecialchars($library_phone); ?></p>
                        </div>
                    </div>
                </div>

                <div
                    class="group flex items-center gap-4 p-4 rounded-xl bg-neutral-800/30 border border-neutral-800 hover:border-red-500/30 hover:bg-neutral-800/50 transition-all duration-300">
                    <div class="p-2.5 bg-red-500/10 rounded-lg text-red-400 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-xs font-bold text-white uppercase tracking-wide group-hover:text-red-400 transition-colors">
                            Campus Security Support</p>
                        <div class="text-[10px] text-neutral-400 mt-0.5">
                            <p><?php echo htmlspecialchars($security_email); ?></p>
                            <p><?php echo htmlspecialchars($security_phone); ?></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>

</body>
<script src="./../assets/js/account_config.js"></script>

</html>