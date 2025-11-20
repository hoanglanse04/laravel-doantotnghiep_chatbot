<ul class="h-full flex items-center justify-between">
    @foreach($items as $item)
        @php
            $isActive = url($item->url) == url()->current() ? 'active' : '';
            $icon = $item->icon ?? '';
        @endphp

        <li class="wow animate__animated animate__fadeInDown {{ $isActive }}" data-wow-delay="0.{{ $loop->iteration + 3 }}s">
            <a href="{{ url($item->url) }}" class="relative px-4 py-3 flex items-center uppercase space-x-1 text-[#fff2dc] hover:text-[#c7a97f] before:absolute before:bottom-0 before:left-1/2 before:w-0 before:h-[2px] before:bg-[#c7a97f] before:transition-all before:duration-300 hover:before:left-0 hover:before:w-full">
                {!! $icon !!}
                <span>{{ $item->name }}</span>
            </a>
            @if($item->children->count() > 0)
                <ul class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-md hidden group-hover:block">
                    @foreach($item->children as $child)
                        <li>
                            <a href="{{ url($child->url) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 barlow-condensed-regular">
                                {!! $child->icon !!}
                                {{ $child->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
