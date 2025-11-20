@props([
    'colSpan' => 'col-span-6 lg:col-span-4',
    'item' => ''
])

<div class="{{ $colSpan }} relative bg-white rounded-lg overflow-hidden border border-gray-200 group transition mx-4">
    {{-- Link trùm (dùng aria-label hoặc sr-only thay vì opacity-0) --}}
    <a href="{{ route('post.article', ['slug' => $item->slug]) }}"
       class="absolute z-10 w-full h-full top-0 left-0"
       aria-label="{{ $item->title }}">
    </a>

    <div class="relative aspect-[4/3]">
        {{-- Ảnh với lazyload chuẩn & dùng thumbnail (md) từ Resizable --}}
        <img
            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 lazyload"
            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
            data-src="{{ $item->thumbnail('md') }}"
            alt="{{ $item->title }}"
            loading="lazy"
        />
        <span class="absolute -bottom-3 left-6 bg-red-600 text-white uppercase text-xs font-semibold px-3 py-1.5 rounded">
            {{ \Carbon\Carbon::parse($item->created_at)->locale(config('app.locale'))->translatedFormat('F j, Y') }}
        </span>
    </div>

    <div class="p-4 mt-2">
        <h3 class="font-semibold text-base md:text-lg text-gray-900 mb-1 line-clamp-2">
            {{ $item->title }}
        </h3>
        <p class="text-sm text-gray-600 line-clamp-3">
            {{ strip_tags($item->excerpt ?? $item->description ?? $item->title) }}
        </p>
        <a href="{{ route('post.article', ['slug' => $item->slug]) }}" class="uppercase mt-3 inline-block text-sm text-gray-700 font-semibold underline">
            Xem thêm
        </a>
    </div>
</div>
