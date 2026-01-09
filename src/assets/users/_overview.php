<?php

$openedResult = $conn->query("SELECT COUNT(*) FROM reports WHERE status = 'Opened'");
$openedReports = $openedResult->fetch_row()[0];

$inProgressResult = $conn->query("SELECT COUNT(*) FROM reports WHERE status = 'In Progress'");
$inProgressReports = $inProgressResult->fetch_row()[0];

$resolvedResult = $conn->query("SELECT COUNT(*) FROM reports WHERE status = 'Resolved'");
$resolvedReports = $resolvedResult->fetch_row()[0];

$recentSql = "SELECT r.*, u.username 
              FROM reports r 
              JOIN users u ON r.user_id = u.id 
              ORDER BY r.updated_at DESC 
              LIMIT 6";

$recentResult = $conn->query($recentSql);
$recentActivity = $recentResult->fetch_all(MYSQLI_ASSOC);

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array('y' => 'yr', 'm' => 'mo', 'w' => 'wk', 'd' => 'd', 'h' => 'h', 'i' => 'min', 's' => 'sec');
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . '' . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
?>

<div class="max-w-6xl mx-auto w-full">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

        <div
            class="group bg-neutral-800 rounded-lg border border-neutral-700/50 p-4 shadow-sm hover:border-blue-500/30 transition-all duration-300 flex items-center justify-between">
            <div>
                <h3
                    class="text-xs font-semibold text-neutral-400 uppercase tracking-wider group-hover:text-blue-400 transition-colors">
                    Opened Reports
                </h3>
                <p class="text-2xl font-bold text-white mt-1"><?= $openedReports ?></p>
                <p class="text-[10px] text-neutral-500 mt-1">Newly reported issues</p>
            </div>

            <div
                class="w-10 h-10 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
        </div>

        <div
            class="group bg-neutral-800 rounded-lg border border-neutral-700/50 p-4 shadow-sm hover:border-yellow-500/30 transition-all duration-300 flex items-center justify-between">
            <div>
                <h3
                    class="text-xs font-semibold text-neutral-400 uppercase tracking-wider group-hover:text-yellow-400 transition-colors">
                    Reports In Progress</h3>
                <p class="text-2xl font-bold text-white mt-1"><?= $inProgressReports ?></p>
                <p class="text-[10px] text-neutral-500 mt-1">In progress / Open</p>
            </div>
            <div class="p-3 bg-yellow-500/10 rounded-lg group-hover:bg-yellow-500/20 transition-colors">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div
            class="group bg-neutral-800 rounded-lg border border-neutral-700/50 p-4 shadow-sm hover:border-green-500/30 transition-all duration-300 flex items-center justify-between">
            <div>
                <h3
                    class="text-xs font-semibold text-neutral-400 uppercase tracking-wider group-hover:text-green-400 transition-colors">
                    Resolved Reports</h3>
                <p class="text-2xl font-bold text-white mt-1"><?= $resolvedReports ?></p>
                <p class="text-[10px] text-neutral-500 mt-1">Successfully closed</p>
            </div>
            <div class="p-3 bg-green-500/10 rounded-lg group-hover:bg-green-500/20 transition-colors">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-neutral-800 rounded-lg border border-neutral-700 overflow-hidden shadow-sm">
        <div class="px-4 py-3 border-b border-neutral-700 flex items-center justify-between bg-neutral-900/30">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-semibold text-white">Recents on reports:</h3>
            </div>
        </div>

        <div class="divide-y divide-neutral-700/50">

            <?php if (count($recentActivity) > 0): ?>
                <?php foreach ($recentActivity as $row): ?>
                    <?php
                    $statusColor = 'blue';
                    $iconPath = 'M12 4v16m8-8H4';

                    if ($row['status'] === 'Resolved') {
                        $statusColor = 'green';
                        $iconPath = 'M5 13l4 4L19 7';
                    } elseif ($row['status'] === 'In Progress') {
                        $statusColor = 'yellow';
                        $iconPath = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
                    }
                    ?>

                    <div class="px-4 py-3 hover:bg-neutral-700/30 transition-colors flex items-center gap-3">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-full bg-<?= $statusColor ?>-500/10 border border-<?= $statusColor ?>-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-<?= $statusColor ?>-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $iconPath ?>" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0 grid gap-0.5">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-neutral-200 truncate">
                                    Issue <span class="text-white">#<?= $row['id'] ?></span>
                                    <?= htmlspecialchars($row['status']) ?>
                                </p>
                                <span class="text-[10px] text-neutral-400 whitespace-nowrap">
                                    <?= time_elapsed_string($row['updated_at']) ?>
                                </span>
                            </div>
                            <p class="text-xs text-neutral-400 truncate">
                                <?= htmlspecialchars($row['title']) ?> • <span><?= htmlspecialchars($row['username']) ?></span>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="px-4 py-6 text-center text-sm text-neutral-500">
                    No recent activity found.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>