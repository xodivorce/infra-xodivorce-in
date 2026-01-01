<?php

$whereClauses = [];

$current_status = isset($_GET['status']) ? $_GET['status'] : '';
if (!empty($current_status)) {
    $status_esc = $conn->real_escape_string($current_status);
    $whereClauses[] = "r.status = '$status_esc'";
}

$current_date = isset($_GET['date']) ? $_GET['date'] : 'all';
if ($current_date !== 'all') {
    $days = intval($current_date);
    $whereClauses[] = "r.created_at >= DATE_SUB(NOW(), INTERVAL $days DAY)";
}

$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($search_query)) {
    $search_esc = $conn->real_escape_string($search_query);
    $whereClauses[] = "(r.title LIKE '%$search_esc%' OR u.username LIKE '%$search_esc%' OR r.id = '$search_esc')";
}

$whereSql = "";
if (count($whereClauses) > 0) {
    $whereSql = "WHERE " . implode(' AND ', $whereClauses);
}

$limit = 4;
$page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
$offset = ($page - 1) * $limit;

$count_sql = "SELECT COUNT(*) as total FROM reports r LEFT JOIN users u ON r.user_id = u.id $whereSql";
$count_result = $conn->query($count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT r.*, u.username FROM reports r LEFT JOIN users u ON r.user_id = u.id $whereSql ORDER BY r.id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<div class="max-w-7xl mx-auto space-y-6 pb-10">

    <div class="flex items-center justify-between">
        <div class="bg-neutral-900 p-1 rounded-xl border border-neutral-800 inline-flex">
            <button onclick="switchTab('reports')" id="tab-btn-reports"
                class="px-4 py-2 text-sm font-medium rounded-lg bg-neutral-800 text-white shadow-sm border border-neutral-700 transition-all cursor-default flex items-center gap-2">
                Campus Reports
            </button>
            <button onclick="switchTab('gemini')" id="tab-btn-gemini"
                class="px-4 py-2 text-sm font-medium rounded-lg text-neutral-400 hover:text-white hover:bg-neutral-800 transition-all cursor-pointer flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z" />
                </svg>
                Ask Gemini
            </button>
        </div>
    </div>

    <div id="view-reports" class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Campus Reports</h1>
                <p class="mt-1 text-sm text-neutral-400">Manage facility and infrastructure issues</p>
            </div>
            <button onclick="document.getElementById('createModal').classList.remove('hidden')"
                class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-lg shadow-blue-900/20 transition-all flex items-center justify-center gap-2 group">
                <svg class="w-4 h-4 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Report
            </button>
        </div>

        <form method="GET" action="" id="filterForm"
            class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-sm">
            <input type="hidden" name="page" value="reports">
            <input type="hidden" name="status" id="statusInput"
                value="<?php echo htmlspecialchars($current_status); ?>">

            <div class="flex flex-col lg:flex-row gap-4 justify-between">
                <div class="flex overflow-x-auto pb-2 lg:pb-0 gap-2 no-scrollbar">
                    <?php
                    function getBtnClass($isActive)
                    {
                        return $isActive
                            ? 'px-4 py-2 bg-blue-600/10 text-blue-400 border border-blue-600/20 text-sm font-medium rounded-lg whitespace-nowrap transition-all'
                            : 'px-4 py-2 hover:bg-neutral-700 text-neutral-400 hover:text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap border border-transparent';
                    }
                    ?>
                    <button type="button" onclick="setStatusAndSubmit('')"
                        class="<?php echo getBtnClass($current_status === ''); ?>">All Reports</button>
                    <button type="button" onclick="setStatusAndSubmit('Opened')"
                        class="<?php echo getBtnClass($current_status === 'Opened'); ?>">Opened</button>
                    <button type="button" onclick="setStatusAndSubmit('In Progress')"
                        class="<?php echo getBtnClass($current_status === 'In Progress'); ?>">In Progress</button>
                    <button type="button" onclick="setStatusAndSubmit('Resolved')"
                        class="<?php echo getBtnClass($current_status === 'Resolved'); ?>">Resolved</button>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative min-w-[200px]">
                        <select name="date" onchange="this.form.submit()"
                            class="w-full appearance-none px-4 py-2 bg-neutral-900 border border-neutral-700 rounded-lg text-sm text-neutral-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all cursor-pointer">
                            <option value="7" <?php echo $current_date == '7' ? 'selected' : ''; ?>>Last 7 days</option>
                            <option value="30" <?php echo $current_date == '30' ? 'selected' : ''; ?>>Last 30 days
                            </option>
                            <option value="90" <?php echo $current_date == '90' ? 'selected' : ''; ?>>Last 90 days
                            </option>
                            <option value="all" <?php echo $current_date == 'all' ? 'selected' : ''; ?>>All time</option>
                        </select>
                        <svg class="absolute right-3 top-2.5 h-4 w-4 text-neutral-500 pointer-events-none" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div class="relative w-full sm:w-64">
                        <input type="text" name="search" placeholder="Search..."
                            value="<?php echo htmlspecialchars($search_query); ?>"
                            class="w-full pl-10 pr-4 py-2 bg-neutral-900 border border-neutral-700 rounded-lg text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                        <svg class="absolute left-3 top-2.5 h-4 w-4 text-neutral-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
            <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4">
                <p class="text-neutral-400 text-sm text-center">Please switch to desktop view to view table.</p>
            </div>
        </div>

        <div class="hidden md:block bg-neutral-800 rounded-xl border border-neutral-700 overflow-hidden shadow-sm">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full">
                    <thead class="bg-neutral-900/50 border-b border-neutral-700">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider w-12">
                                ID</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider w-1/6">
                                Title</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider w-1/6">
                                Category</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider w-16">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider w-16">
                                Priority</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider w-12">
                                Image</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider w-30">
                                Location</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider w-24">
                                Date</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider w-24">
                                Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-neutral-700/50">
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                // Status & Priority Styling
                                $statusBadgeClass = 'bg-blue-900/30 text-blue-400 border-blue-700/50';
                                $statusDotClass = 'bg-blue-400';
                                if ($row['status'] === 'In Progress') {
                                    $statusBadgeClass = 'bg-yellow-900/30 text-yellow-500 border-yellow-700/50';
                                    $statusDotClass = 'bg-yellow-500 animate-pulse';
                                } elseif ($row['status'] === 'Resolved') {
                                    $statusBadgeClass = 'bg-green-900/30 text-green-400 border-green-700/50';
                                    $statusDotClass = 'bg-green-400';
                                }

                                $priorityClass = 'text-green-400';
                                if ($row['priority'] === 'Medium')
                                    $priorityClass = 'text-orange-400';
                                if ($row['priority'] === 'High')
                                    $priorityClass = 'text-red-400';
                                ?>

                                <tr class="hover:bg-neutral-700/30 transition-colors duration-200 group">
                                    <td class="px-6 py-4 text-sm font-mono text-neutral-300">#<?php echo $row['id']; ?></td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-white">
                                            <?php echo htmlspecialchars(html_entity_decode($row['title'], ENT_QUOTES, 'UTF-8')); ?>
                                        </div>
                                        <div class="text-xs text-neutral-400 mt-0.5">By <span
                                                class="text-neutral-400"><?php echo htmlspecialchars($row['username'] ?? 'Unknown'); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-neutral-200">
                                        <?php echo htmlspecialchars(html_entity_decode($row['category'], ENT_QUOTES, 'UTF-8')); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 whitespace-nowrap text-xs font-medium rounded-full border <?php echo $statusBadgeClass; ?>">
                                            <span class="w-1.5 h-1.5 rounded-full <?php echo $statusDotClass; ?>"></span>
                                            <?php echo htmlspecialchars($row['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium <?php echo $priorityClass; ?>">
                                        <?php echo htmlspecialchars($row['priority']); ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <?php if (!empty($row['image_path'])): ?>
                                            <a href="./core/actions/submit_report.php?view_id=<?php echo htmlspecialchars($row['image_path']); ?>"
                                                target="_blank"
                                                class="inline-block p-2 hover:bg-neutral-700 rounded-lg text-neutral-400 transition-colors">
                                                <svg class="h-5 w-5 mx-auto text-violet-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-neutral-600">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <?php if (!empty($row['map_link'])): ?>
                                            <a href="<?php echo htmlspecialchars($row['map_link']); ?>" target="_blank"
                                                class="inline-block p-2 hover:bg-neutral-700 rounded-lg text-blue-400 transition-colors">
                                                <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-neutral-600">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-neutral-200">
                                        <?php echo date("M d, Y", strtotime($row['created_at'])); ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button
                                            onclick='askAboutReport(<?= (int) $row["id"] ?>, <?= json_encode($row["title"]) ?>, <?= json_encode($row["category"]) ?>)'
                                            class="text-blue-400 hover:text-blue-300 text-xs font-medium flex items-center justify-center gap-1 transition-colors">
                                            Ask Gemini
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="px-6 py-10 text-center text-neutral-500">
                                    <p class="text-lg font-medium text-neutral-400">No reports found</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-neutral-900 border-t border-neutral-700 px-6 py-4 flex items-center justify-between">
                <span class="text-sm text-neutral-400">Showing page <span
                        class="text-white font-medium"><?php echo $page; ?></span> of
                    <?php echo max(1, $total_pages); ?></span>
                <div class="flex gap-2">
                    <?php
                    $prevParams = array_merge($_GET, ['p' => $page - 1]);
                    $nextParams = array_merge($_GET, ['p' => $page + 1]);
                    ?>
                    <a href="?<?php echo http_build_query($prevParams); ?>"
                        class="px-3 py-1 bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 rounded-lg text-sm text-white transition-colors <?php echo ($page <= 1 ? 'opacity-50 pointer-events-none' : ''); ?>">Previous</a>
                    <a href="?<?php echo http_build_query($nextParams); ?>"
                        class="px-3 py-1 bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 rounded-lg text-sm text-white transition-colors <?php echo ($page >= $total_pages ? 'opacity-50 pointer-events-none' : ''); ?>">Next</a>
                </div>
            </div>
        </div>
    </div>

    <div id="view-gemini"
        class="hidden h-[75vh] flex flex-col bg-neutral-800 rounded-xl border border-neutral-700 overflow-hidden relative shadow-2xl">

        <div
            class="flex-none px-6 py-4 border-b border-neutral-700 bg-neutral-900/50 backdrop-blur flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-900/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-white tracking-tight">Gemini Assistant</h2>
                <p class="text-xs text-neutral-400">Facility Analysis & Support</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar bg-neutral-800" id="chat-container">
            <div class="flex gap-4">
                <div
                    class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 flex-shrink-0 flex items-center justify-center mt-1">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="space-y-1 max-w-[80%]">
                    <span class="text-xs font-bold text-purple-400 ml-1">Gemini</span>
                    <div
                        class="bg-neutral-700/50 border border-neutral-600 rounded-2xl rounded-tl-none px-5 py-3 text-neutral-200 text-sm leading-relaxed shadow-sm">

                        Hi! I can help you understand reported issues and what you can do in the meantime.

                        <ul class="list-disc list-inside mt-2 text-neutral-400 space-y-1">
                            <li>Click <b>"Ask Gemini"</b> on a report to get tips you can follow right now.</li>
                            <li>Ask how to stay safe or avoid inconvenience until it gets fixed.</li>
                            <li>Get simple do’s and don’ts related to campus issues.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-none p-4 bg-neutral-900 border-t border-neutral-700">
            <div class="relative flex items-end gap-2 max-w-4xl mx-auto">

                <textarea id="gemini-prompt" rows="1" placeholder="Message Gemini..."
                    oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                    onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); handleChatSubmit(); }"
                    class="w-full pl-5 pr-14 py-3.5 bg-neutral-800 border border-neutral-700 rounded-2xl text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all resize-none custom-scrollbar text-sm leading-relaxed"
                    style="min-height: 52px; max-height: 150px;"></textarea>

                <button id="send-btn" onclick="handleChatSubmit()" type="button"
                    class="absolute right-2 bottom-2.5 p-2 bg-purple-600 hover:bg-purple-500 text-white rounded-xl transition-all shadow-lg shadow-purple-900/20 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5 transform -rotate-90" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                    </svg>
                </button>
            </div>
            <p class="text-center text-[11px] text-neutral-500 mt-3">Gemini may display inaccurate info, so double-check
                its responses.</p>
        </div>
    </div>
</div>

<div id="createModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
        <div class="fixed inset-0 bg-neutral-900/80 backdrop-blur-sm transition-opacity" aria-hidden="true"
            onclick="document.getElementById('createModal').classList.add('hidden')"></div>

        <div
            class="relative bg-neutral-800 rounded-2xl border border-neutral-700 text-left shadow-2xl transform transition-all sm:my-8 sm:w-full sm:max-w-2xl">
            <div class="px-6 py-4 border-b border-neutral-700 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-white">Create Report</h2>
                <button onclick="document.getElementById('createModal').classList.add('hidden')"
                    class="text-neutral-400 hover:text-white transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6 space-y-6">
                <form action="./core/actions/submit_report.php" method="POST" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-neutral-300 mb-2">Report Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" required
                                class="w-full px-4 py-2.5 bg-neutral-900 border border-neutral-700 rounded-lg text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all"
                                placeholder="E.g., Large pothole near school">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-300 mb-2">Category <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="category" required
                                    class="w-full px-4 py-2.5 bg-neutral-900 border border-neutral-700 rounded-lg text-white appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all cursor-pointer">
                                    <option value="" disabled selected>Select a category...</option>
                                    <option value="Security & Safety Issue">Security & Safety Issue</option>
                                    <option value="Electrical Issue">Electrical Issue</option>
                                    <option value="Water & Plumbing Issue">Water & Plumbing Issue</option>
                                    <option value="Road & Pathway Damage Issue">Road & Pathway Damage Issue</option>
                                    <option value="HVAC (AC/Heating) Issue">HVAC (AC/Heating) Issue</option>
                                    <option value="WiFi & Network Issue">WiFi & Network Issue</option>
                                    <option value="Cleaning & Janitorial Issue">Cleaning & Janitorial Issue</option>
                                    <option value="Furniture & Fixtures Issue">Furniture & Fixtures Issue</option>
                                    <option value="Library & Study Issue">Library & Study Issue</option>
                                    <option value="Lost & Stolen Issue">Lost & Stolen Issue</option>
                                    <option value="Medical/Health Issue">Medical & Health Issue</option>
                                    <option value="Other Issue">Other Issue</option>
                                </select>
                                <svg class="absolute right-3 top-3 h-4 w-4 text-neutral-500 pointer-events-none"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-300 mb-2">Priority <span
                                    class="text-red-500">*</span></label>
                            <div class="flex bg-neutral-900 rounded-lg p-1 border border-neutral-700">
                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="priority" value="Low" class="sr-only peer" checked>
                                    <span
                                        class="block px-2 py-1.5 rounded-md text-sm text-neutral-200 peer-checked:bg-neutral-800 peer-checked:text-green-400 peer-checked:shadow-sm transition-all">Low</span>
                                </label>

                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="priority" value="Medium" class="sr-only peer">
                                    <span
                                        class="block px-2 py-1.5 rounded-md text-sm text-neutral-200 peer-checked:bg-neutral-800 peer-checked:text-orange-400 peer-checked:shadow-sm transition-all">Med</span>
                                </label>

                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="priority" value="High" class="sr-only peer">
                                    <span
                                        class="block px-2 py-1.5 rounded-md text-sm text-neutral-200 peer-checked:bg-neutral-800 peer-checked:text-red-400 peer-checked:shadow-sm transition-all">High</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-neutral-300">Location <span
                                    class="text-red-500">*</span></label>
                            <button type="button" onclick="useCurrentLocation()"
                                class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Use Current Location
                            </button>
                        </div>
                        <div class="relative mb-3">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <input type="text" name="location" id="locationInput" required
                                class="w-full pl-10 pr-4 py-2.5 bg-neutral-900 border border-neutral-700 rounded-lg text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all text-sm"
                                placeholder="Paste Google Maps link or enter address...">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-neutral-300 mb-2">Evidence <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="file" name="evidence" required id="file-upload" class="hidden"
                                accept=".png, .jpg, .jpeg, image/png, image/jpeg" onchange="validateFile(this)">
                            <label for="file-upload"
                                class="block border-2 border-dashed border-neutral-700 rounded-xl p-8 text-center hover:border-blue-500/50 hover:bg-neutral-900/50 transition-all cursor-pointer group">
                                <div
                                    class="w-12 h-12 bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                    <svg id="file-icon"
                                        class="h-6 w-6 text-neutral-400 group-hover:text-blue-400 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p id="file-label-main" class="text-sm text-neutral-300 font-medium">Click to upload or
                                    drag and drop</p>
                                <p id="file-label-sub" class="text-xs text-neutral-500 mt-1"> PNG, JPG, JPEG (max. 2MB)
                                </p>
                            </label>
                        </div>
                    </div>

                    <div
                        class="px-6 py-4 border-t border-neutral-700 bg-neutral-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-b-2xl -mx-6 -mb-6 mt-6">
                        <span class="text-xs text-neutral-500 order-2 sm:order-1 text-center sm:text-left"><span
                                class="text-red-500">*</span> All fields marked above are required</span>
                        <div class="flex gap-3 order-1 sm:order-2 w-full sm:w-auto justify-end">
                            <button type="button"
                                onclick="document.getElementById('createModal').classList.add('hidden')"
                                class="px-5 py-2 text-neutral-300 hover:text-white text-sm font-medium transition-colors">Cancel</button>
                            <button type="submit"
                                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-lg shadow-blue-900/20 transition-all">Submit
                                Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>