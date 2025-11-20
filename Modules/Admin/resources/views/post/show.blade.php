@extends('admin::layouts.master')
@section('title', 'Thông tin')

@section('head')
@endsection

@section('content')
    <div class="mb-6">
        <div class="relative group flex items-center">
            <a class="text-sm text-gray-500 dark:text-gray-800" href="{{ route('admin.post.index') }}">
                Trang đơn
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 mx-2 fill-current text-gray-600" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path></svg>
            <span class="text-sm text-gray-500 dark:text-gray-800"> Thông tin </span>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center justify-between text-xl">
            <h2 class="font-semibold text-xl"> Thông tin cơ bản </h2>
            <a href="{{ route('admin.post.edit', ['post' => $data->id]) }}" class="text-sm text-white font-medium bg-[#56a661] hover:shadow-md transition px-6 py-2.5 rounded-full cursor-pointer">
                Chỉnh sửa
            </a>
        </div>

        <ul class="grid grid-cols-5 gap-6 ml-4">
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">ID</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->id }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Tên bài viết</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->title }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Liên kết</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->slug }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Chuyên mục</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data?->category?->name ?: "N/A" }}</span>
            </li>
        </ul>

        <h2 class="font-semibold text-xl"> Ảnh </h2>
        <ul class="flex items-center gap-4 ml-4">
            <div class="aspect-square">
                <img class="object-cover rounded-md" src="{{ image($data->image) }}" width="100" height="100" />
            </div>
        </ul>

        <h2 class="font-semibold text-xl"> Giới thiệu sản phẩm & SEO </h2>
        <ul class="space-y-4 ml-4">
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Nội dung</div>
                <div class="max-w-7xl space-y-4">
                    {!! $data->content !!}
                </div>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Mô tả ngắn</div>
                <span class="font-semibold mt-1 line-clamp-2">{!! $data->description !!}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Meta title</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->meta_title }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Meta description</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->meta_description }}</span>
            </li>
            <li>
                <div class="uppercase font-semibold text-xs text-gray-600">Meta keywords</div>
                <span class="font-semibold mt-1 line-clamp-2">{{ $data->meta_keywords }}</span>
            </li>
        </ul>
    </div>
@endsection
