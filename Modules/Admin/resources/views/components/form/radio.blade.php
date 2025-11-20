📂 **Modules/Admin/Resources/views/components/radio.blade.php**
```blade
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

    $mergedClass = trim(implode(' ', array_filter([
        'rounded-full border-gray-300',
        $sizes[$size] ?? $sizes['md'],
        $variants[$variant] ?? $variants['flat'],
        $radiusClasses[$radius] ?? $radiusClasses['md'],
        $isDisabled ? 'opacity-50 cursor-not-allowed' : '',
        $isInvalid ? 'border-red-500' : '',
        $class
    ])));
@endphp

<label class="flex items-center space-x-2">
    <input type="radio" name="{{ $name }}" value="{{ $value }}" {{ old($name) == $value ? 'checked' : '' }} class="{{ $mergedClass }}">
    <span class="{{ $sizes[$size] ?? $sizes['md'] }}">{{ $label }}</span>
</label>
