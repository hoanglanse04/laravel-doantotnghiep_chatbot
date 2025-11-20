@extends('admin::layouts.master')
@section('title', 'Thông tin')

@section('head')
@endsection

@section('content')
    <div class="mb-6">
        <div class="relative group flex items-center">
            <a class="text-sm text-gray-500 dark:text-gray-800" href="{{ route('admin.user.index') }}">
                Khách hàng
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 mx-2 fill-current text-gray-600" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path></svg>
            <span class="text-sm text-gray-500 dark:text-gray-800"> Thông tin </span>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center justify-between text-xl">
            <h2 class="font-semibold text-xl"> Thông tin cơ bản </h2>
            <a class="text-sm text-white font-medium bg-[#56a661] hover:shadow-md transition px-6 py-2.5 rounded-full cursor-pointer" href="{{ route('admin.user.edit', ['user' => $data->id]) }}">
                Chỉnh sửa
            </a>
        </div>

        <ul class="grid grid-cols-5 gap-6 ml-4">
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">ID</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->id }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Tên người dùng</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->name }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Email</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->email }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Số điện thoại</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->phone ?: 'N/A' }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Vai trò</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->role ?: 'N/A' }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Trạng thái</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->status ?: 'N/A' }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Giới thiệu</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->description ?: 'N/A' }}</span>
            </li>
        </ul>

        <h2 class="font-semibold text-xl"> Ảnh </h2>
        <ul class="flex items-center gap-4 ml-4">
            <div class="aspect-square">
                <img class="object-cover rounded-md" src="{{ image($data->image) }}" width="100" height="100" />
            </div>
        </ul>
    </div>
@endsection
