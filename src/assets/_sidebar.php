<?php
$activeClass = 'bg-blue-500/10 text-blue-400 shadow-[0_0_15px_rgba(59,130,246,0.1)] border border-blue-500/20';
$inactiveClass = 'text-neutral-400 hover:text-white hover:bg-neutral-800/60 border border-transparent transition-all duration-200';
?>

<aside class="w-64 bg-neutral-900/95 border-r border-neutral-800 flex flex-col h-screen">

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto" id="sidebar-nav">

        <?php if (!$is_admin): ?>

            <a href="?page=overview"
                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl <?php echo $page === 'overview' ? $activeClass : $inactiveClass; ?>">
                <svg class="w-5 h-5 mr-3 <?php echo $page === 'overview' ? 'text-blue-400' : 'text-neutral-500 group-hover:text-white'; ?> transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Overview
            </a>

            <a href="?page=reports"
                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl <?php echo $page === 'reports' ? $activeClass : $inactiveClass; ?>">
                <svg class="w-5 h-5 mr-3 <?php echo $page === 'reports' ? 'text-blue-400' : 'text-neutral-500 group-hover:text-white'; ?> transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Reports
            </a>

        <?php endif; ?>

        <?php if ($is_admin): ?>

            <a href="?page=status-board"
                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl <?php echo $page === 'status-board' ? $activeClass : $inactiveClass; ?>">
                <svg class="w-5 h-5 mr-3 <?php echo $page === 'status-board' ? 'text-blue-400' : 'text-neutral-500 group-hover:text-white'; ?> transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Status Board
            </a>

            <a href="?page=activity-logs"
                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl <?php echo $page === 'activity-logs' ? $activeClass : $inactiveClass; ?>">
                <svg class="w-5 h-5 mr-3 <?php echo $page === 'activity-logs' ? 'text-blue-400' : 'text-neutral-500 group-hover:text-white'; ?> transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Activity Logs
            </a>

            <a href="?page=admin"
                class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl <?php echo $page === 'admin' ? $activeClass : $inactiveClass; ?>">
                <svg class="w-5 h-5 mr-3 <?php echo $page === 'admin' ? 'text-blue-400' : 'text-neutral-500 group-hover:text-white'; ?> transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                System Admin
            </a>

        <?php endif; ?>

    </nav>
</aside>