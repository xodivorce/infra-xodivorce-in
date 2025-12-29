<section class="space-y-6">
  <header>
    <h1 class="text-2xl font-semibold text-white">Activity Logs</h1>
    <p class="mt-1 text-sm text-neutral-400">Recent system and user activities</p>
  </header>

  <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-xs font-medium text-neutral-400 mb-1.5">Event Type</label>
        <select class="w-full bg-neutral-900 border border-neutral-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option>All</option>
          <option>Reports</option>
          <option>Status Changes</option>
          <option>Admin Actions</option>
        </select>
      </div>
      <div>
        <label class="block text-xs font-medium text-neutral-400 mb-1.5">Severity</label>
        <select class="w-full bg-neutral-900 border border-neutral-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option>All</option>
          <option>Info</option>
          <option>Warning</option>
          <option>Critical</option>
        </select>
      </div>
      <div>
        <label class="block text-xs font-medium text-neutral-400 mb-1.5">Date Range</label>
        <select class="w-full bg-neutral-900 border border-neutral-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option>Today</option>
          <option>Last 7 days</option>
          <option>Last 30 days</option>
        </select>
      </div>
      <div>
        <label class="block text-xs font-medium text-neutral-400 mb-1.5">Search</label>
        <input type="text" placeholder="Search activity…" class="w-full bg-neutral-900 border border-neutral-700 text-white placeholder-neutral-500 text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
    </div>
  </div>

  <div class="bg-neutral-800 rounded-lg border border-neutral-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-neutral-900 border-b border-neutral-700">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Timestamp</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Actor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Action</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Related Entity</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Severity</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-700">
          <tr class="hover:bg-neutral-750">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">2025-12-27 14:32:15</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">admin@system</td>
            <td class="px-6 py-4 text-sm text-neutral-300">Updated service configuration</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">API Gateway - US-East</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">Info</span>
            </td>
          </tr>
          <tr class="hover:bg-neutral-750">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">2025-12-27 14:28:43</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">System</td>
            <td class="px-6 py-4 text-sm text-neutral-300">Service health check failed</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">Database - EU-West</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-200">Warning</span>
            </td>
          </tr>
          <tr class="hover:bg-neutral-750">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">2025-12-27 14:15:22</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">john.doe@company.com</td>
            <td class="px-6 py-4 text-sm text-neutral-300">Generated monthly report</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">Report #1247</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">Info</span>
            </td>
          </tr>
          <tr class="hover:bg-neutral-750">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">2025-12-27 13:58:09</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">System</td>
            <td class="px-6 py-4 text-sm text-neutral-300">Critical alert triggered</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">Load Balancer - APAC</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-200">Critical</span>
            </td>
          </tr>
          <tr class="hover:bg-neutral-750">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">2025-12-27 13:45:31</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">admin@system</td>
            <td class="px-6 py-4 text-sm text-neutral-300">Modified user permissions</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">User: jane.smith@company.com</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">Info</span>
            </td>
          </tr>
          <tr class="hover:bg-neutral-750">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">2025-12-27 13:22:17</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">System</td>
            <td class="px-6 py-4 text-sm text-neutral-300">Backup completed successfully</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">All Services</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">Info</span>
            </td>
          </tr>
          <tr class="hover:bg-neutral-750">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">2025-12-27 12:58:44</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">mark.wilson@company.com</td>
            <td class="px-6 py-4 text-sm text-neutral-300">Updated service status</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">CDN - US-West</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">Info</span>
            </td>
          </tr>
          <tr class="hover:bg-neutral-750">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">2025-12-27 12:31:05</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">System</td>
            <td class="px-6 py-4 text-sm text-neutral-300">High memory usage detected</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">Cache Server - EU-Central</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-200">Warning</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="hidden bg-neutral-800 rounded-lg border border-neutral-700 p-12">
    <div class="flex flex-col items-center justify-center text-center">
      <svg class="w-16 h-16 text-neutral-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
      </svg>
      <h3 class="text-lg font-medium text-white mb-1">No activity logs available</h3>
      <p class="text-sm text-neutral-400">System and user actions will appear here</p>
    </div>
  </div>

  <div class="hidden bg-neutral-800 rounded-lg border border-neutral-700 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-neutral-900 border-b border-neutral-700">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Timestamp</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Actor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Action</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Related Entity</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">Severity</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-700">
          <tr class="animate-pulse">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-32"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-28"></div>
            </td>
            <td class="px-6 py-4">
              <div class="h-4 bg-neutral-700 rounded w-48"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-36"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
            </td>
          </tr>
          <tr class="animate-pulse">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-32"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-24"></div>
            </td>
            <td class="px-6 py-4">
              <div class="h-4 bg-neutral-700 rounded w-56"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-40"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
            </td>
          </tr>
          <tr class="animate-pulse">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-32"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-36"></div>
            </td>
            <td class="px-6 py-4">
              <div class="h-4 bg-neutral-700 rounded w-44"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-32"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
            </td>
          </tr>
          <tr class="animate-pulse">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-32"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-20"></div>
            </td>
            <td class="px-6 py-4">
              <div class="h-4 bg-neutral-700 rounded w-52"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-44"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
            </td>
          </tr>
          <tr class="animate-pulse">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-32"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-28"></div>
            </td>
            <td class="px-6 py-4">
              <div class="h-4 bg-neutral-700 rounded w-48"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-4 bg-neutral-700 rounded w-40"></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>