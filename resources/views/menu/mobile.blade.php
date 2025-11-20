<ul class="h-full">
    @foreach($items as $k => $item)
        <li>
            <a href="{{ url($item['url']) }}" class="py-2 px-4 block h-full text-noyer-200 hover:text-noyer-300 transition">
                <span class="font-semibold text-bmkblue-500">{{ $item['name'] }}</span>
            </a>
            @if(isset($item->hasmany_menu_item) && $item->hasmany_menu_item->count() > 0)
                @include('menu.include_menu', ['item' => $item])
            @endif
        </li>
    @endforeach
</ul>