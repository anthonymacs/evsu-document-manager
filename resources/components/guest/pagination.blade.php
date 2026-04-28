@if ($paginator->hasPages())
    <nav class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6"
         aria-label="Pagination">
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-medium">{{ $paginator->total() }}</span>
                results
            </p>
        </div>
        <div class="flex flex-1 justify-between sm:justify-end">
            <!-- Previous Button -->
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-400 ring-1 ring-inset ring-gray-300 cursor-not-allowed">
                    Previous
                </span>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled"
                        class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Previous
                </button>
            @endif

            <!-- Page Numbers -->
            <div class="hidden sm:flex items-center mx-4 space-x-2">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="relative z-10 inline-flex items-center bg-university-red/10 px-4 py-2 text-sm font-semibold text-university-red"
                                      aria-current="page">{{ $page }}</span>
                            @else
                                <button wire:click="gotoPage({{ $page }})"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            <!-- Next Button -->
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled"
                        class="relative ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Next
                </button>
            @else
                <span class="relative ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-400 ring-1 ring-inset ring-gray-300 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
    </nav>
@endif