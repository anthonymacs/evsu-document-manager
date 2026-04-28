<x-layouts.app title="Audit Logs">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Audit Logs</h2>
            <p class="text-sm text-gray-500 mt-1">Track all system activity and document changes.</p>
        </div>
        <button class="border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">
            Export Logs
        </button>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border-t-4 border-blue-500 text-center">
            <p class="text-2xl font-bold text-blue-700">142</p>
            <p class="text-xs text-gray-500 mt-1">Total Actions</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border-t-4 border-green-500 text-center">
            <p class="text-2xl font-bold text-green-700">87</p>
            <p class="text-xs text-gray-500 mt-1">Submissions</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border-t-4 border-yellow-500 text-center">
            <p class="text-2xl font-bold text-yellow-700">34</p>
            <p class="text-xs text-gray-500 mt-1">Status Updates</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border-t-4 border-red-500 text-center">
            <p class="text-2xl font-bold text-red-700">21</p>
            <p class="text-xs text-gray-500 mt-1">Deletions</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-center">
        <input type="text" placeholder="Search by user or action..."
            class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red flex-1 min-w-48">
        <select class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20">
            <option>All Actions</option>
            <option>Created</option>
            <option>Updated</option>
            <option>Deleted</option>
            <option>Approved</option>
            <option>Rejected</option>
        </select>
        <input type="date" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20">
    </div>

    {{-- Logs Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="text-base font-semibold text-gray-800">Activity Log
                <span class="ml-2 text-xs font-normal text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">142 entries</span>
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Action</th>
                        <th class="px-6 py-3 text-left">Description</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-left">Date & Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                    $logs = [
                        ['id' => 1,  'user' => 'Admin User',   'action' => 'created',  'desc' => 'Logged CSR submission for John Jaro',          'category' => 'CSR',             'cat_color' => 'blue',   'time' => 'Apr 28, 2026 1:42 PM'],
                        ['id' => 2,  'user' => 'Admin User',   'action' => 'approved', 'desc' => 'Approved Syllabus submission for Maria Santos',  'category' => 'Syllabus',        'cat_color' => 'red',    'time' => 'Apr 27, 2026 3:15 PM'],
                        ['id' => 3,  'user' => 'Admin User',   'action' => 'updated',  'desc' => 'Updated status for Carlo Reyes to Reviewed',    'category' => 'Teaching Load',   'cat_color' => 'green',  'time' => 'Apr 27, 2026 2:10 PM'],
                        ['id' => 4,  'user' => 'Admin User',   'action' => 'approved', 'desc' => 'Approved Clearance Letter for Ana Dela Cruz',   'category' => 'Clearance Letter','cat_color' => 'yellow', 'time' => 'Apr 26, 2026 4:30 PM'],
                        ['id' => 5,  'user' => 'Admin User',   'action' => 'rejected', 'desc' => 'Rejected PR submission for Jose Mendoza',       'category' => 'PR',              'cat_color' => 'purple', 'time' => 'Apr 26, 2026 11:20 AM'],
                        ['id' => 6,  'user' => 'Admin User',   'action' => 'created',  'desc' => 'Logged CSR submission for Liza Bautista',       'category' => 'CSR',             'cat_color' => 'blue',   'time' => 'Apr 25, 2026 9:05 AM'],
                        ['id' => 7,  'user' => 'Admin User',   'action' => 'deleted',  'desc' => 'Deleted duplicate submission for Ramon V.',      'category' => 'Syllabus',        'cat_color' => 'red',    'time' => 'Apr 25, 2026 8:50 AM'],
                        ['id' => 8,  'user' => 'Admin User',   'action' => 'updated',  'desc' => 'Updated remarks for Grace Florendo',            'category' => 'Teaching Load',   'cat_color' => 'green',  'time' => 'Apr 24, 2026 2:00 PM'],
                    ];

                    $actionColors = [
                        'created'  => 'bg-green-100 text-green-700',
                        'updated'  => 'bg-blue-100 text-blue-700',
                        'deleted'  => 'bg-red-100 text-red-700',
                        'approved' => 'bg-emerald-100 text-emerald-700',
                        'rejected' => 'bg-orange-100 text-orange-700',
                    ];

                    $catColors = [
                        'blue'   => 'bg-blue-100 text-blue-700',
                        'green'  => 'bg-green-100 text-green-700',
                        'yellow' => 'bg-yellow-100 text-yellow-700',
                        'red'    => 'bg-red-100 text-red-700',
                        'purple' => 'bg-purple-100 text-purple-700',
                    ];
                    @endphp

                    @foreach($logs as $log)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-400 text-xs">{{ $log['id'] }}</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <div class="h-7 w-7 rounded-full bg-university-red text-white text-xs flex items-center justify-center font-semibold flex-shrink-0">
                                    A
                                </div>
                                <span class="font-medium text-gray-800">{{ $log['user'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $actionColors[$log['action']] }}">
                                {{ ucfirst($log['action']) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600 text-xs max-w-xs">{{ $log['desc'] }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold {{ $catColors[$log['cat_color']] }}">
                                {{ $log['category'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-400 text-xs">{{ $log['time'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t bg-gray-50 flex justify-between items-center text-xs text-gray-500">
            <span>Showing 1 to 8 of 142 results</span>
            <div class="flex gap-1">
                <button class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 text-gray-400 cursor-not-allowed">Prev</button>
                <button class="px-3 py-1.5 rounded-lg bg-university-red text-white font-bold">1</button>
                <button class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 hover:bg-gray-50">2</button>
                <button class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 hover:bg-gray-50">3</button>
                <button class="px-3 py-1.5 rounded-lg bg-white border border-gray-200 hover:bg-gray-50">Next</button>
            </div>
        </div>
    </div>

</x-layouts.app>