<ul class="h-full flex items-center justify-between divide-x divide-gray-200">
    @foreach($items as $item)
        @php
            $isActive = url($item->url) == url()->current() ? 'active' : '';
            $icon = $item->icon ?? '';
        @endphp

        <li>
            <a href="{{ url($item->url ?? '') }}" class="px-2">
                {!! $icon !!}
                <span>{{ $item->name }}</span>
            </a>
        </li>
    @endforeach
</ul>
