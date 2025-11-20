<ul class="">
    @foreach($items as $k => $item)
        @php
            $icon = $item->icon ?? '';
        @endphp

        <li>
            <a href="{{ $item->url }}" class="block text-sm py-1 text-[#e4bf6d] hover:text-[#bdaf95]">
                {!! $icon !!}
                <span>{{ $item->name }}</span>
            </a>
        </li>
    @endforeach
</ul>
