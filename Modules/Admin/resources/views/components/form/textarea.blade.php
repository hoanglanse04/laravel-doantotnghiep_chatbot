@props([
    'name',
    'placeholder' => '',
    'value' => '',
    'rows' => 3,
    'size' => 'md', // xs, sm, md, lg, xl
    'variant' => 'flat', // flat, bordered, faded, underlined
    'radius' => 'md', // none, sm, md, lg, full
    'isDisabled' => false,
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

    $variants = [
        'flat' => 'bg-white border-2 border-solid border-gray-200',
        'bordered' => 'border-2 border-gray-400',
        'faded' => 'bg-gray-100 border-2 border-gray-300',
        'underlined' => 'border-b-2 border-gray-400 bg-transparent'
    ];

    $radiusClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'full' => 'rounded-full'
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClass = $variants[$variant] ?? $variants['flat'];
    $radiusClass = $radiusClasses[$radius] ?? $radiusClasses['md'];
    $disabledClass = $isDisabled ? 'opacity-50 cursor-not-allowed' : '';
    $invalidClass = $isInvalid ? 'border-red-500' : '';

    // Hợp nhất các class
    $mergedClass = implode(' ', [
        'w-full',
        $sizeClass,
        $variantClass,
        $radiusClass,
        $disabledClass,
        $invalidClass,
        $class
    ]);
@endphp

<textarea
    name="{{ $name }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    class="{{ $mergedClass }}"
    {{ $isDisabled ? 'disabled' : '' }}
>{{ old($name, $value) }}</textarea>
