@extends('admin::layouts.master')
@section('title', 'Tạo mới Menu Builder')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" />
@endpush

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="relative group flex items-center">
            <a class="text-sm text-gray-500 dark:text-gray-800" href="{{ route('admin.builder.index') }}">
                <span>Menu Builder</span>
            </a>
            @isset($menu)
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-2 fill-current text-gray-600" viewBox="0 0 24 24">
                    <path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('admin.builder.show', ['builder' => $menu->id]) }}" class="text-sm text-gray-500 dark:text-gray-800">
                    {{ $menu->name }}
                </a>
            @endisset
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-2 fill-current text-gray-600" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm text-gray-500 dark:text-gray-800">Tạo mới</span>
        </div>
        <button class="text-sm text-white font-medium bg-[#56a661] hover:shadow-md transition px-6 py-2.5 rounded-full cursor-pointer" uk-toggle="target: #modal-add-custome-field" type="button">Thêm mới trường tùy chỉnh</button>
    </div>

    <form
        action="{{ !isset($menu) ? route('admin.builder-item.store') : route('admin.builder-item.update', ["builder_item" => $menu->id]) }}"
        method="POST"
        enctype="multipart/form-data"
        class="max-w-5xl space-y-4"
    >
        @csrf
        @isset ($menu)
            @method('PUT')
        @endisset
        <input type="hidden" name="menu_id" value="{{ request()->menu_id }}">

        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">Tên</div>
            <div class="w-full">
                <x-admin::form.input
                    name="name"
                    :value="old('name', $menu->name ?? '')"
                    placeholder="Nhập tên menu"
                    class="w-full"
                />
            </div>
        </div>

        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">Thuộc về</div>
            <div class="w-full">
                <x-admin::form.select
                    name="parent_id"
                    :options="['0' => 'Thuộc về lớn nhất'] + $menuItems"
                    :selected="old('parent_id', $menu->parent_id ?? '')"
                    placeholder="Thuộc về menu"
                    class="w-full"
                />
            </div>
        </div>

        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">URL</div>
            <div class="w-full">
                <x-admin::form.input
                    name="url"
                    :value="old('url', $menu->url ?? '')"
                    placeholder="Nhập liên kết"
                    class="w-full"
                />
            </div>
        </div>

        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">Target</div>
            <div class="w-full">
                <x-admin::form.select
                    name="target"
                    :options="['_self' => 'Mở trong trang hiện tại', '_blank' => 'Mở trong tab mới']"
                    :selected="old('target', $menu->target ?? '_self')"
                    placeholder="Chọn kiểu mở liên kết"
                    class="w-full"
                />
            </div>
        </div>

        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">Trạng thái</div>
            <div class="w-full">
                <x-admin::form.select
                    name="status"
                    :options="\App\Enums\Common::getStatusesBaseWithLabel()"
                    :selected="old('status', $menu->status ?? '')"
                    placeholder="Trạng thái"
                    class="w-full"
                />
            </div>
        </div>

        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">Icon SVG</div>
            <div class="w-full">
                <x-admin::form.input
                    name="icon"
                    :value="old('icon', $menu->icon ?? '')"
                    placeholder="Nhập icon dạng svg"
                    class="w-full"
                />
            </div>
        </div>

        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">Hình ảnh/Video</div>
            <div class="w-full">
                <x-admin::form.image
                    name="image"
                    :value="old('image', $menu->image ?? '')"
                    placeholder="Chọn hình ảnh"
                    class="w-full"
                />
            </div>
        </div>

        @if (!empty($menu?->custom_fields))
            <div class="font-medium">Trường tùy chỉnh</div>
            <div class="space-y-4" id="custom-fields-wrapper">
                @foreach ($menu->custom_fields as $index => $field)
                    <div class="flex items-center relative" id="custom_field_{{ $index }}">
                        <input type="hidden" name="custom_fields[{{ $index }}][label]" value="{{ $field['label'] }}">
                        <input type="hidden" name="custom_fields[{{ $index }}][type]" value="{{ $field['type'] }}">

                        <div class="block w-40 flex-none font-medium text-sm">
                            {{ $field['label'] }} ({{ $field['type'] }})
                        </div>

                        <div class="w-full">
                            @if ($field['type'] === 'textarea')
                                <x-admin::form.textarea
                                    type="textarea"
                                    name="custom_fields[{{ $index }}][value]"
                                    :value="$field['value'] ?? ''"
                                    placeholder="Nhập nội dung..."
                                    class="w-full"
                                />
                            @elseif($field['type'] === 'code')
                                <x-admin::form.code
                                    name="custom_fields[{{ $index }}][value]"
                                    :value="$field['value'] ?? ''"
                                    mode="html"
                                    theme="github"
                                    height="250px"
                                    class="w-full"
                                />
                            @endif
                        </div>

                        <button type="button"
                            onclick="openDeleteCustomFieldModal({{ $menu->id }}, {{ $index }})"
                            class="text-gray-700 absolute top-0 -right-6 cursor-pointer"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29l-4.3 4.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l4.29-4.3l4.29 4.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42Z"/>
                            </svg>
                        </button>

                    </div>
                @endforeach
            </div>
        @endif

        <x-admin::form.button type="submit" color="success" radius="lg">
            @if (isset($menu))
                Cập nhật
                @else
                Tạo mới
            @endif
        </x-admin::form.button>
    </form>

    <!-- Modal Thêm mới trường tùy chỉnh -->
    <div id="modal-add-custome-field" uk-modal>
        <form action="{{ route('admin.builder.item.create-custome') }}" method="POST" class="uk-modal-dialog uk-modal-body rounded-md">
            @csrf
            <input name="menu_item_id" type="hidden" value="{{ isset($menu) ? $menu->id : 0 }}">
            <button class="uk-modal-close" type="button"></button>
            <h2 class="text-xl mb-4">Thêm trường tuỳ chỉnh</h2>

            <div class="space-y-4 mb-6">
                <x-admin::form.input
                    name="name"
                    placeholder="Nhập tên trường"
                    class="w-full"
                />

                <x-admin::form.select
                    name="type"
                    :options="['textarea' => 'Textarea', 'code' => 'Code']"
                    placeholder="Chọn loại trường"
                    class="w-full"
                />
            </div>

            <x-admin::form.button
                type="submit"
                color="success"
                radius="lg"
            >
                Tạo mới
            </x-admin::form.button>
        </form>
    </div>

    <!-- Modal xóa 1 trường tùy chỉnh -->
    <div id="modal-confirm-delete" uk-modal>
        <div class="uk-modal-dialog uk-modal-body rounded-md">
            <h2 class="text-lg font-medium mb-4">Xác nhận xoá trường tuỳ chỉnh?</h2>
            <p class="text-sm text-gray-500 mb-4">Thao tác này không thể hoàn tác.</p>

            <form id="deleteCustomFieldForm" method="POST">
                @csrf
                <input type="hidden" name="index" id="deleteCustomFieldIndex">
                <div class="flex justify-end gap-2">
                    <button type="button" class="uk-modal-close px-4 py-2">Huỷ</button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Xác nhận xoá</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer')
    <script src="{{ asset('assets/libs/src-min-noconflict/ace.js') }}"></script>
    <script>
        function openDeleteCustomFieldModal(menuItemId, index) {
            const form = document.getElementById('deleteCustomFieldForm');
            const input = document.getElementById('deleteCustomFieldIndex');

            input.value = index;
            form.action = `/admin/builder-item/${menuItemId}/delete-custome`;

            UIkit.modal('#modal-confirm-delete').show();
        }
    </script>
@endsection
