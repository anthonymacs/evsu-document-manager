<x-layouts.app title="Dashboard">

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes shimmer {
        0%   { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes pulse-ring {
        0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(180,0,0,0.4); }
        70%  { transform: scale(1); box-shadow: 0 0 0 8px rgba(180,0,0,0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(180,0,0,0); }
    }

    .animate-fade-up         { animation: fadeInUp 0.5s ease forwards; }
    .animate-fade-up-delay-1 { animation: fadeInUp 0.5s ease 0.1s forwards; opacity: 0; }
    .animate-fade-up-delay-2 { animation: fadeInUp 0.5s ease 0.2s forwards; opacity: 0; }
    .animate-fade-up-delay-3 { animation: fadeInUp 0.5s ease 0.3s forwards; opacity: 0; }
    .animate-fade-up-delay-4 { animation: fadeInUp 0.5s ease 0.4s forwards; opacity: 0; }
    .animate-fade-up-delay-5 { animation: fadeInUp 0.5s ease 0.5s forwards; opacity: 0; }
    .animate-fade-up-delay-6 { animation: fadeInUp 0.5s ease 0.5s forwards; opacity: 0; }
    .animate-fade-up-delay-7 { animation: fadeInUp 0.5s ease 0.5s forwards; opacity: 0; }

    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .progress-bar {
        transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-backdrop {
        backdrop-filter: blur(4px);
    }

    .pulse-ring {
        animation: pulse-ring 2s infinite;
    }

    .stat-card.selected {
        ring: 2px;
        box-shadow: 0 0 0 2px currentColor;
    }
</style>
@endpush

@php
    $colorMap = [
        'blue'   => '#3b82f6',
        'green'  => '#22c55e',
        'yellow' => '#eab308',
        'red'    => '#ef4444',
        'purple' => '#a855f7',
        'pink'   => '#ec4899',
        'indigo' => '#6366f1',
        'orange' => '#f97316',
    ];

    
    $submissionsJson = $recentSubmissions->map(fn($s) => [
        'id'              => $s->id,
        'faculty_name'    => $s->faculty_name,
        'category_id'     => $s->category_id,
        'category_name'   => $s->category?->name,
        'category_color'  => $s->category ? ($colorMap[$s->category->color] ?? '#6b7280') : null,
        'status'          => $s->status,
        'submission_date' => $s->submission_date->format('M d, Y'),
        'edit_url'        => route('documents.edit', $s),
        'avatar'          => strtoupper(substr($s->faculty_name, 0, 1)),
    ])->values()->toJson();

    $categoryCardsJson = $categoryStats->map(fn($cat) => [
        'id'    => $cat->id,
        'name'  => $cat->name,
        'color' => $colorMap[$cat->color] ?? '#6b7280',
        'count' => $cat->documents_count,
    ])->values()->toJson();
@endphp

<div
    x-data="dashboard()"
    x-init="init()"
>

    {{-- Header --}}
    <div class="flex justify-between items-start mb-8 animate-fade-up">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">
                Welcome back! Here's a live summary of all document submissions.
            </p>
        </div>

        <div class="flex items-center gap-2 text-xs text-gray-400 bg-white border border-gray-100 rounded-lg px-3 py-2 shadow-sm">
            <div class="w-2 h-2 rounded-full bg-green-400 pulse-ring"></div>
            Live Data
        </div>
    </div>

    {{-- TOP CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-7 gap-3 mb-8">

        {{-- Total card — clicking clears filter --}}
        <div
            class="stat-card animate-fade-up-delay-1 bg-white rounded-2xl shadow-sm p-5 border border-gray-100 cursor-pointer"
            :class="{ 'ring-2 ring-gray-400': selectedCategory === null }"
            @click="selectCategory(null)"
        >
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gray-100 rounded-xl p-3">
                    <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">
                    All Time
                </span>
            </div>

            <p class="text-3xl font-bold text-gray-800" x-text="animatedTotal"></p>

            <p class="text-xs text-gray-500 mt-1 font-medium">Total Submissions</p>

            <div class="mt-3 h-1 bg-gray-100 rounded-full">
                <div class="h-1 bg-gray-400 rounded-full progress-bar" style="width: 100%"></div>
            </div>
        </div>

        {{-- CATEGORY CARDS --}}
        @forelse($categoryStats->take(6) as $index => $cat)
            @php
                $hex     = $colorMap[$cat->color] ?? '#6b7280';
                $percent = $totalDocuments > 0
                    ? round(($cat->documents_count / $totalDocuments) * 100)
                    : 0;
            @endphp

            <div
                class="stat-card animate-fade-up-delay-{{ $index + 2 }} bg-white rounded-2xl shadow-sm p-5 border border-gray-100 cursor-pointer transition-all"
                :class="{ 'ring-2': selectedCategory === {{ $cat->id }} }"
                :style="selectedCategory === {{ $cat->id }} ? 'box-shadow: 0 0 0 2px {{ $hex }}; outline: 2px solid {{ $hex }}; outline-offset: 0px;' : ''"
                @click="selectCategory({{ $cat->id }})"
                title="Filter by {{ $cat->name }}"
            >
                <div class="flex items-center justify-between mb-4">
                    <div class="rounded-xl p-3" style="background-color: {{ $hex }}15">
                        <svg class="h-6 w-6" style="color: {{ $hex }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5l5 5v11a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h2z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-medium px-2 py-1 rounded-lg"
                        style="background-color: {{ $hex }}15; color: {{ $hex }}">
                        {{ $percent }}%
                    </span>
                </div>

                <p class="text-3xl font-bold" style="color: {{ $hex }}">{{ $cat->documents_count }}</p>

                <p class="text-xs text-gray-500 mt-1 font-medium">{{ $cat->name }}</p>

                <div class="mt-3 h-1 bg-gray-100 rounded-full">
                    <div class="h-1 rounded-full progress-bar"
                        style="width: {{ $percent }}%; background-color: {{ $hex }}">
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <p class="text-sm text-gray-400">No categories available.</p>
            </div>
        @endforelse

    </div>

    {{-- CONTENT --}}
    <div class="grid grid-cols-1 gap-6">
        <div class="animate-fade-up-delay-3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- TABLE HEADER --}}
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-50">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Recent Submissions</h3>

                        {{-- Dynamic subtitle --}}
                        <p class="text-xs text-gray-400 mt-0.5">
                            <template x-if="selectedCategory === null">
                                <span>Latest {{ count($recentSubmissions) }} records</span>
                            </template>
                            <template x-if="selectedCategory !== null">
                                <span>
                                    Showing
                                    <span x-text="filteredSubmissions.length"></span>
                                    record<span x-show="filteredSubmissions.length !== 1">s</span>
                                    for
                                    <span
                                        class="font-semibold"
                                        x-text="selectedCategoryName"
                                        :style="`color: ${selectedCategoryColor}`"
                                    ></span>
                                    &nbsp;·&nbsp;
                                    <button
                                        class="underline text-gray-400 hover:text-gray-600"
                                        @click="selectCategory(null)"
                                    >
                                        Clear filter
                                    </button>
                                </span>
                            </template>
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('documents.create') }}"
                            class="bg-university-red text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2 shadow-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Log Submission
                        </a>
                        <a href="{{ route('documents.index') }}"
                            class="text-sm font-semibold text-white bg-gray-700 px-4 py-2.5 rounded-xl hover:bg-gray-800 transition">
                            View All →
                        </a>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                                <th class="px-6 py-4 text-left">Faculty</th>
                                <th class="px-6 py-4 text-left">Category</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-left">Date</th>
                                <th class="px-6 py-4 text-left">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-50">

                            {{-- Empty state when filter yields no results --}}
                            <template x-if="filteredSubmissions.length === 0">
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 text-sm font-medium" x-text="selectedCategory ? 'No submissions for this category.' : 'No submissions yet'"></p>
                                            <template x-if="selectedCategory !== null">
                                                <button
                                                    class="text-xs text-university-red hover:underline font-semibold"
                                                    @click="selectCategory(null)"
                                                >
                                                    ← Show all submissions
                                                </button>
                                            </template>
                                            <template x-if="selectedCategory === null">
                                                <a href="{{ route('documents.create') }}"
                                                    class="text-xs text-university-red hover:underline font-semibold">
                                                    Log your first submission →
                                                </a>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            {{-- Rows (rendered by Alpine) --}}
                            <template x-for="(s, i) in filteredSubmissions" :key="s.id">
                                <tr class="hover:bg-gray-50 transition-colors group">

                                    {{-- Faculty --}}
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-full bg-university-red text-white text-sm flex items-center justify-center font-bold shadow-sm"
                                                x-text="s.avatar">
                                            </div>
                                            <span class="text-sm font-medium" x-text="s.faculty_name"></span>
                                        </div>
                                    </td>

                                    {{-- Category --}}
                                    <td class="px-6 py-4">
                                        <template x-if="s.category_name">
                                            <span class="px-3 py-1 rounded-lg text-xs font-semibold"
                                                :style="`background-color: ${s.category_color}18; color: ${s.category_color}`"
                                                x-text="s.category_name">
                                            </span>
                                        </template>
                                        <template x-if="!s.category_name">
                                            <span class="text-gray-400 text-xs">—</span>
                                        </template>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                            :class="{
                                                'bg-yellow-100 text-yellow-800': s.status === 'submitted',
                                                'bg-blue-100 text-blue-800':    s.status === 'reviewed',
                                                'bg-green-100 text-green-800':  s.status === 'approved',
                                                'bg-red-100 text-red-800':      s.status === 'rejected',
                                            }"
                                            x-text="s.status.charAt(0).toUpperCase() + s.status.slice(1)">
                                        </span>
                                    </td>

                                    {{-- Date --}}
                                    <td class="px-6 py-4 text-gray-500 text-sm" x-text="s.submission_date"></td>

                                    {{-- Action --}}
                                    <td class="px-6 py-4">
                                        <a :href="s.edit_url"
                                            class="opacity-0 group-hover:opacity-100 transition px-3 py-1.5 text-xs font-medium bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                </div>
                {{-- END TABLE --}}

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function dashboard() {
        return {
            // ── data ──────────────────────────────────────────────
            totalCount:    {{ $totalDocuments }},
            animatedTotal: 0,
            allSubmissions: {!! $submissionsJson !!},
            categoryCards:  {!! $categoryCardsJson !!},

            // ── filter state ─────────────────────────────────────
            selectedCategory:      null,   // null = show all
            selectedCategoryName:  '',
            selectedCategoryColor: '#6b7280',

            // ── computed ─────────────────────────────────────────
            get filteredSubmissions() {
                if (this.selectedCategory === null) return this.allSubmissions;
                return this.allSubmissions.filter(s => s.category_id === this.selectedCategory);
            },

            // ── methods ──────────────────────────────────────────
            selectCategory(id) {
                if (this.selectedCategory === id) {
                    // clicking the same card again deselects it
                    this.selectedCategory      = null;
                    this.selectedCategoryName  = '';
                    this.selectedCategoryColor = '#6b7280';
                    return;
                }
                this.selectedCategory = id;
                if (id !== null) {
                    const card = this.categoryCards.find(c => c.id === id);
                    this.selectedCategoryName  = card ? card.name  : '';
                    this.selectedCategoryColor = card ? card.color : '#6b7280';
                }
            },

            // ── lifecycle ────────────────────────────────────────
            init() {
                // Animate the total counter
                let start     = 0;
                const end     = this.totalCount;
                const dur     = 1200;
                const step    = 16;
                const inc     = end / (dur / step);
                const counter = setInterval(() => {
                    start += inc;
                    if (start >= end) {
                        this.animatedTotal = end;
                        clearInterval(counter);
                    } else {
                        this.animatedTotal = Math.floor(start);
                    }
                }, step);
            },
        };
    }
</script>
@endpush

</x-layouts.app>