@if(isset($item->hasmany_menu_item))
    <ul class="sub-menu hidden absolute z-10 bg-white rounded-md w-72 ">
        @foreach($item->hasmany_menu_item as $kk => $sub)
            <li class="relative">
                <a href="{{ $sub['url'] }}" class="py-2 px-4 block hover:bg-gray-200 hover:text-white transition">
                    {!! $sub['icon'] !!}
                    {{ $sub['name'] }}
                </a>
                @if(!$sub->children->isEmpty())
                    @include('menu.pcsub', [ 'item' => $sub])
                @endif
            </li>
        @endforeach
    </ul>
@endif
