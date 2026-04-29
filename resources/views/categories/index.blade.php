<x-layouts.app title="Categories">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
            <p class="text-sm text-gray-500 mt-1">Manage document submission categories.</p>
        </div>
        <a href="{{ route('categories.create') }}"
            class="bg-university-red text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition flex items-center gap-2">
            + Add Category
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-8">
        @php
        $catStats = [
        ['name' => 'CSR', 'count' => 24, 'color' => 'blue'],
        ['name' => 'Teaching Load', 'count' => 18, 'color' => 'green'],
        ['name' => 'Clearance Letter','count' => 15, 'color' => 'yellow'],
        ['name' => 'Syllabus', 'count' => 17, 'color' => 'red'],
        ['name' => 'PR', 'count' => 13, 'color' => 'purple'],
        ];
        $statColors = [
        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-500'],
        'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-500'],
        'yellow' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-500'],
        'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-500'],
        'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-500'],
        ];
        @endphp
        @foreach($catStats as $stat)
        <div class="bg-white rounded-xl shadow-sm p-4 border-t-4 {{ $statColors[$stat['color']]['border'] }} text-center">
            <p class="text-2xl font-bold {{ $statColors[$stat['color']]['text'] }}">{{ $stat['count'] }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">{{ $stat['name'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Categories Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-base font-semibold text-gray-800">All Categories</h3>
            <input type="text" placeholder="Search categories..."
                class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Category Name</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Total Submissions</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                $categories = [
                ['id' => 1, 'name' => 'CSR', 'desc' => 'Community Service Record', 'count' => 24, 'color' => 'blue', 'active' => true],
                ['id' => 2, 'name' => 'Teaching Load', 'desc' => 'Faculty Teaching Load Docs', 'count' => 18, 'color' => 'green', 'active' => true],
                ['id' => 3, 'name' => 'Clearance Letter','desc' => 'Student Clearance Letters', 'count' => 15, 'color' => 'yellow', 'active' => true],
                ['id' => 4, 'name' => 'Syllabus', 'desc' => 'Course Syllabi', 'count' => 17, 'color' => 'red', 'active' => true],
                ['id' => 5, 'name' => 'PR', 'desc' => 'Progress Reports', 'count' => 13, 'color' => 'purple', 'active' => false],
                ];
                @endphp
                @foreach($categories as $cat)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $cat['id'] }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-md text-xs font-bold {{ $statColors[$cat['color']]['bg'] }} {{ $statColors[$cat['color']]['text'] }}">
                            {{ $cat['name'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $cat['desc'] }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $cat['count'] }}</span>
                        <span class="text-gray-400 text-xs ml-1">submissions</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($cat['active'])
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Active</span>
                        @else
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button class="px-3 py-1 text-xs font-medium bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">Edit</button>
                            <button class="px-3 py-1 text-xs font-medium bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">Delete</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layouts.app>