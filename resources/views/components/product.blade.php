@props([
    'colSpan' => 'col-span-6 lg:col-span-4 mx-3',
    'item' => '',
])

@php
    use Illuminate\Support\Arr;

    $images = is_array($item->multiple_image) ? $item->multiple_image : json_decode($item->multiple_image, true);

    $image1 = Arr::get($images, 0);
    $image2 = Arr::get($images, 1);
@endphp

<div class="{{ $colSpan }} cursor-pointer overflow-hidden group rounded-lg border border-gray-200 relative">
    <a href="{{ route('product.article', ['slug' => $item->slug]) }}" class="block pointer-events-none">
        <div class="relative aspect-[5/6] overflow-hidden bg-white pointer-events-auto">
            @if ($image1)
                <img class="w-full h-full object-cover transition-opacity duration-500 absolute top-0 left-0 z-10 lazyload"
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    data-src="{{ $item->getThumbnail($image1, 'md') }}" loading="lazy" alt="{{ $item->name }}">
            @endif

            @if ($image2)
                <img class="w-full h-full object-cover transition-opacity duration-500 opacity-0 group-hover:opacity-100 absolute top-0 left-0 z-20 lazyload"
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    data-src="{{ $item->getThumbnail($image2, 'md') }}" loading="lazy" alt="{{ $item->name }} hover">
            @endif
        </div>

        <div class="lg:p-4 p-2 pointer-events-auto">
            <div class="text-xs font-medium lg:min-h-10 lg:text-sm line-clamp-2 text-gray-600">
                {{ $item->name }}
            </div>

            <p class="text-red-600 w-full lg:text-[16px] text-sm">
                @if (empty($item->price) || $item->price == 0)
                    <p class="text-lg text-[#ef233c] font-semibold max-w-max">Liên hệ</p>
                @elseif ($item->discount_price <= 0)
                    <span>{{ number_format($item->price, 0, '.', '.') }}đ</span>
                @else
                    <span>{{ number_format($item->final_price, 0, '.', '.') }}đ</span>
                    <span
                        class="line-through text-sm text-gray-400 ml-2">{{ number_format($item->price, 0, '.', '.') }}đ</span>
                @endif

            </p>
        </div>
    </a>

    {{-- Nút thêm vào giỏ ngoài thẻ <a> để không bị bao phủ --}}
    <div class="lg:px-4 px-2 lg:pb-4 pb-2">
        <a href="#"
            class="add-to-cart line-clamp-2 text-gray-600 rounded-md uppercase lg:text-[13px] text-xs text-center mt-2 block lg:px-4 px-2 py-2 bg-gray-200 group-hover:bg-[#ef233c] group-hover:text-white"
            data-id="{{ $item->id }}">
            Thêm vào giỏ hàng
        </a>
    </div>
</div>
