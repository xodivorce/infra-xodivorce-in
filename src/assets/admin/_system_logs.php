<?php
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "<div class='text-red-500 p-6'>Access Denied</div>";
    exit;
}

$sql = "SELECT r.id, r.title, r.priority, r.status, r.created_at, r.updated_at, u.username, u.email, u.is_admin 
        FROM reports r 
        JOIN users u ON r.user_id = u.id";
$result = $conn->query($sql);

$logs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $logs[] = [
            'timestamp' => strtotime($row['created_at']),
            'formatted_time' => date("M j, Y • H:i", strtotime($row['created_at'])),
            'actor_name' => $row['username'],
            'actor_email' => $row['email'],
            'actor_role' => $row['is_admin'] ? 'Administrator' : 'User',
            'action' => 'Created report',
            'report_id' => $row['id'],
            'title' => htmlspecialchars($row['title']),
            'priority' => $row['priority'],
            'status' => 'Opened',
            'is_update' => false
        ];

        if (strtotime($row['updated_at']) > strtotime($row['created_at'])) {
            $actionText = 'Updated status';
            if ($row['status'] === 'Resolved') $actionText = 'Resolved report';
            if ($row['status'] === 'In Progress') $actionText = 'Marked In Progress';

            $logs[] = [
                'timestamp' => strtotime($row['updated_at']),
                'formatted_time' => date("M j, Y • H:i", strtotime($row['updated_at'])),
                'actor_name' => 'System Admin', 
                'actor_email' => 'admin@system',
                'actor_role' => 'Administrator',
                'action' => $actionText,
                'report_id' => $row['id'],
                'title' => htmlspecialchars($row['title']),
                'priority' => $row['priority'],
                'status' => $row['status'],
                'is_update' => true
            ];
        }
    }
}

usort($logs, function($a, $b) {
    return $b['timestamp'] - $a['timestamp'];
});

$itemsPerPage = 6;
$totalItems = count($logs);
$totalPages = ceil($totalItems / $itemsPerPage);

$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;

if ($page < 1) $page = 1;
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;

$offset = ($page - 1) * $itemsPerPage;
$currentLogs = array_slice($logs, $offset, $itemsPerPage);
?>

<section class="space-y-6">

  <header>
    <h1 class="text-2xl font-semibold text-white">System Logs</h1>
    <p class="mt-1 text-sm text-neutral-400">
      Administrative and user actions across reports
    </p>
  </header>

  <div class="bg-neutral-800 rounded-lg border border-neutral-700 overflow-hidden shadow-sm">
    <div class="overflow-x-auto custom-scrollbar">
      <table class="w-full">
        <thead class="bg-neutral-900/50 border-b border-neutral-700">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Time</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Actor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Action</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Report</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Priority</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Status</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-neutral-700/50">

          <?php if (empty($currentLogs)): ?>
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-neutral-500">
                    No system logs found.
                </td>
            </tr>
          <?php else: ?>
            
            <?php foreach ($currentLogs as $log): ?>
                <?php 
                    $priorityColor = match($log['priority']) {
                        'High' => 'text-red-400',
                        'Medium' => 'text-yellow-400',
                        'Low' => 'text-blue-400',
                        default => 'text-neutral-400'
                    };

                    $statusConfig = match($log['status']) {
                        'Resolved' => ['text' => 'text-green-400', 'bg' => 'bg-green-500/10', 'border' => 'border-green-500/20', 'icon' => 'text-green-500', 'path' => 'M5 13l4 4L19 7'],
                        'In Progress' => ['text' => 'text-yellow-400', 'bg' => 'bg-yellow-500/10', 'border' => 'border-yellow-500/20', 'icon' => 'text-yellow-500', 'path' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        'Opened' => ['text' => 'text-blue-400', 'bg' => 'bg-blue-500/10', 'border' => 'border-blue-500/20', 'icon' => 'text-blue-500', 'path' => 'M12 4v16m8-8H4'],
                        default => ['text' => 'text-neutral-400', 'bg' => 'bg-neutral-500/10', 'border' => 'border-neutral-500/20', 'icon' => 'text-neutral-500', 'path' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
                    };
                ?>

                <tr class="hover:bg-neutral-700/30 transition-colors">
                    <td class="px-6 py-4 text-sm text-neutral-300 font-mono text-xs whitespace-nowrap">
                        <?php echo $log['formatted_time']; ?>
                    </td>

                    <td class="px-6 py-4 text-sm text-white">
                        <div class="font-medium"><?php echo htmlspecialchars($log['actor_name']); ?></div>
                        <div class="text-[11px] text-neutral-500"><?php echo htmlspecialchars($log['actor_role']); ?></div>
                    </td>

                    <td class="px-6 py-4 text-sm text-neutral-300">
                        <?php echo $log['action']; ?>
                    </td>

                    <td class="px-6 py-4 text-sm text-neutral-200">
                        <span class="text-neutral-500 font-mono mr-1">#<?php echo $log['report_id']; ?></span> 
                        <?php echo $log['title']; ?>
                    </td>

                    <td class="px-6 py-4">
                        <span class="text-xs font-medium <?php echo $priorityColor; ?>">
                            <?php echo $log['priority']; ?>
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full <?php echo $statusConfig['bg'] . ' ' . $statusConfig['border']; ?> border flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 <?php echo $statusConfig['icon']; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $statusConfig['path']; ?>" />
                                </svg>
                            </div>
                            <span class="text-xs <?php echo $statusConfig['text']; ?>">
                                <?php echo $log['status']; ?>
                            </span>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

          <?php endif; ?>

        </tbody>
      </table>
    </div>

    <div class="bg-neutral-900 border-t border-neutral-700 px-6 py-4 flex items-center justify-between">
        <span class="text-sm text-neutral-400">
            Showing page <span class="font-medium text-white"><?php echo $page; ?></span> of <?php echo max(1, $totalPages); ?>
        </span>
        
        <div class="flex gap-2">
            <?php 
                $prevParams = array_merge($_GET, ['p' => max(1, $page - 1)]);
                $nextParams = array_merge($_GET, ['p' => min($totalPages, $page + 1)]);
                
                $prevDisabled = ($page <= 1) ? 'opacity-50 cursor-not-allowed pointer-events-none' : '';
                $nextDisabled = ($page >= $totalPages) ? 'opacity-50 cursor-not-allowed pointer-events-none' : '';
            ?>
            
            <a href="?<?php echo http_build_query($prevParams); ?>" class="px-3 py-1 bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 rounded-lg text-sm text-white transition-colors <?php echo $prevDisabled; ?>">
                Previous
            </a>
            
            <a href="?<?php echo http_build_query($nextParams); ?>" class="px-3 py-1 bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 rounded-lg text-sm text-white transition-colors <?php echo $nextDisabled; ?>">
                Next
            </a>
        </div>
    </div>

  </div>
</section>