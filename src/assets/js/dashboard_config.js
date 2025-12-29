async function loadDashboardMetrics() {
  // TODO: Replace with actual API call
  // const response = await fetch('/api/dashboard/metrics');
  // const data = await response.json();

  // Placeholder for future implementation
  const metricsData = {
    totalReports: null,
    activeIssues: null,
    resolvedIssues: null,
    criticalAlerts: null,
  };

  // Update DOM with API data
  document.querySelector('[data-value="total-reports"]').textContent =
    metricsData.totalReports !== null ? metricsData.totalReports : "—";
  document.querySelector('[data-value="active-issues"]').textContent =
    metricsData.activeIssues !== null ? metricsData.activeIssues : "—";
  document.querySelector('[data-value="resolved-issues"]').textContent =
    metricsData.resolvedIssues !== null ? metricsData.resolvedIssues : "—";
  document.querySelector('[data-value="critical-alerts"]').textContent =
    metricsData.criticalAlerts !== null ? metricsData.criticalAlerts : "—";
}

async function loadRecentActivity() {
  // TODO: Replace with actual API call
  // const response = await fetch('/api/activity/recent');
  // const activities = await response.json();

  const activities = [];

  const listContainer = document.getElementById("activity-list");
  const skeleton = document.getElementById("activity-skeleton");
  const empty = document.getElementById("activity-empty");
  const items = document.getElementById("activity-items");

  skeleton.classList.add("hidden");

  if (activities.length === 0) {
    listContainer.setAttribute("data-status", "empty");
    empty.classList.remove("hidden");
  } else {
    listContainer.setAttribute("data-status", "loaded");
    items.classList.remove("hidden");

    // Render activity items
    activities.forEach((activity) => {
      const item = createActivityItem(activity);
      items.appendChild(item);
    });
  }
}

function createActivityItem(activity) {
  const div = document.createElement("div");
  div.className = "px-6 py-4 flex items-start space-x-4";
  div.setAttribute("data-activity-id", activity.id);

  const statusColors = {
    critical: "bg-red-400",
    warning: "bg-yellow-400",
    info: "bg-blue-400",
    success: "bg-green-400",
  };

  div.innerHTML = `
                <div class="w-2 h-2 mt-2 rounded-full ${
                  statusColors[activity.severity] || "bg-gray-600"
                }"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-200">${activity.message}</p>
                    <div class="mt-1 flex items-center space-x-3">
                        <span class="text-xs text-gray-500">${
                          activity.timestamp
                        }</span>
                        <span class="px-2 py-0.5 text-xs font-medium rounded ${getBadgeClass(
                          activity.status
                        )}">${activity.status}</span>
                    </div>
                </div>
            `;

  return div;
}

function getBadgeClass(status) {
  const classes = {
    new: "bg-blue-900/40 text-blue-400",
    "in-progress": "bg-yellow-900/40 text-yellow-400",
    resolved: "bg-green-900/40 text-green-400",
    closed: "bg-gray-800 text-gray-400",
  };
  return classes[status] || "bg-gray-800 text-gray-400";
}

// Initialize dashboard on page load
document.addEventListener("DOMContentLoaded", () => {
  loadDashboardMetrics();
  setTimeout(() => loadRecentActivity(), 500);
});
