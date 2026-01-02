<?php
$current_email = $_SESSION['user_email'];
$user_initial  = strtoupper($current_email[0]);
?>

<header class="w-full bg-neutral-900/95 border-b border-neutral-800 px-6 py-4 flex items-center justify-between backdrop-blur-sm sticky top-0 z-20">
    
    <div class="flex items-center gap-5">
        
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center border border-blue-500/20 shadow-[0_0_15px_rgba(59,130,246,0.1)]">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-white tracking-tight"> <?php echo htmlspecialchars($_ENV['APP_NAME']); ?> Dashboard</h2>
        </div>

    </div>

    <div class="flex items-center gap-4">
        
        <div class="text-right">
            <div class="text-sm font-semibold text-white">
                <?php echo htmlspecialchars($current_email); ?>
            </div>
            <div class="text-xs text-neutral-400 font-medium uppercase tracking-wide">
                <?php echo ($is_admin ?? false) ? 'Administrator' : 'User'; ?>
            </div>
        </div>

        <button
            onclick="window.location.href='./pages/account.php'"
            class="w-10 h-10 rounded-full bg-neutral-800 border border-neutral-700 hover:border-blue-500/50 hover:shadow-[0_0_15px_rgba(59,130,246,0.3)] transition-all duration-300 flex items-center justify-center text-neutral-300 hover:text-white font-bold text-sm"
        >
            <?php echo $user_initial; ?>
        </button>
    </div>
</header>