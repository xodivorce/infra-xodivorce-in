<?php

$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/core/init.php';
require_once $basePath . '/core/vendor/autoload.php';

session_start();

$step = 1;
$token = null;
$error = null;

$clientId = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
$currentPath = strtok($_SERVER["REQUEST_URI"], '?');
$redirectUri = $protocol . "://" . $_SERVER['HTTP_HOST'] . $currentPath;


$keysPresent = !empty($clientId) && !empty($clientSecret);

$authUrl = "#";
if ($keysPresent) {
    try {
        $client = new Google\Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("https://www.googleapis.com/auth/drive.file");
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $authUrl = $client->createAuthUrl();
    } catch (Exception $e) {
        $error = "Configuration Error: " . $e->getMessage();
    }
}

if (isset($_GET['code'])) {
    if (!$keysPresent) {
        $error = "Missing .env credentials.";
    } else {
        try {
            $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (isset($accessToken['error']))
                throw new Exception($accessToken['error']);
            $token = $accessToken['refresh_token'];
            $step = 'complete';
        } catch (Exception $e) {
            $error = "Token Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <!-- Meta & Viewport Configuration -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon & PWA Assets -->
    <link rel="icon" type="image/png" href="./../../assets/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="./../../assets/favicon/favicon.svg" />
    <link rel="shortcut icon" href="./../../assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="./../../assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="./../../assets/favicon/site.webmanifest" />
    <meta name="apple-mobile-web-app-title" content="<?php echo htmlspecialchars($_ENV['DOMAIN']); ?>" />

    <!-- Main Stylesheet (Tailwind CSS) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Lexend Deca -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

    <!-- Dynamic Page Title (from .env DOMAIN variable) -->
    <title><?php echo htmlspecialchars($_ENV['APP_NAME'] . ' | G - Drive OAUTH'); ?></title>

    <!-- Debug Kit: Optional outline borders (toggled via .env DEBUG_MODE) -->
    <?php include './../../assets/_debug_kit.php'; ?>
</head>

<body class="bg-[#0b0c0e] text-slate-200 min-h-screen flex items-center justify-center p-6 font-lexend">

    <div class="max-w-xl w-full">
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 shadow-xl mt-0 mb-2">
                <svg class="w-12 h-12 -mt-1 -mb-1" viewBox="4 7 105 85" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8.46154 85.7051L13.3974 94.2308C14.4231 96.0256 15.8974 97.4359 17.6282 98.4615L35.2564 67.9487H0C0 69.9359 0.512821 71.9231 1.53846 73.7179L8.46154 85.7051Z"
                        fill="#0066DA" />
                    <path
                        d="M55.9615 32.0513L38.3333 1.53846C36.6026 2.5641 35.1282 3.97436 34.1026 5.76923L1.53846 62.1795C0.531683 63.9357 0.00134047 65.9244 0 67.9487H35.2564L55.9615 32.0513Z"
                        fill="#00AC47" />
                    <path
                        d="M94.2949 98.4615C96.0256 97.4359 97.5 96.0256 98.5256 94.2308L110.385 73.7179C111.41 71.9231 111.923 69.9359 111.923 67.9487H76.6641L84.1667 82.6923L94.2949 98.4615Z"
                        fill="#EA4335" />
                    <path
                        d="M55.9615 32.0513L73.5898 1.53846C71.859 0.512821 69.8718 0 67.8205 0H44.1026C42.0513 0 40.0641 0.576923 38.3333 1.53846L55.9615 32.0513Z"
                        fill="#00832D" />
                    <path
                        d="M76.6667 67.9487H35.2564L17.6282 98.4615C19.359 99.4872 21.3462 100 23.3974 100H88.5256C90.5769 100 92.5641 99.4231 94.2949 98.4615L76.6667 67.9487Z"
                        fill="#2684FC" />
                    <path
                        d="M94.1026 33.9744L77.8205 5.76923C76.7949 3.97436 75.3205 2.5641 73.5897 1.53846L55.9615 32.0513L76.6667 67.9487H111.859C111.859 65.9615 111.346 63.9744 110.321 62.1795L94.1026 33.9744Z"
                        fill="#FFBA00" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-white tracking-tight mt-1">GOOGLE DRIVE OAUTH TOKEN GEN.</h1>
            <p class="text-slate-400 text-xs uppercase tracking-[0.2em] font-bold mt-2 opacity-80">
                <?php echo htmlspecialchars($_ENV['DOMAIN']); ?>
            </p>
        </div>

        <?php if ($error): ?>
            <div
                class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-2xl flex gap-3 items-center text-red-200 text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" />
                </svg>
                <p class="font-medium"><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-[#1a1a1a]/90 border border-white/10 rounded-[2.5rem] p-8 shadow-2xl backdrop-blur-sm">

            <?php if ($step === 'complete'): ?>
                <div class="text-center">
                    <div
                        class="w-12 h-12 bg-green-500/20 text-green-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-6">Access Token Ready</h2>
                    <div
                        class="bg-black/60 border border-white/10 rounded-2xl p-5 font-mono text-sm text-green-400 break-all select-all mb-6 text-left ring-1 ring-green-500/20">
                        <?php echo $token; ?>
                    </div>
                    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                        <p class="text-red-300 text-xs font-bold uppercase tracking-wider">Security Warning</p>
                        <p class="text-red-200/70 text-[11px] mt-1 italic">Delete setup_token.php from your server
                            immediately.</p>
                    </div>
                </div>

            <?php else: ?>

                <div class="space-y-1">

                    <div class="relative pl-14 pb-12">
                        <div class="absolute left-[19px] top-10 bottom-0 w-0.5 bg-[#2d2d2d]"></div>
                        <span
                            class="absolute left-0 top-0 w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold z-10 shadow-lg ring-4 ring-[#1a1a1a]">1</span>
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-bold text-white">Cloud Console</h3>
                            <a href="https://console.cloud.google.com/" target="_blank"
                                class="text-slate-400 hover:text-blue-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                        <p class="text-sm text-white-200 mt-1">Add this redirection link:<br><code
                                class="bg-neutral-900 px-2 py-0.5 rounded text-blue-400 border border-gray-400/40 text-xs"><?php echo $redirectUri; ?></code>
                        </p>
                    </div>

                    <div class="relative pl-14 pb-12">
                        <div class="absolute left-[19px] top-10 bottom-0 w-0.5 bg-[#2d2d2d]"></div>
                        <span
                            class="absolute left-0 top-0 w-10 h-10 <?php echo $keysPresent ? 'bg-green-600' : 'bg-slate-800 text-slate-500'; ?> rounded-full flex items-center justify-center text-white text-sm font-bold z-10 transition-all ring-4 ring-[#1a1a1a]"><?php echo $keysPresent ? '✓' : '2'; ?></span>
                        <h3 class="text-lg font-bold text-white">Environment</h3>
                        <p
                            class="text-sm mt-1 <?php echo $keysPresent ? 'text-green-400 font-medium' : 'text-slate-400'; ?>">
                            <?php echo $keysPresent ? 'System credentials loaded successfully.' : 'Missing Client ID or Secret in .env'; ?>
                        </p>
                    </div>

                    <div class="relative pl-14 pb-2">
                        <div class="absolute left-[19px] top-10 bottom-auto w-0.5 bg-[#2d2d2d] h-0"></div>
                        <span
                            class="absolute left-0 top-0 w-10 h-10 <?php echo $keysPresent ? 'bg-blue-600 shadow-lg' : 'bg-slate-800 text-slate-500'; ?> rounded-full flex items-center justify-center text-white text-sm font-bold z-10 transition-all ring-4 ring-[#1a1a1a]">3</span>
                        <h3 class="text-lg font-bold text-white mb-3">Authorization</h3>

                        <a href="<?php echo $authUrl; ?>" target="_blank"
                            class="<?php echo $keysPresent
                                ? 'bg-white text-black hover:bg-slate-200'
                                : 'bg-slate-800 text-slate-500 cursor-not-allowed'; ?> px-8 py-3 font-bold text-xs inline-flex items-center gap-2 shadow-lg uppercase tracking-wider rounded-[1.75rem] transition-all">
                            <svg class="w-4 h-4 -mt-0.5" viewBox="0 0 24 24">
                                <path fill="#4285F4"
                                    d="M23.5 12.3c0-.8-.1-1.5-.2-2.3H12v4.4h6.7c-.3 1.5-1.2 2.6-2.5 3.4v2.8h3.9c2.3-2 3.4-4.9 3.4-8.3z" />
                                <path fill="#34A853"
                                    d="M12 24c2.9 0 5.4-.9 7.2-2.5l-3.9-3c-1 .7-2.3 1.1-3.7 1.1-2.9 0-5.3-2-6.2-4.7H1.3v3C3.1 21.5 7.2 24 12 24z" />
                                <path fill="#FBBC04"
                                    d="M5.8 14.1c-.2-.7-.4-1.4-.4-2.1s.1-1.5.4-2.1V7h-4v3C1.4 11.8 1 13.1 1 14.4s.4 2.6 1 3.8l3.8-2.9z" />
                                <path fill="#EA4335"
                                    d="M12 4.6c1.7 0 3.2.6 4.4 1.7l3.3-3.3C17.5 1.1 14.9 0 12 0 7.1 0 3.2 2.8 1.3 6.9l3.8 2.9c.9-2.7 3.3-5.2 6.9-5.2z" />
                            </svg>

                            Authorize G - Drive Account
                        </a>

                    </div>
                    <div class="mt-2 text-center">
                        <p class="text-xs text-white-200 italic font-mono">
                            Token will genarate after the Varification complete.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-10 flex flex-col items-center">
            <div class="flex items-center gap-4 mb-3">
                <a href="https://github.com/xodivorce/infra-xodivorce-in/blob/main/FAQs/FAQ_EN.md" target="_blank"
                    class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-all group">
                    <svg class="w-4 h-4 opacity-70 group-hover:opacity-100" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd" />
                    </svg>
                    Need Help? Checkout Github Docs</a>
                <span class="w-px h-3 bg-slate-800"></span>
                <span
                    class="text-xs font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full border border-blue-500/20">v1.3.2</span>
            </div>

            <div class="flex items-center gap-2">
                <div class="h-px w-8 bg-gradient-to-r from-transparent to-slate-800"></div>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-[0.4em]">Secure Infrastructure
                    Pipeline</p>
                <div class="h-px w-8 bg-gradient-to-l from-transparent to-slate-800"></div>
            </div>
        </div>
    </div>

</body>

</html>