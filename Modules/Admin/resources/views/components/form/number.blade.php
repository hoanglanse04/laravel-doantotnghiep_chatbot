@props([
    'name',
    'value' => '',
    'label' => '',
    'size' => 'md', // xs, sm, md, lg, xl
    'variant' => 'flat', // flat, bordered, faded, underlined
    'radius' => 'md', // none, sm, md, lg, full
    'isDisabled' => false,
    'isInvalid' => false,
    'class' => ''
])

@php
    $sizes = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-md',
        'lg' => 'text-lg',
        'xl' => 'text-xl'
    ];

    $variants = [
        'flat' => '',
        'bordered' => 'border-2 border-gray-400',
        'faded' => 'opacity-80',
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
        'rounded-full border-gray-300',
        $sizeClass,
        $variantClass,
        $radiusClass,
        $disabledClass,
        $invalidClass,
        $class
    ]);
@endphp

<label class="flex items-center space-x-2">
    <input type="radio" name="{{ $name }}" value="{{ $value }}" {{ old($name) == $value ? 'checked' : '' }} class="{{ $mergedClass }}">
    <span class="{{ $sizeClass }}">{{ $label }}</span>
</label>
