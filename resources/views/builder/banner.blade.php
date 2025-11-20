{{-- Banner chính --}}
<div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 lg:gap-x-4 gap-y-4 lg:mt-6 mt-4">
    @if ($items->isNotEmpty())
        {{-- Banner lớn bên trái --}}
        <div class="col-span-2 relative aspect-[10/7] rounded-md overflow-hidden">
            <img src="{{ image($items[0]->image) }}" alt="{{ $items[0]->name }}" class="w-full h-full object-cover absolute inset-0">
        </div>

        {{-- 3 banner nhỏ bên phải --}}
        <div class="col-span-1 flex flex-col gap-4 h-full justify-between min-h-[480px] lg:min-h-[calc(100vw*3/5*1/3)]">
            @foreach ($items->slice(1, 3) as $item)
                <a href="{{ $item->url }}" class="relative rounded-md overflow-hidden flex-1" aria-label="banner right">
                    <img src="{{ image($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover absolute inset-0">
                </a>
            @endforeach
        </div>
    @endif
</div>
