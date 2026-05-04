<x-layouts.app title="Audit Logs">

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
        <h2 class="text-2xl font-bold text-gray-800">Audit Logs</h2>
        <p class="text-sm text-gray-500 mt-1">Track all system activity and record changes.</p>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8 animate-fade-up-delay-1">
    <div class="stat-card bg-white rounded-2xl shadow-sm p-4 border-t-4 border-blue-500">
        <p class="text-3xl font-black text-blue-700">{{ $totalActions }}</p>
        <p class="text-xs text-gray-500 mt-1 font-medium">Total Actions</p>
    </div>
    <div class="stat-card bg-white rounded-2xl shadow-sm p-4 border-t-4 border-green-500">
        <p class="text-3xl font-black text-green-700">{{ $totalCreated }}</p>
        <p class="text-xs text-gray-500 mt-1 font-medium">Created</p>
    </div>
    <div class="stat-card bg-white rounded-2xl shadow-sm p-4 border-t-4 border-yellow-500">
        <p class="text-3xl font-black text-yellow-700">{{ $totalUpdated }}</p>
        <p class="text-xs text-gray-500 mt-1 font-medium">Updated</p>
    </div>
    <div class="stat-card bg-white rounded-2xl shadow-sm p-4 border-t-4 border-red-500">
        <p class="text-3xl font-black text-red-700">{{ $totalDeleted }}</p>
        <p class="text-xs text-gray-500 mt-1 font-medium">Deleted</p>
    </div>
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 animate-fade-up-delay-2">
    <form method="GET" action="{{ route('audit-logs.index') }}"
        class="flex flex-wrap gap-3 items-center">

        {{-- Search --}}
        <div class="relative flex-1 min-w-48">
            <svg class="h-4 w-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search description..."
                class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
        </div>

        {{-- Action --}}
        <select name="action"
            class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            <option value="">All Actions</option>
            <option value="created"  {{ request('action') === 'created'  ? 'selected' : '' }}>Created</option>
            <option value="updated"  {{ request('action') === 'updated'  ? 'selected' : '' }}>Updated</option>
            <option value="deleted"  {{ request('action') === 'deleted'  ? 'selected' : '' }}>Deleted</option>
        </select>

        {{-- Subject Type --}}
        <select name="subject_type"
            class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">
            <option value="">All Types</option>
            <option value="Document" {{ request('subject_type') === 'Document' ? 'selected' : '' }}>Document</option>
            <option value="Category" {{ request('subject_type') === 'Category' ? 'selected' : '' }}>Category</option>
        </select>

        {{-- Date --}}
        <input type="date" name="date" value="{{ request('date') }}"
            class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-university-red/20 focus:border-university-red">

        <button type="submit"
            class="bg-university-red text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition">
            Filter
        </button>

        @if(request()->hasAny(['search', 'action', 'subject_type', 'date']))
        <a href="{{ route('audit-logs.index') }}"
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
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-up-delay-3">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-base font-semibold text-gray-800">Activity Log</h3>
            <p class="text-xs text-gray-400 mt-0.5">{{ $logs->total() }} entries total</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Action</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left hidden lg:table-cell">Changes</th>
                    <th class="px-6 py-3 text-left hidden md:table-cell">Date & Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">

                @php
                $actionColors = [
                    'created' => ['bg' => 'bg-green-100',  'text' => 'text-green-700',  'dot' => 'bg-green-500'],
                    'updated' => ['bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'dot' => 'bg-blue-500'],
                    'deleted' => ['bg' => 'bg-red-100',    'text' => 'text-red-700',    'dot' => 'bg-red-500'],
                ];
                $typeColors = [
                    'Document' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700'],
                    'Category' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                ];
                @endphp

                @forelse($logs as $i => $log)
                @php
                    $ac = $actionColors[$log->action]        ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'dot' => 'bg-gray-400'];
                    $tc = $typeColors[$log->subject_type]    ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                @endphp
                <tr class="hover:bg-gray-50 transition-colors group"
                    style="animation: fadeInUp 0.35s ease {{ $i * 0.04 }}s forwards; opacity: 0;">

                    <td class="px-6 py-3.5 text-gray-400 text-xs font-mono">{{ $log->id }}</td>

                    <td class="px-6 py-3.5">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $tc['bg'] }} {{ $tc['text'] }}">
                            {{ $log->subject_type }}
                        </span>
                    </td>

                    <td class="px-6 py-3.5">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $ac['bg'] }} {{ $ac['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $ac['dot'] }}"></span>
                            {{ ucfirst($log->action) }}
                        </span>
                    </td>

                    <td class="px-6 py-3.5 text-gray-700 text-xs max-w-xs">
                        {{ $log->description }}
                    </td>

                    <td class="px-6 py-3.5 hidden lg:table-cell">
                        @if($log->changes)
                            @php
                                $old = $log->changes['old'] ?? [];
                                $new = $log->changes['new'] ?? [];
                                // For created/deleted just show key count
                                $changedKeys = array_keys(array_merge($old, $new));
                                $skip = ['id', 'created_at', 'updated_at'];
                                $changedKeys = array_filter($changedKeys, fn($k) => !in_array($k, $skip));
                            @endphp
                            @if($log->action === 'updated' && count($old))
                                <div class="space-y-1">
                                    @foreach($changedKeys as $key)
                                        @if(isset($old[$key]) || isset($new[$key]))
                                        <div class="flex items-center gap-1.5 text-xs">
                                            <span class="font-mono text-gray-400">{{ $key }}:</span>
                                            <span class="line-through text-red-400">{{ $old[$key] ?? '—' }}</span>
                                            <span class="text-gray-400">→</span>
                                            <span class="text-green-600 font-medium">{{ $new[$key] ?? '—' }}</span>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-400">{{ count($changedKeys) }} field(s)</span>
                            @endif
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>

                    <td class="px-6 py-3.5 text-gray-400 text-xs hidden md:table-cell whitespace-nowrap">
                        {{ $log->created_at->format('M d, Y g:i A') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm font-medium">No audit logs found.</p>
                            @if(request()->hasAny(['search', 'action', 'subject_type', 'date']))
                                <a href="{{ route('audit-logs.index') }}" class="text-xs text-university-red hover:underline font-semibold">
                                    Clear filters →
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <x-ui.pagination :paginator="$logs" />
</div>

</x-layouts.app>