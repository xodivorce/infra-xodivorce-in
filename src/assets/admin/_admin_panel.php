<?php
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "<div class='text-red-500 p-6'>Access Denied</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $report_id = intval($_POST['report_id']);
    $new_status = $_POST['new_status'];
    $allowed_statuses = ['Opened', 'In Progress', 'Resolved'];

    if (in_array($new_status, $allowed_statuses)) {
        $stmt = $conn->prepare("UPDATE reports SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $report_id);
        if ($stmt->execute()) {
            echo "<script>window.location.href = window.location.href;</script>";
            exit;
        }
        $stmt->close();
    }
}

$sql_users = "SELECT COUNT(*) as total FROM users";
$total_users = $conn->query($sql_users)->fetch_assoc()['total'] ?? 0;

$sql_active = "SELECT COUNT(DISTINCT user_id) as active FROM reports";
$active_users = $conn->query($sql_active)->fetch_assoc()['active'] ?? 0;

$sql_pending = "SELECT COUNT(*) as pending FROM reports WHERE status = 'Opened'";
$pending_reports = $conn->query($sql_pending)->fetch_assoc()['pending'] ?? 0;

$sql_resolved = "SELECT COUNT(*) as resolved FROM reports WHERE status = 'Resolved'";
$resolved_reports = $conn->query($sql_resolved)->fetch_assoc()['resolved'] ?? 0;

$sql_reports = "SELECT r.id, r.title, r.category, r.priority, r.status, r.created_at, r.location, r.image_path, u.username as user 
                FROM reports r 
                JOIN users u ON r.user_id = u.id 
                ORDER BY r.created_at DESC";
$result = $conn->query($sql_reports);

$reports = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reports[] = [
            'id' => $row['id'],
            'title' => htmlspecialchars($row['title']),
            'user' => htmlspecialchars($row['user']),
            'category' => htmlspecialchars($row['category']),
            'priority' => htmlspecialchars($row['priority']),
            'status' => htmlspecialchars($row['status']),
            'date' => $row['created_at'],
            'image' => htmlspecialchars($row['image_path']),
            'location' => htmlspecialchars($row['location'])
        ];
    }
}
?>

<section class="space-y-6" x-data="{ currentTab: 'reports' }">
    <header>
        <h1 class="text-2xl font-semibold text-white">Admin Panel</h1>
        <p class="mt-1 text-sm text-neutral-400">System management and administrative controls</p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-400">Total Users</p>
                    <p class="mt-2 text-3xl font-semibold text-white"><?php echo number_format($total_users); ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-neutral-500">Registered accounts</p>
        </div>

        <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-400">Active Reporters</p>
                    <p class="mt-2 text-3xl font-semibold text-white"><?php echo number_format($active_users); ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-neutral-500">Users who submitted reports</p>
        </div>

        <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-400">Pending Issues</p>
                    <p class="mt-2 text-3xl font-semibold text-white"><?php echo number_format($pending_reports); ?></p>
                </div>
                <div class="w-12 h-12 bg-red-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-neutral-500">Requires attention</p>
        </div>

        <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-400">Issues Resolved</p>
                    <p class="mt-2 text-3xl font-semibold text-green-400">
                        <?php echo number_format($resolved_reports); ?></p>
                </div>
                <div class="w-12 h-12 bg-green-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-neutral-500">Successfully closed reports</p>
        </div>
    </div>

    <div class="space-y-6 pb-10">

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
                    <h2 class="text-lg font-semibold text-white">Report Moderation</h2>
                    <p class="mt-1 text-sm text-neutral-400">Manage facility and infrastructure issues</p>
                </div>
            </div>

            <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-sm">
                <div class="flex flex-col lg:flex-row gap-4 justify-between">
                    <div class="flex overflow-x-auto pb-2 lg:pb-0 gap-2 no-scrollbar" id="status-filters">
                        <button onclick="setFilter('status', 'All')" id="filter-all"
                            class="px-4 py-2 bg-blue-600/10 text-blue-400 border border-blue-600/20 text-sm font-medium rounded-lg whitespace-nowrap transition-all">All
                            Reports</button>
                        <button onclick="setFilter('status', 'Opened')" id="filter-opened"
                            class="px-4 py-2 hover:bg-neutral-700 text-neutral-400 hover:text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap border border-transparent">Opened</button>
                        <button onclick="setFilter('status', 'In Progress')" id="filter-progress"
                            class="px-4 py-2 hover:bg-neutral-700 text-neutral-400 hover:text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap border border-transparent">In
                            Progress</button>
                        <button onclick="setFilter('status', 'Resolved')" id="filter-fixed"
                            class="px-4 py-2 hover:bg-neutral-700 text-neutral-400 hover:text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap border border-transparent">Resolved</button>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative min-w-[200px]">
                            <select onchange="setFilter('date', this.value)"
                                class="w-full appearance-none px-4 py-2 bg-neutral-900 border border-neutral-700 rounded-lg text-sm text-neutral-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all cursor-pointer">
                                <option value="all">All time</option>
                                <option value="7">Last 7 days</option>
                                <option value="30">Last 30 days</option>
                            </select>
                            <svg class="absolute right-3 top-2.5 h-4 w-4 text-neutral-500 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div class="relative w-full sm:w-64">
                            <input type="text" placeholder="Search..." onkeyup="setFilter('search', this.value)"
                                class="w-full pl-10 pr-4 py-2 bg-neutral-900 border border-neutral-700 rounded-lg text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                            <svg class="absolute left-3 top-2.5 h-4 w-4 text-neutral-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
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
                                    class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider w-1/4">
                                    Title</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                                    Priority</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                                    Image</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                                    Location</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider w-32">
                                    Date</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider w-48">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reports-table-body" class="divide-y divide-neutral-700/50">
                        </tbody>
                    </table>
                </div>

                <div class="bg-neutral-900 border-t border-neutral-700 px-6 py-4 flex items-center justify-between">
                    <span class="text-sm text-neutral-400" id="pagination-info">Showing page 1 of 1</span>
                    <div class="flex gap-2">
                        <button id="btn-prev" onclick="changePage(-1)"
                            class="px-3 py-1 bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 rounded-lg text-sm text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed">Previous</button>
                        <button id="btn-next" onclick="changePage(1)"
                            class="px-3 py-1 bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 rounded-lg text-sm text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed">Next</button>
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
                    <p class="text-xs text-neutral-400">Analysis & Response Generation</p>
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
                            Hello Admin. I can assist with prioritizing facility issues, drafting responses to students,
                            and analyzing infrastructure trends.
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-none p-4 bg-neutral-900 border-t border-neutral-700">
                <div class="relative flex items-end gap-2 max-w-4xl mx-auto">
                    <textarea id="gemini-prompt" rows="1" placeholder="Ask about specific reports..."
                        class="w-full pl-5 pr-14 py-3.5 bg-neutral-800 border border-neutral-700 rounded-2xl text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all resize-none custom-scrollbar text-sm leading-relaxed"
                        style="min-height: 52px; max-height: 150px;"></textarea>
                    <button type="button" onclick="sendGeminiRequest()" id="send-btn"
                        class="absolute right-2 bottom-2.5 p-2 bg-purple-600 hover:bg-purple-500 text-white rounded-xl transition-all shadow-lg shadow-purple-900/20">
                        <svg class="w-5 h-5 transform -rotate-90" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const reportsData = <?php echo json_encode($reports); ?>;

    let state = {
        filterStatus: 'All',
        filterDate: 'all',
        filterSearch: '',
        currentPage: 1,
        itemsPerPage: 5
    };

    function youtubeSearchLink(query) {
        return `https://www.youtube.com/results?search_query=${encodeURIComponent(query)}`;
    }

    function renderGeminiText(text) {
        if (!text) return '';

        text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');

        let safeText = text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");

        safeText = safeText.replace(/\*\*(.*?)\*\*/g, '<strong class="text-white font-semibold">$1</strong>');

        safeText = safeText.replace(
            /(https?:\/\/[^\s<]+)/g,
            '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 underline break-all">$1</a>'
        );

        const lines = safeText.split('\n');
        let html = '';

        lines.forEach(line => {
            const trimLine = line.trim();

            if (trimLine.startsWith('### ')) {
                html += `<div class="text-white font-semibold mt-3 mb-1 text-sm">${line.replace('### ', '')}</div>`;
            }

            else if (trimLine.startsWith('## ')) {
                html += `<div class="text-white font-bold mt-4 mb-2 text-base">${line.replace('## ', '')}</div>`;
            }

            else if (trimLine.match(/^(\*{3,}|-{3,})$/)) {
                html += `<hr class="my-3 border-neutral-600">`;
            }

            else if (trimLine.match(/^[\-\*]\s+/)) {
                const content = line.replace(/^\s*[\-\*]\s+/, '');
                html += `<div class="flex gap-2 ml-2 mt-1"><span class="text-blue-400 shrink-0 leading-relaxed">•</span><span class="text-neutral-200 leading-relaxed">${content}</span></div>`;
            }

            else if (trimLine.match(/^\d+\.\s+/)) {
                const match = line.match(/^(\s*\d+\.)\s+(.*)/);
                if (match) {
                    html += `<div class="flex gap-2 ml-2 mt-1"><span class="font-mono text-blue-400 shrink-0 leading-relaxed">${match[1]}</span><span class="text-neutral-200 leading-relaxed">${match[2]}</span></div>`;
                } else {
                    html += `<div class="mb-1 text-neutral-200">${line}</div>`;
                }
            }

            else if (trimLine.length > 0) {
                html += `<div class="mb-1 text-neutral-200 leading-relaxed">${line}</div>`;
            }

            else {
                html += `<div class="h-2"></div>`;
            }
        });

        return html;
    }

    function setFilter(type, value) {
        if (type === 'status') state.filterStatus = value;
        if (type === 'date') state.filterDate = value;
        if (type === 'search') state.filterSearch = value.toLowerCase();

        state.currentPage = 1;
        renderReports();
        updateFilterUI();
    }

    function changePage(direction) {
        state.currentPage += direction;
        renderReports();
    }

    function updateFilterUI() {
        const statuses = ['All', 'Opened', 'In Progress', 'Resolved'];
        const btnMap = { 'All': 'filter-all', 'Opened': 'filter-opened', 'In Progress': 'filter-progress', 'Resolved': 'filter-fixed' };
        const activeClass = "px-4 py-2 bg-blue-600/10 text-blue-400 border border-blue-600/20 text-sm font-medium rounded-lg whitespace-nowrap transition-all";
        const inactiveClass = "px-4 py-2 hover:bg-neutral-700 text-neutral-400 hover:text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap border border-transparent";

        statuses.forEach(s => {
            const btn = document.getElementById(btnMap[s]);
            if (btn) btn.className = (state.filterStatus === s) ? activeClass : inactiveClass;
        });
    }

    function advanceStatus(id, currentStatus) {
        let nextStatus = '';
        if (currentStatus === 'Opened') nextStatus = 'In Progress';
        else if (currentStatus === 'In Progress') nextStatus = 'Resolved';
        else return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';
        const inputAction = document.createElement('input'); inputAction.type = 'hidden'; inputAction.name = 'action'; inputAction.value = 'update_status'; form.appendChild(inputAction);
        const inputId = document.createElement('input'); inputId.type = 'hidden'; inputId.name = 'report_id'; inputId.value = id; form.appendChild(inputId);
        const inputStatus = document.createElement('input'); inputStatus.type = 'hidden'; inputStatus.name = 'new_status'; inputStatus.value = nextStatus; form.appendChild(inputStatus);
        document.body.appendChild(form);
        form.submit();
    }

    function askAboutReportAdmin(id, title, category, priority, status) {
        switchTab("gemini");
        const inputField = document.getElementById("gemini-prompt");

        if (inputField) {
            inputField.value = `Regarding Report #${id} ("${title}") in category "${category}":
  Provide a quick internal steps to resolve or debug this issue.  
  Structure your answer with these exact headers (keep bullet points short and technical):
    
  1. Immediate Actions to take on the issue
  2. Debug / Troubleshooting Steps`;

            inputField.style.height = "auto";
            inputField.style.height = inputField.scrollHeight + "px";
            inputField.focus();
        }
    }

    function renderReports() {
        const tbody = document.getElementById('reports-table-body');
        tbody.innerHTML = '';

        let filtered = reportsData.filter(item => {
            if (state.filterStatus !== 'All' && item.status !== state.filterStatus) return false;
            const searchStr = state.filterSearch;
            if (searchStr) {
                const matchesId = item.id.toString().includes(searchStr);
                const matchesTitle = item.title.toLowerCase().includes(searchStr);
                const matchesUser = item.user.toLowerCase().includes(searchStr);
                if (!matchesId && !matchesTitle && !matchesUser) return false;
            }
            if (state.filterDate !== 'all') {
                const itemDate = new Date(item.date);
                const limitDate = new Date();
                limitDate.setDate(limitDate.getDate() - parseInt(state.filterDate));
                if (itemDate < limitDate) return false;
            }
            return true;
        });

        const totalPages = Math.ceil(filtered.length / state.itemsPerPage) || 1;
        if (state.currentPage > totalPages) state.currentPage = totalPages;
        if (state.currentPage < 1) state.currentPage = 1;

        const start = (state.currentPage - 1) * state.itemsPerPage;
        const pageData = filtered.slice(start, start + state.itemsPerPage);

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="px-6 py-10 text-center text-neutral-500">No reports found matching criteria</td></tr>`;
        } else {
            pageData.forEach(row => {
                const dateObj = new Date(row.date);
                const dateStr = dateObj.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
                let priorityColor = row.priority === 'High' ? 'text-red-400' : (row.priority === 'Medium' ? 'text-orange-400' : 'text-blue-400');

                let actionBtn = '';
                if (row.status === 'Opened') {
                    actionBtn = `<button onclick="advanceStatus(${row.id}, '${row.status}')" class="group w-32 relative py-1.5 px-3 bg-yellow-600/10 hover:bg-yellow-600/20 text-yellow-500 border border-yellow-500/30 hover:border-yellow-500/50 rounded-lg text-xs font-semibold transition-all shadow-lg shadow-yellow-900/10 flex items-center justify-between mx-auto"><span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>In Progress</span><svg class="w-3 h-3 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg></button>`;
                } else if (row.status === 'In Progress') {
                    actionBtn = `<button onclick="advanceStatus(${row.id}, '${row.status}')" class="group w-32 relative py-1.5 px-3 bg-green-600/10 hover:bg-green-600/20 text-green-400 border border-green-500/30 hover:border-green-500/50 rounded-lg text-xs font-semibold transition-all shadow-lg shadow-green-900/10 flex items-center justify-between mx-auto"><span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>Resolved</span><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></button>`;
                } else {
                    actionBtn = `<div class="w-32 py-1.5 px-3 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-lg text-xs font-semibold text-center shadow-sm cursor-default flex items-center justify-center gap-2 mx-auto"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]"></span>Resolved</div>`;
                }

                let geminiBtn = '';
                if (row.status !== 'Resolved') {
                    geminiBtn = `<button onclick="askAboutReportAdmin(${row.id},'${row.title.replace(/'/g, "\\'")}','${row.category.replace(/'/g, "\\'")}','${row.priority}','${row.status}')" class="w-32 mt-2 py-1 px-3 text-purple-400 hover:text-purple-300 hover:bg-purple-500/10 rounded-md text-[10px] font-medium transition-colors flex items-center justify-center gap-1.5 border border-transparent hover:border-purple-500/20 mx-auto"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>Ask Gemini</button>`;
                }

                const viewImageLink = `./core/actions/submit_report.php?view_id=${row.image}`;
                const html = `<tr class="hover:bg-neutral-700/30 transition-colors duration-200"><td class="px-6 py-4 text-sm font-mono text-neutral-300">#${row.id}</td><td class="px-6 py-4"><div class="text-sm font-medium text-white">${row.title}</div><div class="text-xs text-neutral-400 mt-0.5">By ${row.user}</div></td><td class="px-6 py-4 text-sm text-neutral-200">${row.category}</td><td class="px-6 py-4 text-sm font-medium ${priorityColor}">${row.priority}</td><td class="px-6 py-4 text-center"><a href="${viewImageLink}" target="_blank" class="inline-block p-2 hover:bg-neutral-700 rounded-lg text-neutral-400 transition-colors"><svg class="h-5 w-5 mx-auto text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></a></td><td class="px-6 py-4 text-center"><a href="${row.location}" target="_blank" class="inline-block p-2 hover:bg-neutral-700 rounded-lg text-blue-400 transition-colors"><svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg></a></td><td class="px-6 py-4 text-center text-sm text-neutral-400">${dateStr}</td><td class="px-6 py-4 w-48 text-center"><div class="flex flex-col items-center">${actionBtn}${geminiBtn}</div></td></tr>`;
                tbody.innerHTML += html;
            });
        }
        document.getElementById('pagination-info').innerHTML = `Showing page <span class="text-white font-medium">${state.currentPage}</span> of ${totalPages}`;
        document.getElementById('btn-prev').disabled = state.currentPage === 1;
        document.getElementById('btn-next').disabled = state.currentPage === totalPages;
    }

    function switchTab(tabId) {
        const btnReports = document.getElementById('tab-btn-reports');
        const btnGemini = document.getElementById('tab-btn-gemini');
        const activeClass = "px-4 py-2 text-sm font-medium rounded-lg bg-neutral-800 text-white shadow-sm border border-neutral-700 cursor-default flex items-center gap-2 transition-all";
        const inactiveClass = "px-4 py-2 text-sm font-medium rounded-lg text-neutral-400 hover:text-white hover:bg-neutral-800 border-transparent cursor-pointer flex items-center gap-2 transition-all";

        if (tabId === 'reports') {
            btnReports.className = activeClass;
            btnGemini.className = inactiveClass;
            document.getElementById('view-reports').classList.remove('hidden');
            document.getElementById('view-gemini').classList.add('hidden');
        } else {
            btnGemini.className = activeClass;
            btnReports.className = inactiveClass;
            document.getElementById('view-reports').classList.add('hidden');
            document.getElementById('view-gemini').classList.remove('hidden');
        }
    }

    async function sendGeminiRequest() {
        const input = document.getElementById('gemini-prompt');
        const chatContainer = document.getElementById('chat-container');
        const prompt = input.value.trim();
        const sendBtn = document.getElementById('send-btn');

        if (!prompt) return;

        chatContainer.innerHTML += `
        <div class="flex gap-4 flex-row-reverse">
            <div class="w-8 h-8 rounded-full bg-neutral-700 flex-shrink-0 flex items-center justify-center mt-1">
                <svg class="w-4 h-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div class="space-y-1 max-w-[80%]">
                <div class="bg-blue-600 rounded-2xl rounded-tr-none px-5 py-3 text-white text-sm leading-relaxed shadow-md">${prompt.replace(/\n/g, '<br>')}</div>
            </div>
        </div>`;

        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;
        chatContainer.scrollTop = chatContainer.scrollHeight;

        try {
            const response = await fetch('./core/actions/admin_gemini.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ prompt: prompt })
            });
            const data = await response.json();

            let replyText = data.reply ? renderGeminiText(data.reply) : `<span class="text-red-400">Error: ${data.error || "Unknown error"}</span>`;

            chatContainer.innerHTML += `
            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 flex-shrink-0 flex items-center justify-center mt-1">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <div class="space-y-1 max-w-[80%]">
                    <span class="text-xs font-bold text-purple-400 ml-1">Gemini</span>
                    <div class="bg-neutral-700/50 border border-neutral-600 rounded-2xl rounded-tl-none px-5 py-3 text-neutral-200 text-sm leading-relaxed shadow-sm">
                        ${replyText}
                    </div>
                </div>
            </div>`;
        } catch (e) {
            console.error(e);
            chatContainer.innerHTML += `<div class="text-red-500 text-center text-xs mt-2">Connection Error: ${e.message}</div>`;
        }

        input.disabled = false;
        sendBtn.disabled = false;
        input.focus();
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    renderReports();
</script>