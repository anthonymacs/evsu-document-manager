<footer class="bg-university-red text-white py-8 border-t border-white/10 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Brand -->
            <a wire:navigate href="{{ route('home') }}" class="flex items-center space-x-3 hover:opacity-90 transition-opacity">
                <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center overflow-hidden shrink-0">
                    <img src="{{ asset('images/logo.jpg') }}" alt="EVSU Logo" class="h-full w-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold leading-none">EVSU Reader</span>
                    <span class="text-[10px] text-white/70 uppercase">Digital Library System</span>
                </div>
            </a>

            <!-- Copyright -->
            <div class="text-center md:text-right">
                <p class="text-sm font-medium text-white/90">
                    &copy; {{ date('Y') }} Eastern Visayas State University.
                </p>
                <p class="text-xs text-white/60 mt-1">
                    Developed by Reymart Calicdan and Antonio D. Macasa Jr.
                </p>
            </div>
        </div>
    </div>
</footer>