<ul class="h-full flex items-center">
    @foreach($items as $k => $item)
        @php
            $isActive = $item->url == url()->current() ? 'active' : '';
            $icon = $item->icon ?? '';
        @endphp

        <li class="relative group {{ $isActive }}">
            <a href="{{ $item->url }}" class="text-sm font-medium text-gray-700 px-4 py-3 hover:text-indigo-500">
                {!! $icon !!}
                <span>{{ $item->name }}</span>
            </a>
            @if(!empty($item->children) && $item->children->count() > 0)
                @include('menu.include_menu', ['item' => $item])
            @endif
        </li>
    @endforeach
</ul>
