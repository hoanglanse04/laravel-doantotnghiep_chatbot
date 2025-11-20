@props([
    'name',
    'type' => 'text',
    'placeholder' => '',
    'description' => '',
    'value' => '',
    'size' => 'md', // xs, sm, md, lg, xl
    'variant' => 'flat', // flat, bordered, faded, underlined
    'radius' => 'md', // none, sm, md, lg, full
    'isDisabled' => false,
    'isReadOnly' => false,
    'isInvalid' => $errors->has($name), // Kiểm tra lỗi validation
    'class' => '',
    'startContent' => null, // Slot cho icon hoặc component phía trước
    'endContent' => null, // Slot cho icon hoặc component phía sau
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

    $mergedClass = trim(implode(' ', [
        'flex items-center w-full',
        $sizes[$size] ?? $sizes['md'],
        $variants[$variant] ?? $variants['flat'],
        $radiusClasses[$radius] ?? $radiusClasses['md'],
        $isDisabled ? 'opacity-50 cursor-not-allowed' : '',
        $isInvalid ? 'border-red-500' : '',
        $class
    ]));
@endphp

<div class="relative {{ $class }}">
    @if ($startContent)
        {!! $startContent !!}
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        class="w-full {{ $mergedClass }}
            @if($startContent) pl-10 @endif
            @if($endContent) pr-10 @endif"
        {{ $isDisabled ? 'disabled' : '' }}
        {{ $isReadOnly ? 'readonly' : '' }}
        {{ $attributes }}
    />
    @if ($description)
        <p class="text-xs mt-0.5 text-gray-500">{{ $description }}</p>
    @endif

    @if ($errors->has($name))
        <p class="text-red-500 text-xs mt-0.5">{{ $errors->first($name) }}</p>
    @endif

    @if ($endContent)
        {!! $endContent !!}
    @endif
</div>
