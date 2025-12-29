<div class="space-y-6">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-neutral-800">
    <div>
      <h1 class="text-2xl font-bold text-white">Status Board</h1>
      <p class="text-sm text-neutral-400 mt-1">Live infrastructure and service health</p>
    </div>
    <div class="flex items-center gap-4 text-xs">
      <div class="flex items-center gap-2">
        <div class="w-2 h-2 rounded-full bg-green-500"></div>
        <span class="text-neutral-300">Operational</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
        <span class="text-neutral-300">Degraded</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="w-2 h-2 rounded-full bg-red-500"></div>
        <span class="text-neutral-300">Outage</span>
      </div>
    </div>
  </div>

  <!-- Global Status Summary -->
  <section>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm text-neutral-400">Overall System</span>
          <div class="w-2 h-2 rounded-full bg-green-500"></div>
        </div>
        <div class="text-2xl font-bold text-white">Operational</div>
      </div>
      
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm text-neutral-400">Services Operational</span>
          <div class="w-2 h-2 rounded-full bg-green-500"></div>
        </div>
        <div class="text-2xl font-bold text-white">12/14</div>
      </div>
      
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm text-neutral-400">Active Incidents</span>
          <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
        </div>
        <div class="text-2xl font-bold text-white">2</div>
      </div>
      
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm text-neutral-400">Regions Affected</span>
          <div class="w-2 h-2 rounded-full bg-green-500"></div>
        </div>
        <div class="text-2xl font-bold text-white">0/8</div>
      </div>
    </div>
  </section>

  <!-- Services Status Grid -->
  <section>
    <h2 class="text-lg font-semibold text-white mb-4">Services Status</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-start justify-between mb-2">
          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <h3 class="font-semibold text-white">Power Grid</h3>
          </div>
          <span class="px-2 py-1 text-xs font-medium rounded bg-green-500/10 text-green-400 border border-green-500/20">Operational</span>
        </div>
        <p class="text-sm text-neutral-400 mb-2">Running normally</p>
        <p class="text-xs text-neutral-500">Last updated: 2 minutes ago</p>
      </div>

      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-start justify-between mb-2">
          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <h3 class="font-semibold text-white">Water Supply</h3>
          </div>
          <span class="px-2 py-1 text-xs font-medium rounded bg-green-500/10 text-green-400 border border-green-500/20">Operational</span>
        </div>
        <p class="text-sm text-neutral-400 mb-2">Running normally</p>
        <p class="text-xs text-neutral-500">Last updated: 5 minutes ago</p>
      </div>

      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-start justify-between mb-2">
          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
            <h3 class="font-semibold text-white">Network Infrastructure</h3>
          </div>
          <span class="px-2 py-1 text-xs font-medium rounded bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Degraded</span>
        </div>
        <p class="text-sm text-neutral-400 mb-2">Partial outage in Zone C</p>
        <p class="text-xs text-neutral-500">Last updated: 1 minute ago</p>
      </div>

      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-start justify-between mb-2">
          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <h3 class="font-semibold text-white">Road Network</h3>
          </div>
          <span class="px-2 py-1 text-xs font-medium rounded bg-green-500/10 text-green-400 border border-green-500/20">Operational</span>
        </div>
        <p class="text-sm text-neutral-400 mb-2">All routes clear</p>
        <p class="text-xs text-neutral-500">Last updated: 3 minutes ago</p>
      </div>

      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-start justify-between mb-2">
          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-red-500"></div>
            <h3 class="font-semibold text-white">Public Transit</h3>
          </div>
          <span class="px-2 py-1 text-xs font-medium rounded bg-red-500/10 text-red-400 border border-red-500/20">Outage</span>
        </div>
        <p class="text-sm text-neutral-400 mb-2">Service suspended on Line 5</p>
        <p class="text-xs text-neutral-500">Last updated: 8 minutes ago</p>
      </div>

      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
        <div class="flex items-start justify-between mb-2">
          <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <h3 class="font-semibold text-white">Emergency Services</h3>
          </div>
          <span class="px-2 py-1 text-xs font-medium rounded bg-green-500/10 text-green-400 border border-green-500/20">Operational</span>
        </div>
        <p class="text-sm text-neutral-400 mb-2">All systems nominal</p>
        <p class="text-xs text-neutral-500">Last updated: 1 minute ago</p>
      </div>
    </div>
  </section>

  <!-- Location / Region Status -->
  <section>
    <h2 class="text-lg font-semibold text-white mb-4">Regional Status</h2>
    <div class="bg-neutral-800 rounded-lg border border-neutral-700 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-neutral-900 border-b border-neutral-700">
            <tr>
              <th class="text-left px-4 py-3 text-xs font-semibold text-neutral-300 uppercase tracking-wider">Region / Area</th>
              <th class="text-left px-4 py-3 text-xs font-semibold text-neutral-300 uppercase tracking-wider">Affected Services</th>
              <th class="text-left px-4 py-3 text-xs font-semibold text-neutral-300 uppercase tracking-wider">Status</th>
              <th class="text-left px-4 py-3 text-xs font-semibold text-neutral-300 uppercase tracking-wider">Last Update</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-neutral-700">
            <tr>
              <td class="px-4 py-3 text-sm text-white whitespace-nowrap">North District</td>
              <td class="px-4 py-3 text-sm text-neutral-400">None</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center gap-2 px-2 py-1 text-xs font-medium rounded bg-green-500/10 text-green-400 border border-green-500/20">
                  <div class="w-2 h-2 rounded-full bg-green-500"></div>
                  Operational
                </span>
              </td>
              <td class="px-4 py-3 text-sm text-neutral-500 whitespace-nowrap">2 minutes ago</td>
            </tr>
            <tr>
              <td class="px-4 py-3 text-sm text-white whitespace-nowrap">South District</td>
              <td class="px-4 py-3 text-sm text-neutral-400">None</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center gap-2 px-2 py-1 text-xs font-medium rounded bg-green-500/10 text-green-400 border border-green-500/20">
                  <div class="w-2 h-2 rounded-full bg-green-500"></div>
                  Operational
                </span>
              </td>
              <td class="px-4 py-3 text-sm text-neutral-500 whitespace-nowrap">4 minutes ago</td>
            </tr>
            <tr>
              <td class="px-4 py-3 text-sm text-white whitespace-nowrap">East District</td>
              <td class="px-4 py-3 text-sm text-neutral-400">Network, Transit</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center gap-2 px-2 py-1 text-xs font-medium rounded bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                  <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                  Degraded
                </span>
              </td>
              <td class="px-4 py-3 text-sm text-neutral-500 whitespace-nowrap">1 minute ago</td>
            </tr>
            <tr>
              <td class="px-4 py-3 text-sm text-white whitespace-nowrap">West District</td>
              <td class="px-4 py-3 text-sm text-neutral-400">None</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center gap-2 px-2 py-1 text-xs font-medium rounded bg-green-500/10 text-green-400 border border-green-500/20">
                  <div class="w-2 h-2 rounded-full bg-green-500"></div>
                  Operational
                </span>
              </td>
              <td class="px-4 py-3 text-sm text-neutral-500 whitespace-nowrap">3 minutes ago</td>
            </tr>
            <tr>
              <td class="px-4 py-3 text-sm text-white whitespace-nowrap">Central District</td>
              <td class="px-4 py-3 text-sm text-neutral-400">None</td>
              <td class="px-4 py-3">
                <span class="inline-flex items-center gap-2 px-2 py-1 text-xs font-medium rounded bg-green-500/10 text-green-400 border border-green-500/20">
                  <div class="w-2 h-2 rounded-full bg-green-500"></div>
                  Operational
                </span>
              </td>
              <td class="px-4 py-3 text-sm text-neutral-500 whitespace-nowrap">5 minutes ago</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Incident Snapshot -->
  <section>
    <h2 class="text-lg font-semibold text-white mb-4">Active Incidents</h2>
    <div class="bg-neutral-800 rounded-lg border border-neutral-700 divide-y divide-neutral-700">
      <div class="p-4">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-2">
          <h3 class="font-semibold text-white">Network connectivity issues in Zone C</h3>
          <span class="px-2 py-1 text-xs font-medium rounded bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 self-start">High</span>
        </div>
        <div class="flex items-center gap-3 text-sm">
          <span class="px-2 py-1 text-xs font-medium rounded bg-blue-500/10 text-blue-400 border border-blue-500/20">Investigating</span>
          <span class="text-neutral-500">15 minutes ago</span>
        </div>
      </div>

      <div class="p-4">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-2">
          <h3 class="font-semibold text-white">Transit Line 5 service disruption</h3>
          <span class="px-2 py-1 text-xs font-medium rounded bg-red-500/10 text-red-400 border border-red-500/20 self-start">Critical</span>
        </div>
        <div class="flex items-center gap-3 text-sm">
          <span class="px-2 py-1 text-xs font-medium rounded bg-orange-500/10 text-orange-400 border border-orange-500/20">Identified</span>
          <span class="text-neutral-500">32 minutes ago</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Loading State (Hidden by default) -->
  <div class="space-y-6 hidden" data-loading-state>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4 animate-pulse">
        <div class="h-4 bg-neutral-700 rounded w-1/2 mb-3"></div>
        <div class="h-8 bg-neutral-700 rounded w-3/4"></div>
      </div>
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4 animate-pulse">
        <div class="h-4 bg-neutral-700 rounded w-1/2 mb-3"></div>
        <div class="h-8 bg-neutral-700 rounded w-3/4"></div>
      </div>
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4 animate-pulse">
        <div class="h-4 bg-neutral-700 rounded w-1/2 mb-3"></div>
        <div class="h-8 bg-neutral-700 rounded w-3/4"></div>
      </div>
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4 animate-pulse">
        <div class="h-4 bg-neutral-700 rounded w-1/2 mb-3"></div>
        <div class="h-8 bg-neutral-700 rounded w-3/4"></div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4 animate-pulse">
        <div class="h-5 bg-neutral-700 rounded w-1/3 mb-3"></div>
        <div class="h-4 bg-neutral-700 rounded w-full mb-2"></div>
        <div class="h-3 bg-neutral-700 rounded w-1/4"></div>
      </div>
      <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4 animate-pulse">
        <div class="h-5 bg-neutral-700 rounded w-1/3 mb-3"></div>
        <div class="h-4 bg-neutral-700 rounded w-full mb-2"></div>
        <div class="h-3 bg-neutral-700 rounded w-1/4"></div>
      </div>
    </div>

    <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-4">
      <div class="space-y-3">
        <div class="h-10 bg-neutral-700 rounded animate-pulse"></div>
        <div class="h-10 bg-neutral-700 rounded animate-pulse"></div>
        <div class="h-10 bg-neutral-700 rounded animate-pulse"></div>
      </div>
    </div>
  </div>

  <!-- Empty State for Incidents -->
  <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-12 text-center hidden" data-empty-incidents>
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-500/10 mb-4">
      <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <p class="text-lg font-semibold text-white mb-1">No active incidents</p>
    <p class="text-sm text-neutral-400">All systems are operating normally</p>
  </div>
</div>