@extends('admin::layouts.master')
@section('title', 'Chi tiết Builder')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/nestable/nestable.min.css') }}" />
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <div class="relative group flex items-center">
            <a class="text-sm text-gray-500 dark:text-gray-800" href="{{ route('admin.builder.index') }}">
                <span>Builder</span>
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-2 fill-current text-gray-600" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path>
            </svg>
            <a href="{{ route('admin.builder.show', ['builder' => $menu->id]) }}" class="text-sm text-gray-500 dark:text-gray-800">
                {{ $menu->name }}
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 mx-2 fill-current text-gray-600" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path></svg>
            <span class="text-sm text-gray-500 dark:text-gray-800">Chi tiết</span>
        </div>
        <a class="text-sm text-white font-medium bg-[#56a661] hover:shadow-md transition px-6 py-2.5 rounded-full cursor-pointer" href="{{ route('admin.builder-item.create', ['menu_id' => $menu->id]) }}">
            Thêm mới
        </a>
    </div>

    <div class="rounded-lg p-4 mt-6 bg-white">
        <div class="dd" id="nestable">
            <ol class="dd-list space-y-2">
                @foreach ($menuItems as $menuItem)
                    <li class="dd-item space-y-2" data-id="{{ $menuItem->id }}">
                        <div class="dd-data flex items-center justify-between">
                            <div class="dd-handle w-full flex items-center justify-between text-xs">
                                @if ($menuItem->image)
                                    <div class="flex items-center space-x-2">
                                        <img width="40" height="40" src="{{ $menuItem->image }}" alt="preview image">
                                        <div>
                                            <div>{{ $menuItem->name }}</div>
                                            <span class="text-gray-500">{{ $menuItem->url ?? '#' }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <div>{{ $menuItem->name }}</div>
                                        <span class="text-gray-500">{{ $menuItem->url ?? '#' }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between space-x-2 px-2">
                                <a href="{{ route('admin.builder-item.edit', $menuItem->id) }}" class="text-xs px-3 py-2 min-w-max hover:bg-gray-100 hover:text-gray-700 rounded-lg"> Chỉnh sửa </a>
                                <a href="#" class="text-xs px-3 py-2 min-w-max hover:bg-gray-100 hover:text-gray-700 rounded-lg"
                                    uk-toggle="target: #delete-menu-modal"
                                    onclick="setDeleteMenuId({{ $menuItem->id }})">
                                    Xóa
                                </a>
                            </div>
                        </div>
                        @if ($menuItem->children->count() > 0)
                            <ol class="dd-list space-y-2">
                                @foreach ($menuItem->children as $child)
                                    @include('admin::builder._menu-item', ['item' => $child])
                                @endforeach
                            </ol>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </div>

    <!-- Modal Xóa -->
    <div id="delete-menu-modal" uk-modal>
        <div class="uk-modal-dialog uk-modal-body rounded-lg">
            <h2 class="text-xl font-medium mb-4">Xác nhận xóa</h2>
            <p class="text-sm">Bạn có chắc chắn muốn xóa mục menu này không?</p>
            <div class="flex items-center justify-end space-x-2 mt-4">
                <x-admin::form.button type="button" color="default" radius="lg" uk-toggle="target: #delete-menu-modal"> Hủy </x-admin::form.button>
                <form id="delete-menu-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-admin::form.button type="submit" color="danger" radius="lg"> Xác nhận </x-admin::form.button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ asset('assets/libs/nestable/nestable.min.js') }}"></script>

    <script>
        function setDeleteMenuId(menuId) {
            let form = document.getElementById('delete-menu-form');
            let deleteUrl = "{{ route('admin.builder-item.destroy', ':id') }}";

            form.action = deleteUrl.replace(':id', menuId);
        }

        $(document).ready(function () {
            let nestable = $('#nestable').nestable();

            // Khi menu thay đổi vị trí, tự động gửi dữ liệu lên server
            nestable.on('change', function () {
                let order = nestable.nestable('serialize');

                $.ajax({
                    url: "{{ route('admin.builder.updateOrder') }}",
                    method: "POST",
                    data: {
                        order: order,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            console.log("Thứ tự menu đã được cập nhật!")
                        } else {
                            console.log("Cập nhật thất bại: " + response.message)
                        }
                    },
                    error: function () {
                        alert("Có lỗi xảy ra! Vui lòng thử lại.");
                    }
                });
            });
        });
    </script>
@endsection
