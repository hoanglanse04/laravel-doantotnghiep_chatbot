@props([
    'name',
    'options' => [],
    'selected' => null,
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

    $sizeKey = is_string($size) && array_key_exists($size, $sizes) ? $size : 'md';
    $sizeClass = $sizes[$sizeKey];
    $variantKey = (is_string($variant) && array_key_exists($variant, $variants)) ? $variant : 'flat';
    $variantClass = $variants[$variantKey];
    $radiusKey = (is_string($radius) && array_key_exists($radius, $radiusClasses)) ? $radius : 'md';
    $radiusClass = $radiusClasses[$radiusKey];
    $disabledClass = $isDisabled ? 'opacity-50 cursor-not-allowed' : '';
    $invalidClass = $isInvalid ? 'border-red-500' : '';

    // Hợp nhất các class
    $mergedClass = implode(' ', [
        $sizeClass,
        $variantClass,
        $radiusClass,
        $disabledClass,
        $invalidClass,
        $class
    ]);
@endphp

<select
    name="{{ $name }}"
    class="{{ $mergedClass }}"
    {{ $isDisabled ? 'disabled' : '' }}
>
    @foreach ($options as $key => $option)
        @if (is_array($option))
            <optgroup label="{{ $key }}">
                @foreach ($option as $subKey => $subValue)
                    <option value="{{ $subKey }}" {{ (string) $selected === (string) $subKey ? 'selected' : '' }}>
                        {{ $subValue }}
                    </option>
                @endforeach
            </optgroup>
        @else
            <option value="{{ $key }}" {{ (string) $selected === (string) $key ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endif
    @endforeach
</select>
