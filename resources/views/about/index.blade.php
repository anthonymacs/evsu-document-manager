<x-layouts.app title="About">

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-up         { animation: fadeInUp 0.5s ease forwards; }
    .animate-fade-up-delay-1 { animation: fadeInUp 0.5s ease 0.1s forwards; opacity: 0; }
    .animate-fade-up-delay-2 { animation: fadeInUp 0.5s ease 0.2s forwards; opacity: 0; }
    .animate-fade-up-delay-3 { animation: fadeInUp 0.5s ease 0.3s forwards; opacity: 0; }
    .animate-fade-up-delay-4 { animation: fadeInUp 0.5s ease 0.4s forwards; opacity: 0; }

    .feature-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
</style>
@endpush

<div class="max-w-4xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8 animate-fade-up">
        <h2 class="text-2xl font-bold text-gray-800">About</h2>
        <p class="text-sm text-gray-500 mt-1">Learn what this system does and how to use it.</p>
    </div>

    {{-- What is this system? --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-5 animate-fade-up-delay-1">
        <div class="flex items-center gap-3 mb-4">
            <div class="bg-red-50 rounded-xl p-2.5">
                <svg class="h-5 w-5 text-university-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-800">What is the Faculty Document Manager?</h3>
        </div>

        <p class="text-sm text-gray-600 leading-relaxed mb-3">
            The <span class="font-semibold text-university-red">Faculty Document Manager</span> is an
            internal tool for logging and tracking faculty document submissions. It gives administrators
            one place to record submissions, update their status, and keep a reliable history of every action taken.
        </p>
        <p class="text-sm text-gray-600 leading-relaxed">
            It replaces manual, paper-based tracking with a simple digital workflow — so every submission
            is accounted for, easy to find, and properly documented.
        </p>
    </div>

    {{-- What it can do --}}
    <div class="mb-5 animate-fade-up-delay-2">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 px-1">What it can do</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            @foreach ([
                [
                    'color' => '#3b82f6',
                    'icon'  => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                    'title' => 'Dashboard Overview',
                    'desc'  => 'See a live count of all submissions broken down by category — at a glance, every time you log in.',
                ],
                [
                    'color' => '#22c55e',
                    'icon'  => 'M7 7h.01M7 3h5l5 5v11a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h2z',
                    'title' => 'Category Organization',
                    'desc'  => 'Submissions are grouped by category, making it easy to filter and find related records quickly.',
                ],
                [
                    'color' => '#f97316',
                    'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                    'title' => 'Status Tracking',
                    'desc'  => 'Each submission has a status — Submitted, Reviewed, Approved, or Rejected — that can be updated as it progresses.',
                ],
                [
                    'color' => '#a855f7',
                    'icon'  => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'Audit Trail',
                    'desc'  => 'Every action is recorded with a timestamp. Logs are read-only and cannot be deleted, ensuring a trustworthy history.',
                ],
            ] as $feature)
            <div class="feature-card bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex gap-4">
                <div class="flex-shrink-0 rounded-xl p-2.5 h-fit"
                    style="background-color: {{ $feature['color'] }}15">
                    <svg class="h-5 w-5" style="color: {{ $feature['color'] }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $feature['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800 mb-1">{{ $feature['title'] }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    {{-- How to Use --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-5 animate-fade-up-delay-3">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-6">How to Use</h3>

        <div class="space-y-5">
            @foreach ([
                [
                    'step'  => '1',
                    'color' => '#3b82f6',
                    'title' => 'Log a submission',
                    'desc'  => 'Click <strong>Log Submission</strong> on the Dashboard. Enter the faculty name, pick a category, set the date, and save.',
                ],
                [
                    'step'  => '2',
                    'color' => '#f97316',
                    'title' => 'Check the dashboard',
                    'desc'  => 'The summary cards update in real time. Click any category card to filter the table and see only that category\'s records.',
                ],
                [
                    'step'  => '3',
                    'color' => '#22c55e',
                    'title' => 'Update a record',
                    'desc'  => 'Hover over any row and click <strong>Edit</strong> to change the status or correct details. Changes are saved with a timestamp.',
                ],
                [
                    'step'  => '4',
                    'color' => '#a855f7',
                    'title' => 'View the audit log',
                    'desc'  => 'The audit log shows every action ever taken. It is read-only — nothing can be edited or removed from it.',
                ],
            ] as $i => $step)
            <div class="flex gap-4">
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white"
                        style="background-color: {{ $step['color'] }}">
                        {{ $step['step'] }}
                    </div>
                    @if ($i < 3)
                        <div class="w-px flex-1 mt-1" style="background-color: {{ $step['color'] }}25; min-height: 1.25rem;"></div>
                    @endif
                </div>
                <div class="pb-4">
                    <p class="text-sm font-semibold text-gray-800 mb-0.5">{{ $step['title'] }}</p>
                    <p class="text-sm text-gray-500 leading-relaxed">{!! $step['desc'] !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    {{-- Footer --}}
    <div class="text-center text-xs text-gray-400 pb-10 animate-fade-up-delay-4">
        <span class="font-medium text-gray-500">Faculty Document Manager</span>
        &mdash; For internal use only.
        <br>
        For access issues or concerns, contact your system administrator.
    </div>

</div>

</x-layouts.app>