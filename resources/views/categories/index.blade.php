<x-layouts.app title="Categories">

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up         { animation: fadeInUp 0.4s ease forwards; }
    .animate-fade-up-delay-1 { animation: fadeInUp 0.4s ease 0.05s forwards; opacity: 0; }
    .animate-fade-up-delay-2 { animation: fadeInUp 0.4s ease 0.1s  forwards; opacity: 0; }
    .animate-fade-up-delay-3 { animation: fadeInUp 0.4s ease 0.15s forwards; opacity: 0; }
    .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
</style>
@endpush

{{-- Header --}}
<div class="flex flex-wrap justify-between items-start gap-4 mb-8 animate-fade-up">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
        <p class="text-sm text-gray-500 mt-1">Manage document submission categories.</p>
    </div>
    <a href="{{ route('categories.create') }}"
        class="bg-university-red text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2 shadow-sm">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Category
    </a>
</div>

@php
$statColors = [
    'blue'   => ['bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'border' => 'border-blue-500',   'bar' => 'bg-blue-400'],
    'green'  => ['bg' => 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-500',  'bar' => 'bg-green-400'],
    'yellow' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-500', 'bar' => 'bg-yellow-400'],
    'red'    => ['bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-500',    'bar' => 'bg-red-400'],
    'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-500', 'bar' => 'bg-purple-400'],
    'pink'   => ['bg' => 'bg-pink-50',   'text' => 'text-pink-700',   'border' => 'border-pink-500',   'bar' => 'bg-pink-400'],
    'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-500', 'bar' => 'bg-indigo-400'],
    'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-500', 'bar' => 'bg-orange-400'],
];
$totalDocs = $statCategories->sum('documents_count');
@endphp

{{-- Stat Cards --}}
@if($statCategories->count())
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8 animate-fade-up-delay-1">
    @foreach($statCategories->take(5) as $stat)
    @php $sc = $statColors[$stat->color] ?? $statColors['blue']; @endphp
    <div class="stat-card bg-white rounded-2xl shadow-sm p-4 border-t-4 {{ $sc['border'] }}">
        <p class="text-3xl font-black {{ $sc['text'] }}">{{ $stat->documents_count ?? 0 }}</p>
        <p class="text-xs text-gray-500 mt-1 font-medium truncate">{{ $stat->name }}</p>
        <div class="mt-3 h-1 bg-gray-100 rounded-full">
            <div class="h-1 {{ $sc['bar'] }} rounded-full transition-all duration-700"
                style="width: {{ $totalDocs > 0 ? round(($stat->documents_count / $totalDocs) * 100) : 0 }}%"></div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Table Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-up-delay-2">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-3">
        <div>
            <h3 class="text-base font-semibold text-gray-800">All Categories</h3>
            <p class="text-xs text-gray-400 mt-0.5">{{ $categories->total() }} categories total</p>
        </div>
        <form method="GET" action="{{ route('categories.index') }}" class="flex items-center gap-2">
            <div class="relative">
                <svg class="h-4 w-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search categories..."
                    class="pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red w-52">
            </div>
            <button type="submit" class="bg-university-red text-white px-3 py-2 rounded-xl text-sm font-semibold hover:opacity-90 transition">
                Search
            </button>
            @if(request('search'))
            <a href="{{ route('categories.index') }}" class="text-sm text-gray-400 hover:text-gray-600">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left hidden md:table-cell">Description</th>
                    <th class="px-6 py-3 text-left">Docs</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $i => $cat)
                @php $sc = $statColors[$cat->color] ?? $statColors['blue']; @endphp
                <tr class="hover:bg-gray-50 transition-colors group"
                    style="animation: fadeInUp 0.35s ease {{ $i * 0.05 }}s forwards; opacity: 0;">
                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">{{ $cat->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-3 h-3 rounded-full flex-shrink-0 {{ $sc['bar'] }}"></div>
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $sc['bg'] }} {{ $sc['text'] }}">
                                {{ $cat->name }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs hidden md:table-cell max-w-xs truncate">
                        {{ $cat->description ?? '—' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold text-gray-700">{{ $cat->documents_count ?? 0 }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($cat->isActive())
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 opacity-60 group-hover:opacity-100 transition">
                            <a href="{{ route('categories.edit', $cat) }}"
                                class="px-3 py-1.5 text-xs font-semibold bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('categories.destroy', $cat) }}"
                                onsubmit="return confirm('Delete category \'{{ $cat->name }}\'? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 text-xs font-semibold bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5l5 5v11a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm font-medium">No categories found.</p>
                            <a href="{{ route('categories.create') }}"
                                class="text-xs text-university-red hover:underline font-semibold">
                                Create your first category →
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <x-ui.pagination :paginator="$categories" />
</div>

</x-layouts.app>