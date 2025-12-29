<section class="space-y-6">
    <header>
        <h1 class="text-2xl font-semibold text-white">Admin Panel</h1>
        <p class="mt-1 text-sm text-neutral-400">System management and administrative controls</p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-400">Total Users</p>
                    <p class="mt-2 text-3xl font-semibold text-white">1,247</p>
                </div>
                <div class="w-12 h-12 bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-neutral-500">Active: 1,189 | Suspended: 58</p>
        </div>

        <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-400">Pending Reports</p>
                    <p class="mt-2 text-3xl font-semibold text-white">34</p>
                </div>
                <div class="w-12 h-12 bg-yellow-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-neutral-500">High: 8 | Medium: 15 | Low: 11</p>
        </div>

        <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-400">Active Incidents</p>
                    <p class="mt-2 text-3xl font-semibold text-white">7</p>
                </div>
                <div class="w-12 h-12 bg-red-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-neutral-500">Critical: 2 | Warning: 5</p>
        </div>

        <div class="bg-neutral-800 rounded-lg border border-neutral-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-400">System Health</p>
                    <p class="mt-2 text-3xl font-semibold text-green-400">98.5%</p>
                </div>
                <div class="w-12 h-12 bg-green-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-neutral-500">All services operational</p>
        </div>
    </div>

    <div class="bg-neutral-800 rounded-lg border border-neutral-700">
        <div class="px-6 py-4 border-b border-neutral-700">
            <h2 class="text-lg font-semibold text-white">User Management</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-900 border-b border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            User ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700">
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#1001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">John Anderson</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">john.anderson@company.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-900 text-purple-200">Admin</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-200">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-400 hover:text-blue-300 mr-3">View</button>
                            <button class="text-red-400 hover:text-red-300">Disable</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#1002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Sarah Mitchell</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">sarah.mitchell@company.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">Moderator</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-200">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-400 hover:text-blue-300 mr-3">View</button>
                            <button class="text-red-400 hover:text-red-300">Disable</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#1003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Michael Chen</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">michael.chen@company.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-700 text-neutral-300">User</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-200">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-400 hover:text-blue-300 mr-3">View</button>
                            <button class="text-red-400 hover:text-red-300">Disable</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#1004</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Emily Rodriguez</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">emily.rodriguez@company.com
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-700 text-neutral-300">User</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-200">Suspended</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-400 hover:text-blue-300 mr-3">View</button>
                            <button class="text-green-400 hover:text-green-300">Enable</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#1005</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">David Thompson</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">david.thompson@company.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">Moderator</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-200">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-400 hover:text-blue-300 mr-3">View</button>
                            <button class="text-red-400 hover:text-red-300">Disable</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-neutral-800 rounded-lg border border-neutral-700">
        <div class="px-6 py-4 border-b border-neutral-700">
            <h2 class="text-lg font-semibold text-white">Report Moderation</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-900 border-b border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Report ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Submitted By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700">
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#2045</td>
                        <td class="px-6 py-4 text-sm text-white">Database Connection Issues</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">alex.kim@company.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-200">High</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-200">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-green-400 hover:text-green-300 mr-2">Approve</button>
                            <button class="text-orange-400 hover:text-orange-300 mr-2">Escalate</button>
                            <button class="text-red-400 hover:text-red-300">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#2044</td>
                        <td class="px-6 py-4 text-sm text-white">API Response Time Degradation</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">maria.santos@company.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-200">Medium</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-200">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-green-400 hover:text-green-300 mr-2">Approve</button>
                            <button class="text-orange-400 hover:text-orange-300 mr-2">Escalate</button>
                            <button class="text-red-400 hover:text-red-300">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#2043</td>
                        <td class="px-6 py-4 text-sm text-white">UI Rendering Bug</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">james.wilson@company.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900 text-blue-200">Low</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-200">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-green-400 hover:text-green-300 mr-2">Approve</button>
                            <button class="text-orange-400 hover:text-orange-300 mr-2">Escalate</button>
                            <button class="text-red-400 hover:text-red-300">Delete</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-neutral-750">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-300">#2042</td>
                        <td class="px-6 py-4 text-sm text-white">Memory Leak in Production</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-400">lisa.park@company.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-200">High</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-900 text-yellow-200">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-green-400 hover:text-green-300 mr-2">Approve</button>
                            <button class="text-orange-400 hover:text-orange-300 mr-2">Escalate</button>
                            <button class="text-red-400 hover:text-red-300">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-neutral-800 rounded-lg border border-neutral-700">
        <div class="px-6 py-4 border-b border-neutral-700">
            <h2 class="text-lg font-semibold text-white">System Controls</h2>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between p-4 bg-neutral-900 rounded-lg border border-neutral-700">
                <div>
                    <h3 class="text-sm font-medium text-white">Maintenance Mode</h3>
                    <p class="mt-1 text-xs text-neutral-400">Enable maintenance mode to perform system updates</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-neutral-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button
                    class="flex items-center justify-center px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-lg text-sm font-medium text-white hover:bg-neutral-750 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Clear Cache
                </button>

                <button
                    class="flex items-center justify-center px-4 py-3 bg-neutral-900 border border-neutral-700 rounded-lg text-sm font-medium text-white hover:bg-neutral-750 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Force Status Refresh
                </button>

                <button
                    class="flex items-center justify-center px-4 py-3 bg-yellow-900 border border-yellow-700 rounded-lg text-sm font-medium text-yellow-200 hover:bg-yellow-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Restart Services
                </button>
            </div>
        </div>
    </div>

    <div class="hidden bg-neutral-800 rounded-lg border border-neutral-700 p-12">
        <div class="flex flex-col items-center justify-center text-center">
            <svg class="w-16 h-16 text-neutral-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                </path>
            </svg>
            <h3 class="text-lg font-medium text-white mb-1">No data available</h3>
            <p class="text-sm text-neutral-400">Administrative data will appear here when available</p>
        </div>
    </div>

    <div class="hidden bg-neutral-800 rounded-lg border border-neutral-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-900 border-b border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            User ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700">
                    <tr class="animate-pulse">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-32"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-48"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-24"></div>
                        </td>
                    </tr>
                    <tr class="animate-pulse">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-28"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-44"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-24"></div>
                        </td>
                    </tr>
                    <tr class="animate-pulse">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-36"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-52"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-5 bg-neutral-700 rounded-full w-16"></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-4 bg-neutral-700 rounded w-24"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
