@props([
    'id' => uniqid(),
])

<svg {{ $attributes->merge(['class' => 'w-100 h-100']) }} fill="none" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <pattern id="pattern-{{ $id }}" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
            {{-- We use currentColor so you can control the pattern color using Bootstrap text utilities like .text-light or .text-secondary --}}
            <path d="M-1 5L5 -1M3 9L8.5 3.5" stroke="currentColor" stroke-width="0.5" stroke-opacity="0.2"></path>
        </pattern>
    </defs>
    <rect stroke="none" fill="url(#pattern-{{ $id }})" width="100%" height="100%"></rect>
</svg>
