<x-layouts.app title="Categories">

    {{-- Success Message --}}
    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-xl text-sm font-medium">
        ✅ {{ session('success') }}
    </div>
    @endif

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

    @php
    $statColors = [
        'blue'   => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-500'],
        'green'  => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-500'],
        'yellow' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-500'],
        'red'    => ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-500'],
        'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-500'],
        'pink'   => ['bg' => 'bg-pink-50',   'text' => 'text-pink-700',   'border' => 'border-pink-500'],
        'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-500'],
        'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-500'],
    ];
    @endphp

    {{-- Stats Row --}}
    @if($categories->count())
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-8">
        @foreach($categories->take(5) as $stat)
        @php $sc = $statColors[$stat->color] ?? $statColors['blue']; @endphp
        <div class="bg-white rounded-xl shadow-sm p-4 border-t-4 {{ $sc['border'] }} text-center">
            <p class="text-2xl font-bold {{ $sc['text'] }}">{{ $stat->documents_count ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1 font-medium">{{ $stat->name }}</p>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Categories Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-base font-semibold text-gray-800">All Categories</h3>
            <form method="GET" action="{{ route('categories.index') }}">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search categories..."
                    class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            </form>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Category Name</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $cat)
                @php $sc = $statColors[$cat->color] ?? $statColors['blue']; @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $cat->id }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-md text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                            {{ $cat->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $cat->description ?? '—' }}</td>
                    <td class="px-6 py-4">
                        @if($cat->isActive())
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Active</span>
                        @else
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('categories.edit', $cat) }}"
                                class="px-3 py-1 text-xs font-medium bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">Edit</a>
                            <form method="POST" action="{{ route('categories.destroy', $cat) }}"
                                onsubmit="return confirm('Delete category \'{{ $cat->name }}\'? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 text-xs font-medium bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.app>