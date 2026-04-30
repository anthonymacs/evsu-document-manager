<x-layouts.app title="Documents">

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up         { animation: fadeInUp 0.4s ease forwards; }
    .animate-fade-up-delay-1 { animation: fadeInUp 0.4s ease 0.05s forwards; opacity: 0; }
    .animate-fade-up-delay-2 { animation: fadeInUp 0.4s ease 0.1s  forwards; opacity: 0; }
    .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.07); }
</style>
@endpush

{{-- Header --}}
<div class="flex flex-wrap justify-between items-start gap-4 mb-8 animate-fade-up">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Documents</h2>
        <p class="text-sm text-gray-500 mt-1">All faculty document submissions.</p>
    </div>
    <a href="{{ route('documents.create') }}"
        class="bg-university-red text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2 shadow-sm">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Log Submission
    </a>
</div>

{{-- Quick Stats --}}
@php
$statusMeta = [
    'submitted' => ['label' => 'Submitted', 'bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-700'],
    'reviewed'  => ['label' => 'Reviewed',  'bg' => 'bg-blue-50',   'border' => 'border-blue-200',   'text' => 'text-blue-700'],
    'approved'  => ['label' => 'Approved',  'bg' => 'bg-green-50',  'border' => 'border-green-200',  'text' => 'text-green-700'],
    'rejected'  => ['label' => 'Rejected',  'bg' => 'bg-red-50',    'border' => 'border-red-200',    'text' => 'text-red-700'],
];
@endphp
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 animate-fade-up-delay-1">
    @foreach($statusMeta as $key => $meta)
    <a href="{{ route('documents.index') }}?status={{ $key }}"
        class="stat-card bg-white rounded-2xl border {{ $meta['border'] }} p-4 {{ request('status') === $key ? 'ring-2 ring-offset-1 ring-university-red' : '' }}">
        <p class="text-2xl font-black {{ $meta['text'] }}">
            {{ $statusCounts[$key] ?? 0 }}
        </p>
        <p class="text-xs text-gray-500 font-medium mt-0.5">{{ $meta['label'] }}</p>
    </a>
    @endforeach
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 animate-fade-up-delay-1">
    <form method="GET" action="{{ route('documents.index') }}"
        class="flex flex-wrap gap-3 items-center">
        <div class="relative flex-1 min-w-48">
            <svg class="h-4 w-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search faculty name..."
                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
        </div>
        <select name="category"
            class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <select name="status"
            class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            <option value="">All Status</option>
            @foreach(['submitted', 'reviewed', 'approved', 'rejected'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>
        <button type="submit"
            class="bg-university-red text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition">
            Filter
        </button>
        @if(request()->hasAny(['search', 'category', 'status']))
        <a href="{{ route('documents.index') }}"
            class="text-sm text-gray-400 hover:text-gray-600 transition flex items-center gap-1">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Clear
        </a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-up-delay-2">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-base font-semibold text-gray-800">All Submissions</h3>
            <p class="text-xs text-gray-400 mt-0.5">{{ $total }} records total</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Faculty Name</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left hidden lg:table-cell">Remarks</th>
                    <th class="px-6 py-3 text-left hidden md:table-cell">Date</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                $statusColors = [
                    'submitted' => 'bg-yellow-100 text-yellow-800',
                    'reviewed'  => 'bg-blue-100   text-blue-800',
                    'approved'  => 'bg-green-100  text-green-800',
                    'rejected'  => 'bg-red-100    text-red-800',
                ];
                @endphp
                @forelse($documents as $i => $doc)
                <tr class="hover:bg-gray-50 transition-colors group"
                    style="animation: fadeInUp 0.35s ease {{ $i * 0.04 }}s forwards; opacity: 0;">
                    <td class="px-6 py-3.5 text-gray-400 text-xs font-mono">{{ $doc->id }}</td>
                    <td class="px-6 py-3.5 font-medium text-gray-800">
                        <div class="flex items-center gap-2.5">
                            <div class="h-8 w-8 rounded-full bg-university-red text-white text-xs flex items-center justify-center font-bold flex-shrink-0 shadow-sm">
                                {{ strtoupper(substr($doc->faculty_name, 0, 1)) }}
                            </div>
                            <span class="text-sm">{{ $doc->faculty_name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-3.5">
                        @if($doc->category)
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold"
                                style="background-color:{{ $doc->category->color }}18; color:{{ $doc->category->color }}">
                                {{ $doc->category->name }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$doc->status] }}">
                            {{ ucfirst($doc->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 text-gray-500 text-xs hidden lg:table-cell max-w-xs truncate">
                        {{ $doc->remarks ?? '—' }}
                    </td>
                    <td class="px-6 py-3.5 text-gray-400 text-xs hidden md:table-cell whitespace-nowrap">
                        {{ $doc->submission_date->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2 opacity-60 group-hover:opacity-100 transition">
                            <a href="{{ route('documents.edit', $doc) }}"
                                class="px-3 py-1.5 text-xs font-semibold bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('documents.destroy', $doc) }}"
                                onsubmit="return confirm('Delete this submission? This cannot be undone.')">
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
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm font-medium">No submissions found.</p>
                            <a href="{{ route('documents.create') }}"
                                class="text-xs text-university-red hover:underline font-semibold">
                                Log your first submission →
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <x-ui.pagination :paginator="$documents" />
</div>

</x-layouts.app>