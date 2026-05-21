<x-layouts.app title="Database Backups">

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up         { animation: fadeInUp 0.4s ease forwards; }
    .animate-fade-up-delay-1 { animation: fadeInUp 0.4s ease 0.08s forwards; opacity: 0; }
    .animate-fade-up-delay-2 { animation: fadeInUp 0.4s ease 0.16s forwards; opacity: 0; }
</style>
@endpush

{{-- Header --}}
<div class="flex flex-wrap justify-between items-start gap-4 mb-8 animate-fade-up">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Database Backups</h2>
        <p class="text-sm text-gray-500 mt-1">Manage and restore your database backups. Only the last 7 are kept.</p>
    </div>

    {{-- Manual Backup Button --}}
    <form method="POST" action="{{ route('backup.store') }}">
        @csrf
        <button type="submit"
            class="bg-university-red text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2 shadow-sm">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
            </svg>
            Create Backup Now
        </button>
    </form>
</div>

{{-- Flash Messages --}}
@if (session('success'))
    <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl animate-fade-up">
        <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl animate-fade-up">
        <svg class="h-5 w-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
@endif

{{-- Backup Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-up-delay-1">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-base font-semibold text-gray-800">Available Backups</h3>
            <p class="text-xs text-gray-400 mt-0.5">{{ $backups->count() }} backup{{ $backups->count() !== 1 ? 's' : '' }} found</p>
        </div>
    </div>

    @if ($backups->isEmpty())
        <div class="px-6 py-16 text-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                </div>
                <p class="text-gray-400 text-sm font-medium">No backups found.</p>
                <p class="text-gray-400 text-xs">Use the "Create Backup Now" button to create your first backup.</p>
            </div>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Filename</th>
                        <th class="px-6 py-3 text-left">Size</th>
                        <th class="px-6 py-3 text-left">Date Created</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($backups as $i => $backup)
                        <tr class="hover:bg-gray-50 transition-colors group"
                            style="animation: fadeInUp 0.35s ease {{ $i * 0.04 }}s forwards; opacity: 0;">
                            <td class="px-6 py-3.5 text-gray-400 text-xs font-mono">{{ $i + 1 }}</td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7M4 7h16M4 7l2-3h12l2 3"/>
                                        </svg>
                                    </div>
                                    <span class="font-mono text-xs text-gray-700">{{ $backup['filename'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-gray-500 text-xs">{{ $backup['size'] }}</td>
                            <td class="px-6 py-3.5 text-gray-500 text-xs whitespace-nowrap">{{ $backup['date'] }}</td>
                            <td class="px-6 py-3.5 text-center">
                                <form method="POST" action="{{ route('backup.restore') }}"
                                    onsubmit="return confirm('Restore from {{ $backup['filename'] }}?\n\nThis will overwrite ALL current data and cannot be undone.')">
                                    @csrf
                                    <input type="hidden" name="filename" value="{{ $backup['filename'] }}">
                                    <button type="submit"
                                        class="opacity-60 group-hover:opacity-100 transition px-3 py-1.5 text-xs font-semibold bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100">
                                        Restore
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 border-t border-gray-50">
            <p class="text-xs text-gray-400">
                Backups are created automatically every time the app starts. Only the last 7 are kept.
            </p>
        </div>
    @endif
</div>

</x-layouts.app>