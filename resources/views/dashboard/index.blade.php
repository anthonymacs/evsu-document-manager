<x-layouts.app title="Dashboard">

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes countUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes pulse-ring {
        0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(180,0,0,0.4); }
        70%  { transform: scale(1);    box-shadow: 0 0 0 8px rgba(180,0,0,0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(180,0,0,0); }
    }
    .animate-fade-up         { animation: fadeInUp 0.5s ease forwards; }
    .animate-fade-up-delay-1 { animation: fadeInUp 0.5s ease 0.1s forwards; opacity: 0; }
    .animate-fade-up-delay-2 { animation: fadeInUp 0.5s ease 0.2s forwards; opacity: 0; }
    .animate-fade-up-delay-3 { animation: fadeInUp 0.5s ease 0.3s forwards; opacity: 0; }
    .animate-fade-up-delay-4 { animation: fadeInUp 0.5s ease 0.4s forwards; opacity: 0; }
    .animate-fade-up-delay-5 { animation: fadeInUp 0.5s ease 0.5s forwards; opacity: 0; }
    .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .progress-bar { transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1); }
    .shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    .modal-backdrop { backdrop-filter: blur(4px); }
    .pulse-ring { animation: pulse-ring 2s infinite; }
</style>
@endpush

<div x-data="dashboard()" x-init="init()">

    {{-- Page Header --}}
    <div class="flex justify-between items-start mb-8 animate-fade-up">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">Welcome back! Here's a live summary of all document submissions.</p>
        </div>
        <div class="flex items-center gap-2 text-xs text-gray-400 bg-white border border-gray-100 rounded-lg px-3 py-2 shadow-sm">
            <div class="w-2 h-2 rounded-full bg-green-400 pulse-ring"></div>
            Live Data
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        {{-- Total Submissions --}}
        <div class="stat-card animate-fade-up-delay-1 bg-white rounded-2xl shadow-sm p-5 border border-gray-100 cursor-pointer"
            @click="openModal('total')">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gray-100 rounded-xl p-3">
                    <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">All Time</span>
            </div>
            <p class="text-3xl font-bold text-gray-800" x-text="animatedTotal"></p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Total Submissions</p>
            <div class="mt-3 h-1 bg-gray-100 rounded-full">
                <div class="h-1 bg-gray-400 rounded-full progress-bar" style="width: 100%"></div>
            </div>
        </div>

        {{-- Submitted --}}
        <div class="stat-card animate-fade-up-delay-2 bg-white rounded-2xl shadow-sm p-5 border border-yellow-100 cursor-pointer"
            @click="openModal('submitted')">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-yellow-50 rounded-xl p-3">
                    <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-lg">Pending</span>
            </div>
            <p class="text-3xl font-bold text-yellow-600" x-text="animatedSubmitted"></p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Submitted</p>
            <div class="mt-3 h-1 bg-yellow-100 rounded-full">
                <div class="h-1 bg-yellow-400 rounded-full progress-bar"
                    :style="`width: ${total > 0 ? Math.round((submitted/total)*100) : 0}%`"></div>
            </div>
        </div>

        {{-- Approved --}}
        <div class="stat-card animate-fade-up-delay-3 bg-white rounded-2xl shadow-sm p-5 border border-green-100 cursor-pointer"
            @click="openModal('approved')">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-50 rounded-xl p-3">
                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">Done</span>
            </div>
            <p class="text-3xl font-bold text-green-600" x-text="animatedApproved"></p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Approved</p>
            <div class="mt-3 h-1 bg-green-100 rounded-full">
                <div class="h-1 bg-green-400 rounded-full progress-bar"
                    :style="`width: ${total > 0 ? Math.round((approved/total)*100) : 0}%`"></div>
            </div>
        </div>

        {{-- Rejected --}}
        <div class="stat-card animate-fade-up-delay-4 bg-white rounded-2xl shadow-sm p-5 border border-red-100 cursor-pointer"
            @click="openModal('rejected')">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-red-50 rounded-xl p-3">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-lg">Issues</span>
            </div>
            <p class="text-3xl font-bold text-red-600" x-text="animatedRejected"></p>
            <p class="text-xs text-gray-500 mt-1 font-medium">Rejected</p>
            <div class="mt-3 h-1 bg-red-100 rounded-full">
                <div class="h-1 bg-red-400 rounded-full progress-bar"
                    :style="`width: ${total > 0 ? Math.round((rejected/total)*100) : 0}%`"></div>
            </div>
        </div>

    </div>
    {{-- ── END STAT CARDS ── --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── RECENT SUBMISSIONS TABLE ── --}}
        <div class="lg:col-span-2 animate-fade-up-delay-3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-50">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Recent Submissions</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Latest {{ count($recentSubmissions) }} records</p>
                    </div>
                    <a href="{{ route('documents.index') }}"
                        class="text-xs font-semibold text-white bg-university-red px-3 py-1.5 rounded-lg hover:opacity-90 transition">
                        View All →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                                <th class="px-6 py-3 text-left">Faculty</th>
                                <th class="px-6 py-3 text-left">Category</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @php
                            $statusColors = [
                                'submitted' => 'bg-yellow-100 text-yellow-800',
                                'reviewed'  => 'bg-blue-100 text-blue-800',
                                'approved'  => 'bg-green-100 text-green-800',
                                'rejected'  => 'bg-red-100 text-red-800',
                            ];
                            $colorMap = [
                                'blue'   => '#3b82f6', 'green'  => '#22c55e',
                                'yellow' => '#eab308', 'red'    => '#ef4444',
                                'purple' => '#a855f7', 'pink'   => '#ec4899',
                                'indigo' => '#6366f1', 'orange' => '#f97316',
                            ];
                            @endphp

                            @forelse($recentSubmissions as $i => $s)
                            <tr class="hover:bg-gray-50 transition-colors group"
                                style="animation: fadeInUp 0.4s ease {{ $i * 0.06 }}s forwards; opacity: 0;">
                                <td class="px-6 py-3.5 font-medium text-gray-800">
                                    <div class="flex items-center gap-2.5">
                                        <div class="h-8 w-8 rounded-full bg-university-red text-white text-xs flex items-center justify-center font-bold flex-shrink-0 shadow-sm">
                                            {{ strtoupper(substr($s->faculty_name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm">{{ $s->faculty_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5">
                                    @if($s->category)
                                    @php $hex = $colorMap[$s->category->color] ?? '#6b7280'; @endphp
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold"
                                        style="background-color: {{ $hex }}18; color: {{ $hex }}">
                                        {{ $s->category->name }}
                                    </span>
                                    @else
                                    <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$s->status] }}">
                                        {{ ucfirst($s->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 text-gray-400 text-xs">
                                    {{ $s->submission_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-3.5">
                                    <a href="{{ route('documents.edit', $s) }}"
                                        class="opacity-0 group-hover:opacity-100 transition px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 text-sm font-medium">No submissions yet</p>
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
            </div>
        </div>
        {{-- ── END TABLE ── --}}

        {{-- ── RIGHT COLUMN ── --}}
        <div class="flex flex-col gap-5 animate-fade-up-delay-4">

            {{-- Submissions by Category --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-base font-semibold text-gray-800">By Category</h3>
                    <a href="{{ route('categories.index') }}"
                        class="text-xs text-gray-400 hover:text-gray-600 transition">Manage →</a>
                </div>
                <div class="space-y-4">
                    @forelse($categoryStats as $cat)
                    @php $hex = $colorMap[$cat->color] ?? '#6b7280'; @endphp
                    <div class="cursor-pointer group" @click="openModal('category_{{ $cat->id }}')">
                        <div class="flex justify-between text-xs mb-1.5">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                    style="background-color: {{ $hex }}"></div>
                                <span class="text-gray-700 font-medium group-hover:text-gray-900 transition">
                                    {{ $cat->name }}
                                </span>
                            </div>
                            <span class="font-bold text-gray-700">{{ $cat->documents_count }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full progress-bar"
                                style="width: {{ $totalDocuments > 0 ? round(($cat->documents_count / $totalDocuments) * 100) : 0 }}%;
                                       background-color: {{ $hex }}">
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-4">No categories yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Status Breakdown --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Status Breakdown</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div @click="openModal('submitted')"
                        class="stat-card bg-yellow-50 border border-yellow-100 rounded-xl p-3.5 text-center cursor-pointer">
                        <p class="text-2xl font-bold text-yellow-600">{{ $submitted }}</p>
                        <p class="text-xs text-yellow-600 mt-1 font-medium">Submitted</p>
                    </div>
                    <div @click="openModal('reviewed')"
                        class="stat-card bg-blue-50 border border-blue-100 rounded-xl p-3.5 text-center cursor-pointer">
                        <p class="text-2xl font-bold text-blue-600">{{ $reviewed }}</p>
                        <p class="text-xs text-blue-600 mt-1 font-medium">Reviewed</p>
                    </div>
                    <div @click="openModal('approved')"
                        class="stat-card bg-green-50 border border-green-100 rounded-xl p-3.5 text-center cursor-pointer">
                        <p class="text-2xl font-bold text-green-600">{{ $approved }}</p>
                        <p class="text-xs text-green-600 mt-1 font-medium">Approved</p>
                    </div>
                    <div @click="openModal('rejected')"
                        class="stat-card bg-red-50 border border-red-100 rounded-xl p-3.5 text-center cursor-pointer">
                        <p class="text-2xl font-bold text-red-600">{{ $rejected }}</p>
                        <p class="text-xs text-red-600 mt-1 font-medium">Rejected</p>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('documents.create') }}"
                        class="flex items-center gap-3 px-4 py-3 bg-university-red text-white rounded-xl text-sm font-semibold hover:opacity-90 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Log New Submission
                    </a>
                    <a href="{{ route('categories.create') }}"
                        class="flex items-center gap-3 px-4 py-3 bg-gray-50 text-gray-700 border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-100 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5l5 5v11a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h2z" />
                        </svg>
                        Add Category
                    </a>
                    <a href="{{ route('documents.index') }}"
                        class="flex items-center gap-3 px-4 py-3 bg-gray-50 text-gray-700 border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-100 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h10" />
                        </svg>
                        View All Documents
                    </a>
                </div>
            </div>

        </div>
        {{-- ── END RIGHT COLUMN ── --}}

    </div>

    {{-- ── MODAL ── --}}
    <div x-show="modalOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center modal-backdrop bg-black/40"
        @click.self="modalOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.stop>

            {{-- Modal Header --}}
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center"
                        :class="modalData.iconBg">
                        <span x-text="modalData.icon" class="text-base"></span>
                    </div>
                    <h3 class="text-base font-bold text-gray-800" x-text="modalData.title"></h3>
                </div>
                <button @click="modalOpen = false"
                    class="text-gray-400 hover:text-gray-600 transition p-1 rounded-lg hover:bg-gray-100">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6">
                <div class="text-center mb-6">
                    <p class="text-5xl font-black mb-1" :class="modalData.countColor" x-text="modalData.count"></p>
                    <p class="text-sm text-gray-500" x-text="modalData.subtitle"></p>
                </div>

                {{-- Progress --}}
                <div class="mb-6">
                    <div class="flex justify-between text-xs text-gray-500 mb-2">
                        <span>Share of total submissions</span>
                        <span class="font-bold" x-text="`${modalData.percent}%`"></span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="h-2.5 rounded-full transition-all duration-700"
                            :class="modalData.barColor"
                            :style="`width: ${modalData.percent}%`">
                        </div>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-gray-800" x-text="modalData.count"></p>
                        <p class="text-xs text-gray-500 mt-0.5" x-text="modalData.label"></p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-lg font-bold text-gray-800" x-text="`${modalData.percent}%`"></p>
                        <p class="text-xs text-gray-500 mt-0.5">of total</p>
                    </div>
                </div>

                {{-- Action Button --}}
                <a :href="modalData.link"
                    class="block w-full text-center py-2.5 rounded-xl text-sm font-semibold text-white transition hover:opacity-90"
                    :class="modalData.btnColor">
                    <span x-text="modalData.action"></span>
                </a>
            </div>

        </div>
    </div>
    {{-- ── END MODAL ── --}}

</div>

@push('scripts')
<script>
function dashboard() {
    return {
        modalOpen: false,
        modalData: {},

        // Real values from PHP
        total:     {{ $totalDocuments }},
        submitted: {{ $submitted }},
        reviewed:  {{ $reviewed }},
        approved:  {{ $approved }},
        rejected:  {{ $rejected }},

        // Animated display values
        animatedTotal:     0,
        animatedSubmitted: 0,
        animatedApproved:  0,
        animatedRejected:  0,

        init() {
            this.$nextTick(() => {
                this.animateCount('animatedTotal',     this.total,     1000);
                this.animateCount('animatedSubmitted', this.submitted, 1000);
                this.animateCount('animatedApproved',  this.approved,  1000);
                this.animateCount('animatedRejected',  this.rejected,  1000);
            });
        },

        animateCount(prop, target, duration) {
            const steps  = 40;
            const step   = target / steps;
            const delay  = duration / steps;
            let current  = 0;
            const timer  = setInterval(() => {
                current += step;
                if (current >= target) {
                    this[prop] = target;
                    clearInterval(timer);
                } else {
                    this[prop] = Math.floor(current);
                }
            }, delay);
        },

        percent(val) {
            return this.total > 0 ? Math.round((val / this.total) * 100) : 0;
        },

        openModal(type) {
            const modals = {
                total: {
                    title:      'Total Submissions',
                    icon:       '📄',
                    iconBg:     'bg-gray-100',
                    count:      this.total,
                    countColor: 'text-gray-800',
                    subtitle:   'All document submissions recorded in the system',
                    percent:    100,
                    barColor:   'bg-gray-500',
                    label:      'Total Records',
                    btnColor:   'bg-gray-700',
                    action:     'View All Documents →',
                    link:       '{{ route("documents.index") }}',
                },
                submitted: {
                    title:      'Submitted',
                    icon:       '⏳',
                    iconBg:     'bg-yellow-50',
                    count:      this.submitted,
                    countColor: 'text-yellow-600',
                    subtitle:   'Documents awaiting review',
                    percent:    this.percent(this.submitted),
                    barColor:   'bg-yellow-400',
                    label:      'Awaiting Review',
                    btnColor:   'bg-yellow-500',
                    action:     'View Submitted Documents →',
                    link:       '{{ route("documents.index") }}?status=submitted',
                },
                reviewed: {
                    title:      'Reviewed',
                    icon:       '🔍',
                    iconBg:     'bg-blue-50',
                    count:      this.reviewed,
                    countColor: 'text-blue-600',
                    subtitle:   'Documents currently under review',
                    percent:    this.percent(this.reviewed),
                    barColor:   'bg-blue-400',
                    label:      'Under Review',
                    btnColor:   'bg-blue-500',
                    action:     'View Reviewed Documents →',
                    link:       '{{ route("documents.index") }}?status=reviewed',
                },
                approved: {
                    title:      'Approved',
                    icon:       '✅',
                    iconBg:     'bg-green-50',
                    count:      this.approved,
                    countColor: 'text-green-600',
                    subtitle:   'Documents that have been approved',
                    percent:    this.percent(this.approved),
                    barColor:   'bg-green-400',
                    label:      'Approved',
                    btnColor:   'bg-green-500',
                    action:     'View Approved Documents →',
                    link:       '{{ route("documents.index") }}?status=approved',
                },
                rejected: {
                    title:      'Rejected',
                    icon:       '❌',
                    iconBg:     'bg-red-50',
                    count:      this.rejected,
                    countColor: 'text-red-600',
                    subtitle:   'Documents that were rejected',
                    percent:    this.percent(this.rejected),
                    barColor:   'bg-red-400',
                    label:      'Rejected',
                    btnColor:   'bg-red-500',
                    action:     'View Rejected Documents →',
                    link:       '{{ route("documents.index") }}?status=rejected',
                },
            };

            this.modalData = modals[type] ?? modals['total'];
            this.modalOpen = true;
        },
    }
}
</script>
@endpush

</x-layouts.app>