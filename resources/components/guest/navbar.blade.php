<nav class="bg-university-red border-b border-white/10 sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 sm:h-20">
            <!-- Logo -->
            <a wire:navigate href="{{ route('home') }}"
                class="flex items-center space-x-2 sm:space-x-4 hover:opacity-90 transition-opacity min-w-0">
                <div
                    class="h-9 w-9 sm:h-12 sm:w-12 rounded-full bg-white flex items-center justify-center overflow-hidden shadow-lg border-2 border-white/20 shrink-0">
                    <img src="{{ asset('images/logo.jpg') }}" alt="EVSU Logo" class="h-full w-full object-cover">
                </div>
                <div class="flex flex-col justify-center min-w-0">
                    <h1 class="text-base sm:text-xl font-bold text-white tracking-wide leading-none truncate">EVSU Reader</h1>
                    <span class="text-[10px] sm:text-[11px] text-white/80 uppercase tracking-wider mt-1 truncate">School of Engineering</span>
                </div>
            </a>

            <!-- Auth Buttons -->
            <div class="shrink-0 ml-2 sm:ml-0">
                @auth
                    @php $user = auth()->user(); @endphp

                    @if ($user->is_approved && !$user->is_suspended)
                        @php
                            $intendedRoute = match (true) {
                                $user->isSuperAdmin(), $user->isAdmin() => route('dashboard.index'),
                                default => route('documents.index'),
                            };
                        @endphp
                        <div class="flex items-center gap-2 sm:gap-3">
                            <a wire:navigate href="{{ $intendedRoute }}"
                                class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-2.5 bg-white text-university-red rounded-lg font-bold text-xs sm:text-sm hover:shadow-xl transition-all duration-300 hover:scale-105 whitespace-nowrap">
                                Dashboard
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1 sm:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                            <livewire:home.logout />
                        </div>
                    @else
                        <livewire:home.logout />
                    @endif
                @else
                    <a wire:navigate href="{{ route('login') }}"
                        class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-2.5 bg-white text-university-red rounded-lg font-bold text-xs sm:text-sm hover:shadow-xl transition-all duration-300 hover:scale-105 whitespace-nowrap">
                        Login
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1 sm:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>