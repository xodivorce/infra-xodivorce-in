<?php
$departments = [
    'WiFi & Network Issue',
    'Electrical Issue',
    'Water & Plumbing Issue',
    'HVAC (AC/Heating) Issue',
    'Furniture & Fixtures Issue',
    'Cleaning & Janitorial Issue',
    'Security & Safety Issue',
    'Road & Pathway Damage Issue',
    'Library & Study Issue',
    'Lost & Stolen Issue',
    'Medical/Health Issue',
    'Other Issues',
];


$services = [];

$sql = "
    SELECT
        REPLACE(category, '&amp;', '&') AS category,
        SUM(TRIM(status) = 'Opened') AS opened_count,
        SUM(TRIM(status) = 'In Progress') AS progress_count
    FROM reports
    GROUP BY category
";


$result = $conn->query($sql);

$deptStats = [];
while ($row = $result->fetch_assoc()) {
    $deptStats[$row['category']] = $row;
}

function getStatusConfig($status) {
    switch ($status) {
        case 'Operational':
            return [
                'color' => 'green',
                'hover_border' => 'hover:border-green-500/50 hover:shadow-green-500/5',
                'group_hover_icon' => 'group-hover:text-green-400 group-hover:bg-green-500/10 group-hover:border-green-500/20'
            ];
        case 'Maintenance':
            return [
                'color' => 'yellow',
                'hover_border' => 'hover:border-yellow-500/50 hover:shadow-yellow-500/5',
                'group_hover_icon' => 'group-hover:text-yellow-400 group-hover:bg-yellow-500/10 group-hover:border-yellow-500/20'
            ];
        case 'Outage':
            return [
                'color' => 'red',
                'hover_border' => 'hover:border-red-500/50 hover:shadow-red-500/5',
                'group_hover_icon' => 'group-hover:text-red-400 group-hover:bg-red-500/10 group-hover:border-red-500/20'
            ];
        default:
            return [
                'color' => 'gray',
                'hover_border' => 'hover:border-neutral-500/50',
                'group_hover_icon' => 'group-hover:text-white'
            ];
    }
}

function getIconPath($name) {
    if (strpos($name, 'WiFi') !== false) return 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0';
    if (strpos($name, 'Electrical') !== false) return 'M13 10V3L4 14h7v7l9-11h-7z';
    if (strpos($name, 'Water') !== false) return 'M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z';
    if (strpos($name, 'HVAC') !== false) return 'M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5';
    if (strpos($name, 'Furniture') !== false) return 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4';
    if (strpos($name, 'Cleaning') !== false) return 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10';
    if (strpos($name, 'Security') !== false) return 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z';
    if (strpos($name, 'Road') !== false) return 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7';
    if (strpos($name, 'Library') !== false) return 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253';
    if (strpos($name, 'Lost') !== false) return 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z';
    if (strpos($name, 'Medical') !== false) return 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z';
    return 'M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z';
}


$activeServices = 0;
$maintenanceCount = 0;
$highPriority = 0;

foreach ($departments as $dept) {
    $opened   = $deptStats[$dept]['opened_count']  ?? 0;
    $progress = $deptStats[$dept]['progress_count'] ?? 0;

    if ($opened > 0) {
        $status = 'Outage';
        $msg    = "$opened active issue(s)";
        $highPriority++;
    } elseif ($progress > 0) {
        $status = 'Maintenance';
        $msg    = "$progress issue(s) in progress";
        $maintenanceCount++;
    } else {
        $status = 'Operational';
        $msg    = 'No active issues';
        $activeServices++;
    }

    $services[] = [
        'name'   => $dept,
        'status' => $status,
        'msg'    => $msg
    ];
}

$totalServices = count($services);

$activeIncidents = $maintenanceCount + $highPriority;

if ($highPriority > 0) {
    $sysData = [
        'status' => 'System Alert',
        'msg'    => 'Critical issues detected',
        'text'   => 'text-red-400',
        'icon'   => 'text-red-500',
        'bg'     => 'bg-red-500/10 border-red-500/20',
        'hover'  => 'hover:border-red-500/50',
        'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'
    ];
} elseif ($maintenanceCount > 0) {
    $sysData = [
        'status' => 'Maintenance',
        'msg'    => 'Performance degraded',
        'text'   => 'text-yellow-400',
        'icon'   => 'text-yellow-500',
        'bg'     => 'bg-yellow-500/10 border-yellow-500/20',
        'hover'  => 'hover:border-yellow-500/50',
        'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    ];
} else {
    $sysData = [
        'status' => 'Operational',
        'msg'    => 'All core systems nominal',
        'text'   => 'text-green-400',
        'icon'   => 'text-green-500',
        'bg'     => 'bg-green-500/10 border-green-500/20',
        'hover'  => 'hover:border-green-500/50',
        'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    ];
}
?>

<div class="space-y-6 max-w-7xl mx-auto pb-10">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-neutral-800">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Campus Status</h1>
            <p class="text-sm text-neutral-400 mt-1">Live infrastructure and service health</p>
        </div>

        <div class="flex items-center gap-4 text-xs bg-neutral-900/50 p-2 rounded-lg border border-neutral-800">
            <span class="flex items-center gap-2 text-neutral-300">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                Operational
            </span>
            <span class="flex items-center gap-2 text-neutral-300">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                </span>
                Maintenance
            </span>
            <span class="flex items-center gap-2 text-neutral-300">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
                Outage
            </span>
        </div>
    </div>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-neutral-800 border border-neutral-700/50 rounded-xl p-5 flex items-center justify-between <?= $sysData['hover'] ?> transition-colors duration-300">
            <div>
                <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Overall System</p>
                <p class="text-xl font-bold <?= $sysData['text'] ?> mt-1"><?= $sysData['status'] ?></p>
                <p class="text-xs text-neutral-400 mt-1"><?= $sysData['msg'] ?></p>
            </div>
            <div class="w-12 h-12 rounded-lg <?= $sysData['bg'] ?> flex items-center justify-center <?= $sysData['icon'] ?>">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <?= $sysData['svg'] ?>
                </svg>
            </div>
        </div>

        <div class="bg-neutral-800 border border-neutral-700/50 rounded-xl p-5 flex items-center justify-between hover:border-blue-500/50 transition-colors duration-300">
            <div>
                <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Active System</p>
                <div class="flex items-baseline gap-1 mt-1">
                    <p class="text-2xl font-bold text-white"><?= $activeServices ?></p>
                    <span class="text-sm text-neutral-400">/ <?= $totalServices ?></span>
                </div>
                <p class="text-xs text-neutral-400 mt-1"><?= ($totalServices - $activeServices) ?> services inactive</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
            </div>
        </div>

        <div class="bg-neutral-800 border border-neutral-700/50 rounded-xl p-5 flex items-center justify-between hover:border-yellow-500/50 transition-colors duration-300">
            <div>
                <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">In Maintenance</p>
                <p class="text-2xl font-bold text-white mt-1"><?= $maintenanceCount ?></p>
                <p class="text-xs text-neutral-400 mt-1">Fixing the things</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
        </div>

        <div class="bg-neutral-800 border border-neutral-700/50 rounded-xl p-5 flex items-center justify-between hover:border-red-500/50 transition-colors duration-300">
            <div>
                <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Outage System</p>
                <p class="text-2xl font-bold text-white mt-1"><?= $highPriority ?></p>
                <p class="text-xs text-neutral-400 mt-1">Take an action now</p>
            </div>
            <div class="w-12 h-12 rounded-lg bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-500 <?php echo ($highPriority > 0) ? 'animate-pulse' : ''; ?>">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
        </div>

    </section>

    <section>
        <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Services Status
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach ($services as $s): 
                $config = getStatusConfig($s['status']);
                $icon = getIconPath($s['name']);
                $dotColor = $config['color'];
            ?>
            <div class="group bg-neutral-800 border border-neutral-700/50 rounded-xl p-4 transition-all duration-300 hover:shadow-lg <?= $config['hover_border'] ?>">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-neutral-900 border border-neutral-700 flex items-center justify-center text-neutral-400 transition-all <?= $config['group_hover_icon'] ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $icon ?>"></path>
                        </svg>
                    </div>
                    
                    <div class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-<?= $dotColor ?>-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-<?= $dotColor ?>-500"></span>
                    </div>

                </div>
                <h3 class="font-semibold text-white text-sm truncate"><?= htmlspecialchars($s['name']) ?></h3>
                <p class="text-xs text-neutral-400 mt-1 truncate"><?= htmlspecialchars($s['msg']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    
</div>