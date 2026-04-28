@props([
    'document',
])

<a wire:navigate href="{{ route('home.documents.show', $document->slug) }}" 
   class="group block bg-white border border-slate-200 rounded-xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1.5 overflow-hidden">
    
    <!-- Thumbnail Area -->
    <div class="flex items-center justify-center h-44 bg-slate-50/70 p-4">
        <svg class="w-16 h-16 text-slate-300 transition-colors duration-300 group-hover:text-university-red" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
    </div>

    <!-- Content Area -->
    <div class="p-5">
        <div class="flex justify-between items-start">
            <p class="text-[11px] font-bold text-university-red uppercase tracking-widest">
                {{ $document->category->name ?? 'Uncategorized' }}
            </p>
            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-{{ $document->status->color() }}-100 text-{{ $document->status->color() }}-800 capitalize">
                {{ $document->status->label() }}
            </span>
        </div>

        <h3 class="mt-2 text-md font-bold text-slate-800 line-clamp-2 group-hover:text-university-red transition-colors" title="{{ $document->title }}">
            {{ $document->title }}
        </h3>

        <p class="mt-4 text-xs text-slate-500 border-t border-slate-100 pt-3">
            Published: {{ $document->created_at->diffForHumans() }}
        </p>
    </div>
</a>