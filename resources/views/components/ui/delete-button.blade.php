@props([
    'action',           // form action URL e.g. route('categories.destroy', $cat)
    'name'  => 'item',  // resource name shown in modal
    'label' => 'Delete',
    'size'  => 'sm',
])

@php
$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-6 py-3 text-base',
];
$sizeClass = $sizes[$size] ?? $sizes['sm'];
@endphp

<span x-data>
    <button type="button"
        class="inline-flex items-center justify-center gap-1.5 font-semibold transition rounded-lg active:scale-95 bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 {{ $sizeClass }}"
        @click="$dispatch('show-confirmation', {
            title: 'Delete Item',
            message: 'Are you sure you want to delete {{ addslashes($name) }}? This action cannot be undone.',
            confirmText: 'Delete',
            cancelText: 'Cancel',
            variant: 'danger',
            onConfirm: () => $refs['form_{{ md5($action) }}'].submit()
        })">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        {{ $label }}
    </button>

    {{-- Hidden form that gets submitted on confirm --}}
    <form x-ref="form_{{ md5($action) }}"
        method="POST"
        action="{{ $action }}"
        class="hidden">
        @csrf
        @method('DELETE')
    </form>
</span>