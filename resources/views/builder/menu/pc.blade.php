<ul class="h-full flex items-center justify-between">
    @foreach($items as $item)
        @php
            $isActive = url($item->url) == url()->current() ? 'active' : '';
            $icon = $item->icon ?? '';
        @endphp

        <li class="{{ $isActive }} group relative">
            <a href="{{ url($item->url) }}" class="px-4 py-4 hover:text-[#ef233c] font-medium flex items-center space-x-2">
                <span>{{ $item->name }}</span>
                @if($item->children->count() > 0)
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19 9l-7 6l-7-6"/></svg>
                @endif
            </a>
            @if($item->children->count() > 0)
                <ul class="absolute z-50 left-0 w-48 bg-white shadow-md rounded-md hidden group-hover:block overflow-hidden">
                    @foreach($item->children as $child)
                        <li>
                            <a href="{{ url($child->url ?? '#') }}" class="block font-medium px-4 py-2 text-gray-700 hover:bg-gray-100">
                                {{ $child->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
