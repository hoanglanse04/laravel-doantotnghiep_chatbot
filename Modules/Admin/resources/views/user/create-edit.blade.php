@extends('admin::layouts.master')
@section('title', isset($data) ? 'Chỉnh sửa Người dùng' : 'Thêm mới Người dùng')

@section('head')
@endsection

@section('content')
    <div class="mb-6">
        <div class="relative group flex items-center">
            <a class="text-sm text-gray-500 dark:text-gray-800" href="{{ route('admin.user.index') }}">
                Người dùng
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 mx-2 fill-current text-gray-600" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path></svg>
            <span class="text-sm text-gray-500 dark:text-gray-800">{{ isset($data) ? 'Cập nhật' : 'Tạo mới'}}</span>
        </div>
    </div>

    <form action="{{ isset($data) ? route('admin.user.update', $data->id) : route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($data)
            @method('PUT')
        @endisset
        <div class="max-w-5xl space-y-2 mb-4">
            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Tên Người dùng </div>
                <div class="w-full">
                    <x-admin::form.input
                        name="name"
                        :value="old('name', $data->name ?? '')"
                        placeholder="Nhập tên"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Email </div>
                <div class="w-full">
                    <x-admin::form.input
                        name="email"
                        :value="old('email', $data->email ?? '')"
                        placeholder="Nhập địa chỉ email"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Số điện thoại </div>
                <div class="w-full">
                    <x-admin::form.input
                        name="phone"
                        :value="old('phone', $data->phone ?? '')"
                        placeholder="Nhập số điện thoại"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Mật khẩu </div>
                <div class="w-full">
                    <x-admin::form.input
                        name="password"
                        placeholder="Để trống nếu không muốn đổi mật khẩu mới"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm">Trạng thái</div>
                <div class="w-full">
                    <x-admin::form.select
                        name="status"
                        :options="\App\Enums\Common::getStatusesKindWithLabel()"
                        :selected="old('status', $data->status ?? '')"
                        placeholder="Trạng thái"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm">Giới tính</div>
                <div class="w-full">
                    <x-admin::form.select
                        name="gender"
                        :options="\App\Enums\Common::getGendersWithLabel()"
                        :selected="old('gender', $data->gender ?? '')"
                        placeholder="Giới tính"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm">Vai trò</div>
                <div class="w-full">
                    <x-admin::form.select
                        name="role"
                        :options="\App\Enums\Common::getRolesWithLabel()"
                        :selected="old('role', $data->gender ?? '')"
                        placeholder="Vai trò"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Giới thiệu </div>
                <div class="w-full">
                    <x-admin::form.textarea
                    name="description"
                    :value="old('description', $data->description ?? '')"
                    placeholder="Giới thiệu"
                    class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm">Hình ảnh</div>
                <div class="w-full">
                    <x-admin::form.image
                        name="image"
                        :value="old('image', $data->image ?? '')"
                        placeholder="Chọn hình ảnh"
                        class="w-full"
                    />
                </div>
            </div>
        </div>

        <x-admin::form.button
            type="submit"
            color="success"
            radius="lg"
        >
            {{ isset($data) ? 'Cập nhật' : 'Tạo mới'}}
        </x-admin::form.button>
    </form>
@endsection

@section('footer')
@endsection
