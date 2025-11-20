@props([
    'icon' => '',
    'title' => '',
    'description' => '',
    'headingTag' => 'h2',
    'textColor' => 'text-gray-800',
])

<div class="space-y-4 py-4 mb-4">
    @if ($icon)
        <div class="flex justify-center fill-current text-gray-800 wow animate__animated animate__fadeInDown">
            {{ $icon }}
        </div>
    @endif

    <{{ $headingTag }} class="lg:text-3xl text-2xl italic font-semibold text-center {{ $textColor }} wow animate__animated animate__fadeInDown">
        {{ $title }}
    </<?php echo e($headingTag); ?>>

    <p class="text-sm {{ $textColor ?? "text-gray-800" }} italic text-center max-w-xl mx-auto lg:w-full w-10/12 line-clamp-3 wow animate__animated animate__fadeInDown">
        {{ $description }}
    </p>
</div>
