<?php
session_start();

// Initialize the application
include '../init.php';
include '../connection.php';

// Suppress all PHP errors in production environment
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$user_id = $_SESSION['user_id'] ?? null;

$username = 'Unknown';
$email = 'Unknown';
$password_hash = '';
$password_plain = $_SESSION['user_password_plain'] ?? null;

if ($user_id) {
    $stmt = $conn->prepare("SELECT username, email, password_hash FROM users WHERE id = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($db_username, $db_email, $db_password_hash);
        $stmt->fetch();
        if (!empty($db_username))
            $username = $db_username;
        if (!empty($db_email))
            $email = $db_email;
        $password_hash = $db_password_hash;
        $stmt->close();
    } else {
        die("Database error: " . htmlspecialchars($conn->error));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Account Test Page</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="../../src/output.css">
    <style>
        .kv {
            min-width: 160px;
            font-weight: 500;
        }

        .card-row {
            flex-wrap: wrap;
        }

        .card-item {
            word-break: break-word;
        }
    </style>
</head>

<body class="bg-neutral-900 text-gray-200 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-4xl">
        <div class="bg-black border border-neutral-800 rounded-3xl p-8 shadow-2xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <h1 class="text-3xl font-bold text-white">Account Info — Test</h1>
                <div class="text-lg text-gray-400">
                    Status:
                    <span class="<?php echo $is_logged_in ? 'text-green-400' : 'text-red-400'; ?>">
                        <?php echo $is_logged_in ? 'Logged in ✅' : 'Not logged in ❌'; ?>
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-neutral-900 rounded-2xl flex items-center gap-4 card-row">
                    <div class="kv text-gray-400">Username</div>
                    <div class="flex-1 text-lg card-item"><?php echo htmlspecialchars($username); ?></div>
                </div>

                <div class="p-6 bg-neutral-900 rounded-2xl flex items-center gap-4 card-row">
                    <div class="kv text-gray-400">Email</div>
                    <div class="flex-1 text-lg card-item"><?php echo htmlspecialchars($email); ?></div>
                </div>

                <div class="p-6 bg-neutral-900 rounded-2xl flex items-center gap-4 card-row">
                    <div class="kv text-gray-400">Password</div>
                    <div class="flex-1 card-item">
                        <?php if ($password_plain !== null): ?>
                            <div class="relative">
                                <input id="plainPwd" type="password" readonly
                                    value="<?php echo htmlspecialchars($password_plain); ?>"
                                    class="w-full bg-transparent border border-neutral-700 rounded-md px-4 py-3 text-lg text-gray-200 focus:outline-none" />
                                <button id="togglePwd" type="button"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-neutral-800 px-3 py-1 rounded text-sm hover:bg-neutral-700">
                                    Show
                                </button>
                            </div>
                            <p class="mt-2 text-sm text-yellow-300">Plaintext available from session for testing purposes
                                only.</p>
                        <?php else: ?>
                            <div class="text-gray-400 text-sm">Plaintext not stored, password hashed(secure).</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="p-6 bg-neutral-900 rounded-2xl flex items-center gap-4 card-row">
                    <div class="kv text-gray-400">Password Hash</div>
                    <div class="flex-1 text-sm break-all card-item"><?php echo htmlspecialchars($password_hash); ?>
                    </div>
                </div>

                <div class="p-6 bg-neutral-900 rounded-2xl flex items-center gap-4 card-row">
                    <div class="kv text-gray-400">User ID</div>
                    <div class="flex-1 text-lg card-item"><?php echo htmlspecialchars($user_id ?? '—'); ?></div>
                </div>

                <div class="p-6 bg-neutral-900 rounded-2xl flex items-center gap-4 card-row">
                    <div class="kv text-gray-400">Session Data</div>
                    <div class="flex-1 text-sm text-gray-400 card-item">
                        <?php echo htmlspecialchars(json_encode(array_intersect_key($_SESSION, array_flip(['user_id', 'user_name', 'user_email'])))); ?>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex gap-4 justify-start flex-wrap">
                <form method="get" action="" class="inline">
                    <button type="submit" name="action" value="logout"
                        class="px-6 py-3 rounded-full bg-red-600 hover:bg-red-700 text-white text-lg font-medium">
                        Logout
                    </button>
                </form>
                <button type="button" onclick="window.location.href='../../home.php';"
                    class="px-6 py-3 rounded-full bg-neutral-800 hover:bg-neutral-700 text-gray-200 text-lg font-medium">
                    Back
                </button>
            </div>

        </div>
    </div>

    <script>
        (function () {
            const btn = document.getElementById('togglePwd');
            const input = document.getElementById('plainPwd');
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
                if (input.type === 'password') {
                    input.type = 'text';
                    btn.textContent = 'Hide';
                } else {
                    input.type = 'password';
                    btn.textContent = 'Show';
                }
            });
        })();
    </script>
</body>

</html>