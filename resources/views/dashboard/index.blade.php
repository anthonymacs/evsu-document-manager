{{-- resources/views/dashboard/index.blade.php --}}
<x-layouts.app title="Dashboard">

    {{-- Page Title --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        <p class="text-sm text-gray-500 mt-1">Welcome back! Here's a summary of all document submissions.</p>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

        {{-- Total --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-gray-400 flex items-center gap-4">
            <div class="bg-gray-100 rounded-full p-3">
                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Submissions</p>
                <p class="text-2xl font-bold text-gray-800">87</p>
            </div>
        </div>

        {{-- CSR --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-blue-500 flex items-center gap-4">
            <div class="bg-blue-50 rounded-full p-3">
                <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">CSR</p>
                <p class="text-2xl font-bold text-gray-800">24</p>
            </div>
        </div>

        {{-- Teaching Load --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-green-500 flex items-center gap-4">
            <div class="bg-green-50 rounded-full p-3">
                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Teaching Load</p>
                <p class="text-2xl font-bold text-gray-800">18</p>
            </div>
        </div>

        {{-- Clearance Letter --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-yellow-500 flex items-center gap-4">
            <div class="bg-yellow-50 rounded-full p-3">
                <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Clearance</p>
                <p class="text-2xl font-bold text-gray-800">15</p>
            </div>
        </div>

        {{-- Syllabus + PR --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-university-red flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="bg-red-50 rounded-full p-2">
                    <svg class="h-5 w-5 text-university-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Syllabus</p>
                    <p class="text-xl font-bold text-gray-800">17</p>
                </div>
            </div>
            <hr class="border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-purple-50 rounded-full p-2">
                    <svg class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">PR</p>
                    <p class="text-xl font-bold text-gray-800">13</p>
                </div>
            </div>
        </div>

    </div>
    {{-- ── END STAT CARDS ── --}}


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── RECENT SUBMISSIONS TABLE ── --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm">
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h3 class="text-base font-semibold text-gray-800">Recent Submissions</h3>
                <a href="#" class="text-sm text-university-red hover:underline font-medium">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                            <th class="px-6 py-3 text-left">Student Name</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">

                        @php
                        $submissions = [
                            ['name' => 'John Jaro',        'category' => 'CSR',             'cat_color' => 'blue',   'status' => 'submitted', 'date' => 'Apr 28, 2026'],
                            ['name' => 'Maria Santos',     'category' => 'Syllabus',        'cat_color' => 'red',    'status' => 'approved',  'date' => 'Apr 27, 2026'],
                            ['name' => 'Carlo Reyes',      'category' => 'Teaching Load',   'cat_color' => 'green',  'status' => 'reviewed',  'date' => 'Apr 27, 2026'],
                            ['name' => 'Ana Dela Cruz',    'category' => 'Clearance Letter','cat_color' => 'yellow', 'status' => 'approved',  'date' => 'Apr 26, 2026'],
                            ['name' => 'Jose Mendoza',     'category' => 'PR',              'cat_color' => 'purple', 'status' => 'rejected',  'date' => 'Apr 26, 2026'],
                            ['name' => 'Liza Bautista',    'category' => 'CSR',             'cat_color' => 'blue',   'status' => 'submitted', 'date' => 'Apr 25, 2026'],
                            ['name' => 'Ramon Villanueva', 'category' => 'Syllabus',        'cat_color' => 'red',    'status' => 'reviewed',  'date' => 'Apr 25, 2026'],
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

                        @foreach($submissions as $s)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 font-medium text-gray-800">
                                <div class="flex items-center gap-2">
                                    <div class="h-7 w-7 rounded-full bg-university-red text-white text-xs flex items-center justify-center font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($s['name'], 0, 1)) }}
                                    </div>
                                    {{ $s['name'] }}
                                </div>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-1 rounded-md text-xs font-semibold {{ $catColors[$s['cat_color']] }}">
                                    {{ $s['category'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$s['status']] }}">
                                    {{ ucfirst($s['status']) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-400 text-xs">{{ $s['date'] }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        {{-- ── END TABLE ── --}}


        {{-- ── RIGHT COLUMN ── --}}
        <div class="flex flex-col gap-6">

            {{-- Submissions by Category --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Submissions by Category</h3>
                <div class="space-y-3">
                    @php
                    $bars = [
                        ['label' => 'CSR',           'count' => 24, 'max' => 87, 'color' => 'bg-blue-500'],
                        ['label' => 'Teaching Load', 'count' => 18, 'max' => 87, 'color' => 'bg-green-500'],
                        ['label' => 'Clearance',     'count' => 15, 'max' => 87, 'color' => 'bg-yellow-500'],
                        ['label' => 'Syllabus',      'count' => 17, 'max' => 87, 'color' => 'bg-university-red'],
                        ['label' => 'PR',            'count' => 13, 'max' => 87, 'color' => 'bg-purple-500'],
                    ];
                    @endphp

                    @foreach($bars as $bar)
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>{{ $bar['label'] }}</span>
                            <span class="font-semibold">{{ $bar['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="{{ $bar['color'] }} h-2 rounded-full"
                                 style="width: {{ round(($bar['count'] / $bar['max']) * 100) }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Status Breakdown --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Status Breakdown</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-yellow-50 rounded-lg p-3 text-center">
                        <p class="text-xl font-bold text-yellow-700">32</p>
                        <p class="text-xs text-yellow-600 mt-1">Submitted</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-3 text-center">
                        <p class="text-xl font-bold text-blue-700">21</p>
                        <p class="text-xs text-blue-600 mt-1">Reviewed</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center">
                        <p class="text-xl font-bold text-green-700">28</p>
                        <p class="text-xs text-green-600 mt-1">Approved</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-3 text-center">
                        <p class="text-xl font-bold text-red-700">6</p>
                        <p class="text-xs text-red-600 mt-1">Rejected</p>
                    </div>
                </div>
            </div>

        </div>
        {{-- ── END RIGHT COLUMN ── --}}

    </div>

</x-layouts.app>