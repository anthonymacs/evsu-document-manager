{{-- resources/views/components/partials/sidebar.blade.php --}}

<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-[25] md:hidden" style="background: none;"
    aria-hidden="true">
</div>

<aside x-show="sidebarOpen"
    x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'"
    class="bg-university-red text-white fixed md:static inset-y-0 left-0 z-30 overflow-y-auto transition-all duration-300 shadow-lg flex flex-col">

    {{-- Logo --}}
    <a href="{{ route('homepage') }}"
        class="flex items-center justify-center h-20 border-b border-red-900 flex-shrink-0 hover:bg-black/10 transition-colors duration-200">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.jpg') }}" alt="EVSU Logo" class="w-12 h-12"
                style="border-radius: 50%; object-fit: cover; border: 2px solid rgba(255, 255, 255, 0.3); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
            <span x-show="!sidebarCollapsed" x-transition class="text-2xl font-bold">
                DocHub
            </span>
        </div>
    </a>

    <nav class="mt-6 px-3 flex-1 overflow-y-auto pb-20">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard.index') }}"
            class="flex items-center py-3 px-4 mb-2 rounded-lg border-l-4 transition-all duration-200 hover:opacity-80
                {{ request()->routeIs('dashboard*') ? 'border-white font-semibold bg-black/10' : 'border-transparent' }}">
            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition class="ml-3">Dashboard</span>
        </a>

        {{-- Categories --}}
        <a href="{{ route('categories.index') }}"
            class="flex items-center py-3 px-4 mb-2 rounded-lg border-l-4 transition-all duration-200 hover:opacity-80
                {{ request()->routeIs('categories.*') ? 'border-white font-semibold bg-black/10' : 'border-transparent' }}">
            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition class="ml-3">Categories</span>
        </a>

        {{-- Documents --}}
        <a href="{{ route('documents.index') }}"
            class="flex items-center py-3 px-4 mb-2 rounded-lg border-l-4 transition-all duration-200 hover:opacity-80
        {{ request()->routeIs('documents.*') ? 'border-white font-semibold bg-black/10' : 'border-transparent' }}">
            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586l5.414 5.414V19a2 2 0 01-2 2z" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition class="ml-3">Documents</span>
        </a>

        {{-- Audit Logs --}}
        <a href="{{ route('audit-logs.index') }}"
            class="flex items-center py-3 px-4 mb-2 rounded-lg border-l-4 transition-all duration-200 hover:opacity-80
                {{ request()->routeIs('audit-logs.*') ? 'border-white font-semibold bg-black/10' : 'border-transparent' }}">
            <svg class="h-6 w-6 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span x-show="!sidebarCollapsed" x-transition class="ml-3">Audit Logs</span>
        </a>

    </nav>

    <div class="border-t border-red-900 p-4 flex-shrink-0">
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="w-full text-sm text-white font-medium opacity-80 hover:opacity-100 transition">
            <span x-show="!sidebarCollapsed">Collapse</span>
            <span x-show="sidebarCollapsed">›</span>
        </button>
    </div>
</aside>