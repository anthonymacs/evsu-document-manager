@props(['paginator'])

@if ($paginator->hasPages())
    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-xs text-gray-500 font-medium">
            Showing
            <span class="text-gray-900 font-bold">{{ $paginator->firstItem() ?? 0 }}</span>
            to
            <span class="text-gray-900 font-bold">{{ $paginator->lastItem() ?? 0 }}</span>
            of
            <span class="text-gray-900 font-bold">{{ $paginator->total() }}</span>
            entries
        </p>

        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <button disabled class="px-3 py-1.5 text-xs font-bold text-gray-300 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                    Prev
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-3 py-1.5 text-xs font-bold text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Prev
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <button class="px-3 py-1.5 text-xs font-bold text-white bg-university-red rounded-lg shadow-sm">
                        {{ $page }}
                    </button>
                @else
                    <a href="{{ $url }}"
                        class="px-3 py-1.5 text-xs font-bold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-3 py-1.5 text-xs font-bold text-gray-500 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Next
                </a>
            @else
                <button disabled class="px-3 py-1.5 text-xs font-bold text-gray-300 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                    Next
                </button>
            @endif
        </div>
    </div>
@endif