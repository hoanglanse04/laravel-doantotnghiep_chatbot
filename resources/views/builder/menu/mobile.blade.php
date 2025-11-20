<ul id="menuMain" class="space-y-3 text-sm text-gray-700 hidden">
    @foreach($items as $k => $item)
        <li class="group relative">
            <a href="{{ url($item->url) }}" class="py-1 hover:text-[#ef233c] font-medium flex items-center space-x-2">
                <span>{{ $item->name }}</span>
            </a>
        </li>
    @endforeach
</ul>
