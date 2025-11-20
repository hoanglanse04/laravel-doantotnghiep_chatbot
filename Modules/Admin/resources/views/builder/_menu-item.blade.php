<li class="dd-item" data-id="{{ $item->id }}">
    <div class="dd-data flex items-center justify-between">
        <div class="dd-handle w-full flex items-center justify-between text-xs">
            <div>
                <div>{{ $item->name }}</div>
                <span class="text-gray-500">{{ $item->url ?? '#' }}</span>
            </div>
        </div>
        <div class="flex items-center justify-between space-x-2 px-2">
            <a href="{{ route('admin.builder-item.edit', $item->id) }}" class="text-xs px-3 py-2 hover:bg-gray-100 rounded-lg min-w-max">Chỉnh sửa</a>
            <a href="#" class="text-xs px-3 py-2 hover:bg-gray-100 rounded-lg"
               uk-toggle="target: #delete-menu-modal"
               onclick="setDeleteMenuId({{ $item->id }})">
               Xoá
            </a>
        </div>
    </div>

    @if ($item->children && $item->children->count() > 0)
        <ol class="dd-list space-y-2 !mt-2">
            @foreach ($item->children as $child)
                @include('admin::builder._menu-item', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>
