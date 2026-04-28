<x-layouts.app title="Documents">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Documents</h2>
            <p class="text-sm text-gray-500 mt-1">All student document submissions.</p>
        </div>
        <button class="bg-university-red text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition">
            + Log Submission
        </button>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-center">
        <input type="text" placeholder="Search student name..."
            class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red flex-1 min-w-48">
        <select class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            <option>All Categories</option>
            <option>CSR</option>
            <option>Teaching Load</option>
            <option>Clearance Letter</option>
            <option>Syllabus</option>
            <option>PR</option>
        </select>
        <select class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            <option>All Status</option>
            <option>Submitted</option>
            <option>Reviewed</option>
            <option>Approved</option>
            <option>Rejected</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-base font-semibold text-gray-800">All Submissions
                <span class="ml-2 text-xs font-normal text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">87 total</span>
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Student Name</th>
                        <th class="px-6 py-3 text-left">Student ID</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Remarks</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                    $docs = [
                        ['id' => 1,  'name' => 'John Jaro',        'sid' => '2021-00101', 'category' => 'CSR',             'cat_color' => 'blue',   'status' => 'submitted', 'remarks' => 'Hard copy submitted', 'date' => 'Apr 28, 2026'],
                        ['id' => 2,  'name' => 'Maria Santos',     'sid' => '2021-00102', 'category' => 'Syllabus',        'cat_color' => 'red',    'status' => 'approved',  'remarks' => 'Original document',   'date' => 'Apr 27, 2026'],
                        ['id' => 3,  'name' => 'Carlo Reyes',      'sid' => '2021-00103', 'category' => 'Teaching Load',   'cat_color' => 'green',  'status' => 'reviewed',  'remarks' => '—',                   'date' => 'Apr 27, 2026'],
                        ['id' => 4,  'name' => 'Ana Dela Cruz',    'sid' => '2021-00104', 'category' => 'Clearance Letter','cat_color' => 'yellow', 'status' => 'approved',  'remarks' => 'Verified',             'date' => 'Apr 26, 2026'],
                        ['id' => 5,  'name' => 'Jose Mendoza',     'sid' => '2021-00105', 'category' => 'PR',              'cat_color' => 'purple', 'status' => 'rejected',  'remarks' => 'Incomplete form',     'date' => 'Apr 26, 2026'],
                        ['id' => 6,  'name' => 'Liza Bautista',    'sid' => '2021-00106', 'category' => 'CSR',             'cat_color' => 'blue',   'status' => 'submitted', 'remarks' => '—',                   'date' => 'Apr 25, 2026'],
                        ['id' => 7,  'name' => 'Ramon Villanueva', 'sid' => '2021-00107', 'category' => 'Syllabus',        'cat_color' => 'red',    'status' => 'reviewed',  'remarks' => 'For revision',        'date' => 'Apr 25, 2026'],
                        ['id' => 8,  'name' => 'Grace Florendo',   'sid' => '2021-00108', 'category' => 'Teaching Load',   'cat_color' => 'green',  'status' => 'approved',  'remarks' => '—',                   'date' => 'Apr 24, 2026'],
                        ['id' => 9,  'name' => 'Mark Escoto',      'sid' => '2021-00109', 'category' => 'CSR',             'cat_color' => 'blue',   'status' => 'submitted', 'remarks' => 'Hard copy submitted', 'date' => 'Apr 24, 2026'],
                        ['id' => 10, 'name' => 'Nina Catalan',     'sid' => '2021-00110', 'category' => 'PR',              'cat_color' => 'purple', 'status' => 'approved',  'remarks' => '—',                   'date' => 'Apr 23, 2026'],
                    ];

                    $statusColors = [
                        'submitted' => 'bg-yellow-100 text-yellow-800',
                        'reviewed'  => 'bg-blue-100 text-blue-800',
                        'approved'  => 'bg-green-100 text-green-800',
                        'rejected'  => 'bg-red-100 text-red-800',
                    ];

                    $catColors = [
                        'blue'   => 'bg-blue-100 text-blue-700',
                        'green'  => 'bg-green-100 text-green-700',
                        'yellow' => 'bg-yellow-100 text-yellow-700',
                        'red'    => 'bg-red-100 text-red-700',
                        'purple' => 'bg-purple-100 text-purple-700',
                    ];
                    @endphp

                    @foreach($docs as $doc)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 text-gray-400 text-xs">{{ $doc['id'] }}</td>
                        <td class="px-6 py-3 font-medium text-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="h-7 w-7 rounded-full bg-university-red text-white text-xs flex items-center justify-center font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($doc['name'], 0, 1)) }}
                                </div>
                                {{ $doc['name'] }}
                            </div>
                        </td>
                        <td class="px-6 py-3 text-gray-500 text-xs">{{ $doc['sid'] }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold {{ $catColors[$doc['cat_color']] }}">
                                {{ $doc['category'] }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$doc['status']] }}">
                                {{ ucfirst($doc['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-500 text-xs">{{ $doc['remarks'] }}</td>
                        <td class="px-6 py-3 text-gray-400 text-xs">{{ $doc['date'] }}</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1 text-xs font-medium bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">View</button>
                                <button class="px-3 py-1 text-xs font-medium bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition">Edit</button>
                                <button class="px-3 py-1 text-xs font-medium bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t bg-gray-50 flex justify-between items-center text-xs text-gray-500">
            <span>Showing 1 to 10 of 87 results</span>
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