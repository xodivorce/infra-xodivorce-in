<?php
function words($text, $limit = 4) {
    $w = preg_split('/\s+/', trim($text));
    return count($w) > $limit
        ? implode(' ', array_slice($w, 0, $limit)) . '…'
        : $text;
}
?>

<div class="max-w-7xl mx-auto space-y-6">

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

    <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-sm">
        <div class="flex flex-col lg:flex-row gap-4 justify-between">
            <div class="flex overflow-x-auto pb-2 lg:pb-0 gap-2 no-scrollbar">
                <button
                    class="px-4 py-2 bg-blue-600/10 text-blue-400 border border-blue-600/20 text-sm font-medium rounded-lg whitespace-nowrap">All
                    Reports</button>
                <button
                    class="px-4 py-2 hover:bg-neutral-700 text-neutral-400 hover:text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">Open</button>
                <button
                    class="px-4 py-2 hover:bg-neutral-700 text-neutral-400 hover:text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">In
                    Progress</button>
                <button
                    class="px-4 py-2 hover:bg-neutral-700 text-neutral-400 hover:text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">Resolved</button>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative min-w-[200px]">
                    <select
                        class="w-full appearance-none px-4 py-2 bg-neutral-900 border border-neutral-700 rounded-lg text-sm text-neutral-300 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all cursor-pointer">
                        <option>Last 7 days</option>
                        <option>Last 30 days</option>
                        <option>Last 90 days</option>
                        <option>All time</option>
                    </select>
                    <svg class="absolute right-3 top-2.5 h-4 w-4 text-neutral-500 pointer-events-none" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <div class="relative w-full sm:w-64">
                    <input type="text" placeholder="Search reports..."
                        class="w-full pl-10 pr-4 py-2 bg-neutral-900 border border-neutral-700 rounded-lg text-sm text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                    <svg class="absolute left-3 top-2.5 h-4 w-4 text-neutral-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
        <div
            class="bg-neutral-800 hover:bg-neutral-750 transition-colors duration-200 rounded-xl border border-neutral-700 p-4 space-y-3 group cursor-default">
            <div class="flex justify-between items-start">
                <div>
                    <span
                        class="text-xs font-mono text-neutral-500 hover:text-blue-400 hover:underline cursor-pointer transition-colors">#1234</span>
                    <h3 class="font-semibold text-white mt-1">Pothole on Main Street</h3>
                </div>
                <span
                    class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-900/30 text-blue-400 border border-blue-700/50">Open</span>
            </div>

            <div class="flex items-center gap-2 text-sm text-neutral-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Main St. & 4th Ave
            </div>

            <div class="grid grid-cols-2 gap-2 py-2 border-t border-b border-neutral-700/50">
                <div>
                    <p class="text-xs text-neutral-500">Category</p>
                    <p class="text-sm text-neutral-300">Road Damage</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-500">Priority</p>
                    <p class="text-sm text-red-400 font-medium">High</p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center gap-2 text-xs text-neutral-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Dec 15, 2024
                </div>
                <button class="text-blue-400 text-sm font-medium hover:text-blue-300 transition-colors">View Details
                    &rarr;</button>
            </div>
        </div>

        <div
            class="bg-neutral-800 hover:bg-neutral-750 transition-colors duration-200 rounded-xl border border-neutral-700 p-4 space-y-3 group cursor-default">
            <div class="flex justify-between items-start">
                <div>
                    <span
                        class="text-xs font-mono text-neutral-500 hover:text-blue-400 hover:underline cursor-pointer transition-colors">#1233</span>
                    <h3 class="font-semibold text-white mt-1">Broken street light</h3>
                </div>
                <span
                    class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-900/30 text-yellow-500 border border-yellow-700/50">In
                    Progress</span>
            </div>

            <div class="flex items-center gap-2 text-sm text-neutral-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Sector 7 Park
            </div>

            <div class="grid grid-cols-2 gap-2 py-2 border-t border-b border-neutral-700/50">
                <div>
                    <p class="text-xs text-neutral-500">Category</p>
                    <p class="text-sm text-neutral-300">Street Lighting</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-500">Priority</p>
                    <p class="text-sm text-orange-400 font-medium">Medium</p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center gap-2 text-xs text-neutral-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Dec 14, 2024
                </div>
                <button class="text-blue-400 text-sm font-medium hover:text-blue-300 transition-colors">View Details
                    &rarr;</button>
            </div>
        </div>

        <div
            class="bg-neutral-800 hover:bg-neutral-750 transition-colors duration-200 rounded-xl border border-neutral-700 p-4 space-y-3 group cursor-default">
            <div class="flex justify-between items-start">
                <div>
                    <span
                        class="text-xs font-mono text-neutral-500 hover:text-blue-400 hover:underline cursor-pointer transition-colors">#1232</span>
                    <h3 class="font-semibold text-white mt-1">Water leakage in park</h3>
                </div>
                <span
                    class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-900/30 text-green-400 border border-green-700/50">Resolved</span>
            </div>

            <div class="flex items-center gap-2 text-sm text-neutral-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Central Park Zone B
            </div>

            <div class="grid grid-cols-2 gap-2 py-2 border-t border-b border-neutral-700/50">
                <div>
                    <p class="text-xs text-neutral-500">Category</p>
                    <p class="text-sm text-neutral-300">Water Supply</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-500">Priority</p>
                    <p class="text-sm text-green-400 font-medium">Low</p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-1">
                <div class="flex items-center gap-2 text-xs text-neutral-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Dec 12, 2024
                </div>
                <button class="text-blue-400 text-sm font-medium hover:text-blue-300 transition-colors">View Details
                    &rarr;</button>
            </div>
        </div>
    </div>

    <div class="hidden md:block bg-neutral-800 rounded-xl border border-neutral-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full">
                <thead class="bg-neutral-900/50 border-b border-neutral-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                            ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                            Title</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                            Category</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                            Priority</th>
                        <th
                            class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                            Image</th>
                        <th
                            class="px-6 py-4 text-center text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                            G-Map</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wider">
                            Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700/50">
                    <tr class="hover:bg-neutral-700/30 transition-colors duration-200 group">
                        <td
                            class="px-6 py-4 text-sm font-mono text-neutral-500 group-hover:text-neutral-300 hover:text-blue-400 hover:underline cursor-pointer transition-colors">
                            #1234</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-white ">Pothole on Main Street</div>
                            <div class="text-xs text-neutral-500 mt-0.5">Reported by <span>23/v/kpc-cst/36</span></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-300">Road Damage</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-blue-900/30 text-blue-400 border border-blue-700/50">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-blue-400 rounded-full"></span>
                                Open
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-red-400 font-medium">High</td>
                        <td class="px-6 py-4 text-center">
                            <button class="p-2 hover:bg-neutral-700 rounded-lg text-neutral-400 hover:text-white transition-colors"
                                title="View Image">
                                <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="p-2 hover:bg-neutral-700 rounded-lg text-blue-500 hover:text-blue-400 transition-colors"
                                title="View Map">
                                <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-400">Dec 15, 2024</td>
                    </tr>

                    <tr class="hover:bg-neutral-700/30 transition-colors duration-200 group">
                        <td
                            class="px-6 py-4 text-sm font-mono text-neutral-500 group-hover:text-neutral-300 hover:text-blue-400 hover:underline cursor-pointer transition-colors">
                            #1233</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-white">Broken street light</div>
                            <div class="text-xs text-neutral-500 mt-0.5">Reported by <span>23/v/kpc-cst/37</span></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-300">Street Lighting</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-yellow-900/30 text-yellow-500 border border-yellow-700/50">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
                                In Progress
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-orange-400 font-medium">Medium</td>
                        <td class="px-6 py-4 text-center">
                            <button class="p-2 hover:bg-neutral-700 rounded-lg text-neutral-400 hover:text-white transition-colors"
                                title="View Image">
                                <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="p-2 hover:bg-neutral-700 rounded-lg text-blue-500 hover:text-blue-400 transition-colors"
                                title="View Map">
                                <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-400">Dec 14, 2024</td>
                    </tr>

                    <tr class="hover:bg-neutral-700/30 transition-colors duration-200 group">
                        <td
                            class="px-6 py-4 text-sm font-mono text-neutral-500 group-hover:text-neutral-300 hover:text-blue-400 hover:underline cursor-pointer transition-colors">
                            #1232</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-white">Water leakage in park</div>
                            <div class="text-xs text-neutral-500 mt-0.5">Reported by <span>23/v/kpc-cst/33</span></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-300">Water Supply</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-green-900/30 text-green-400 border border-green-700/50">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-green-400 rounded-full"></span>
                                Resolved
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-green-400 font-medium">Low</td>
                        <td class="px-6 py-4 text-center">
                            <button class="p-2 hover:bg-neutral-700 rounded-lg text-neutral-400 hover:text-white transition-colors"
                                title="View Image">
                                <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button class="p-2 hover:bg-neutral-700 rounded-lg text-blue-500 hover:text-blue-400 transition-colors"
                                title="View Map">
                                <svg class="h-5 w-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-400">Dec 12, 2024</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-neutral-900 border-t border-neutral-700 px-6 py-4 flex items-center justify-between">
            <span class="text-sm text-neutral-400">Showing <span class="text-white font-medium">1-3</span> of <span
                    class="text-white font-medium">128</span></span>
            <div class="flex gap-2">
                <button
                    class="px-3 py-1 bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 rounded-lg text-sm transition-colors disabled:opacity-50"
                    disabled>Previous</button>
                <button
                    class="px-3 py-1 bg-neutral-800 hover:bg-neutral-700 border border-neutral-700 rounded-lg text-sm transition-colors">Next</button>
            </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6 space-y-6">
                <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-neutral-300 mb-2">Report Title <span class="text-red-500">*</span></label>
                        <input type="text" required
                            class="w-full px-4 py-2.5 bg-neutral-900 border border-neutral-700 rounded-lg text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all"
                            placeholder="E.g., Large pothole near school">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-300 mb-2">Category <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select required
                                class="w-full px-4 py-2.5 bg-neutral-900 border border-neutral-700 rounded-lg text-white appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all cursor-pointer">
                                <option value="" disabled selected>Select a category...</option>
                                <option>WiFi & Network Issue</option>
                                <option>Electrical Issue</option>
                                <option>Water & Plumbing</option>
                                <option>HVAC (AC/Heating)</option>
                                <option>Furniture & Fixtures</option>
                                <option>Cleaning & Janitorial</option>
                                <option>Security & Safety</option>
                                <option>Road & Pathway Damage</option>
                                <option>Other</option>
                            </select>
                            <svg class="absolute right-3 top-3 h-4 w-4 text-neutral-500 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-300 mb-2">Priority <span class="text-red-500">*</span></label>
                        <div class="flex bg-neutral-900 rounded-lg p-1 border border-neutral-700">
                            <label class="flex-1 text-center cursor-pointer">
                                <input type="radio" name="priority" class="sr-only peer">
                                <span
                                    class="block px-2 py-1.5 rounded-md text-sm text-neutral-400 peer-checked:bg-neutral-800 peer-checked:text-green-400 peer-checked:shadow-sm transition-all">Low</span>
                            </label>
                            <label class="flex-1 text-center cursor-pointer">
                                <input type="radio" name="priority" class="sr-only peer">
                                <span
                                    class="block px-2 py-1.5 rounded-md text-sm text-neutral-400 peer-checked:bg-neutral-800 peer-checked:text-white peer-checked:shadow-sm transition-all">Med</span>
                            </label>
                            <label class="flex-1 text-center cursor-pointer">
                                <input type="radio" name="priority" class="sr-only peer" checked>
                                <span
                                    class="block px-2 py-1.5 rounded-md text-sm text-neutral-400 peer-checked:bg-neutral-800 peer-checked:text-white peer-checked:shadow-sm transition-all">High</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-sm font-medium text-neutral-300">Location <span class="text-red-500">*</span></label>
                        <button type="button" class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
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
                            <svg class="h-4 w-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <input type="text" required
                            class="w-full pl-10 pr-4 py-2.5 bg-neutral-900 border border-neutral-700 rounded-lg text-white placeholder-neutral-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all text-sm"
                            placeholder="Paste Google Maps link or enter address...">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-neutral-300 mb-2">Evidence <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="file" required id="file-upload" class="hidden">
                        <label for="file-upload"
                            class="block border-2 border-dashed border-neutral-700 rounded-xl p-8 text-center hover:border-blue-500/50 hover:bg-neutral-900/50 transition-all cursor-pointer group">
                            <div
                                class="w-12 h-12 bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-neutral-400 group-hover:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-sm text-neutral-300 font-medium">Click to upload or drag and drop</p>
                            <p class="text-xs text-neutral-500 mt-1"> PNG, JPG, JPEG (max. 2MB)</p>
                        </label>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-neutral-700 bg-neutral-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-b-2xl">
                <span class="text-xs text-neutral-500 order-2 sm:order-1 text-center sm:text-left">
                    <span class="text-red-500">*</span> All fields marked above are required
                </span>
                <div class="flex gap-3 order-1 sm:order-2 w-full sm:w-auto justify-end">
                    <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')"
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