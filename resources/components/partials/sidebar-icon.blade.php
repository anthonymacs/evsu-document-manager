@props(['path'])

<svg {{ $attributes->merge(['class' => 'h-6 w-6 text-white flex-shrink-0']) }} fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-width="2" d="{{ $path }}" />
</svg>