@props([
    'name',
    'size' => 'sm',
    'class' => ''
])

@php
    $sizes = [
        'xs' => 'text-xs px-2 py-1',
        'sm' => 'text-sm px-3 py-1.5',
        'md' => 'text-sm px-3 py-2',
        'lg' => 'text-lg px-4 py-3',
        'xl' => 'text-lg px-4 py-4'
    ];

    $sizeClass = ($sizes[$size] ?? $sizes['sm']) . ' ' . $class;
@endphp

<input
    type="file"
    name="{{ $name }}"
    class="border px-3 py-1 rounded-lg {{ $sizeClass }}"
    {{ $attributes }}
>
