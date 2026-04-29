<x-layouts.app title="Documents">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Documents</h2>
            <p class="text-sm text-gray-500 mt-1">All faculty document submissions.</p>
        </div>
        <a href="{{ route('documents.create') }}"
            class="bg-university-red text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition flex items-center gap-2">
            + Log Submission
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('documents.index') }}"
        class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-center">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search faculty name..."
            class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red flex-1 min-w-48">

        <select name="category"
            class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <select name="status"
            class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            <option value="">All Status</option>
            @foreach(['submitted', 'reviewed', 'approved', 'rejected'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>

        <button type="submit"
            class="bg-university-red text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition">
            Filter
        </button>

        @if(request()->hasAny(['search', 'category', 'status']))
        <a href="{{ route('documents.index') }}"
            class="text-sm text-gray-400 hover:text-gray-600 transition">
            Clear
        </a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-base font-semibold text-gray-800">All Submissions
                <span class="ml-2 text-xs font-normal text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                    {{ $total }} total
                </span>
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Faculty Name</th>
                        <th class="px-6 py-3 text-left">Category</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Remarks</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @php
                    $statusColors = [
                        'submitted' => 'bg-yellow-100 text-yellow-800',
                        'reviewed'  => 'bg-blue-100 text-blue-800',
                        'approved'  => 'bg-green-100 text-green-800',
                        'rejected'  => 'bg-red-100 text-red-800',
                    ];
                    @endphp

                    @forelse($documents as $doc)
                    <tr class="hover:bg-gray-50 transition-colors">

                        <td class="px-6 py-3 text-gray-400 text-xs">{{ $doc->id }}</td>

                        <td class="px-6 py-3 font-medium text-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="h-7 w-7 rounded-full bg-university-red text-white text-xs flex items-center justify-center font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($doc->faculty_name, 0, 1)) }}
                                </div>
                                {{ $doc->faculty_name }}
                            </div>
                        </td>

                        <td class="px-6 py-3">
                            @if($doc->category)
                                <span class="px-2 py-1 rounded-md text-xs font-semibold"
                                    style="background-color: {{ $doc->category->color }}22; color: {{ $doc->category->color }}">
                                    {{ $doc->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>

                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$doc->status] }}">
                                {{ ucfirst($doc->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-3 text-gray-500 text-xs">
                            {{ $doc->remarks ?? '—' }}
                        </td>

                        <td class="px-6 py-3 text-gray-400 text-xs">
                            {{ $doc->submission_date->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('documents.edit', $doc) }}"
                                    class="px-3 py-1 text-xs font-medium bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('documents.destroy', $doc) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this submission?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 text-xs font-medium bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <p class="text-gray-400 text-sm">No submissions found.</p>
                            <a href="{{ route('documents.create') }}"
                                class="mt-2 inline-block text-xs text-university-red hover:underline">
                                Log your first submission →
                            </a>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t bg-gray-50 flex justify-between items-center text-xs text-gray-500">
            <span>
                @if($documents->total() > 0)
                    Showing {{ $documents->firstItem() }} to {{ $documents->lastItem() }} of {{ $documents->total() }} results
                @else
                    No results found
                @endif
            </span>
            {{ $documents->withQueryString()->links() }}
        </div>
    </div>

</x-layouts.app>