@props([
    'type' => 'button',
    'size' => 'md', // xs, sm, md, lg, xl
    'variant' => 'flat', // flat, bordered, faded, underlined
    'color' => 'default', // default, primary, secondary, success, warning, danger
    'radius' => 'md', // none, sm, md, lg, full
    'isDisabled' => false,
    'isReadOnly' => false,
    'isInvalid' => false,
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

    $colors = [
        'default' => 'bg-gray-200 text-gray-800 hover:bg-gray-300',
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'secondary' => 'bg-gray-600 text-white hover:bg-gray-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'warning' => 'bg-yellow-600 text-white hover:bg-yellow-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700'
    ];

    $variants = [
        'flat' => '',
        'bordered' => 'border-2',
        'faded' => 'opacity-80',
        'underlined' => 'border-b-2'
    ];

    $radiusClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'full' => 'rounded-full'
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $colorClass = $colors[$color] ?? $colors['default'];
    $variantClass = $variants[$variant] ?? $variants['flat'];
    $radiusClass = $radiusClasses[$radius] ?? $radiusClasses['md'];
    $disabledClass = $isDisabled ? 'opacity-50 cursor-not-allowed' : '';
    $invalidClass = $isInvalid ? 'border-red-500' : '';

    // Hợp nhất các class
    $mergedClass = implode(' ', [
        'font-medium transition cursor-pointer',
        $sizeClass,
        $colorClass,
        $variantClass,
        $radiusClass,
        $disabledClass,
        $invalidClass,
        $class
    ]);
@endphp

<button type="{{ $type }}" class="{{ $mergedClass }}" {{ $isDisabled ? 'disabled' : '' }} {{ $attributes }}>
    {{ $slot }}
</button>
