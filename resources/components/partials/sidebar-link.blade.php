@props([
'href',
'icon',
'label',
'route' => null,
])

@php
$isActive = $route ? request()->routeIs($route) : false;
@endphp

<a
    href="{{ $href }}"
    wire:navigate
    {{ $attributes->merge([
        'class' => 'flex items-center py-3 px-4 mb-2 rounded-lg border-l-4 transition-all duration-200 hover:opacity-80 ' . 
                   ($isActive ? 'border-white font-semibold' : 'border-transparent')
    ]) }}>
    {!! $icon !!}

    <span x-show="!sidebarCollapsed" x-transition class="ml-3">
        {{ $label }}
    </span>
</a>