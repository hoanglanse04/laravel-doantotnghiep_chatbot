@php
    $index = $options['index'] ?? 0;
    $item = $items[$index] ?? null;
@endphp

@if ($item)
    <section class="max-w-7xl mx-auto px-4 relative overflow-hidden mb-12">
        <a href="{{ $item->url }}" aria-label="ads website" class="absolute z-20 top-0 left-0 w-full h-full"></a>
        <img class="object-cover w-full h-[200px] rounded-md lazyload" data-src="{{ image($item->image) }}"
            alt="{{ $item->name }}">
        <div class="max-w-2xl absolute right-10 top-1/2 transform -translate-y-1/2 text-white mx-4">
            <p class="max-w-max text-white px-3 py-1 rounded-full uppercase bg-red-600">{{ $item->name }}</p>
            <p class="text-3xl">
                {{ collect($item->custom_fields)->firstWhere('label', 'Mô tả')['value'] ?? '' }}
            </p>
        </div>
    </section>
@endif
