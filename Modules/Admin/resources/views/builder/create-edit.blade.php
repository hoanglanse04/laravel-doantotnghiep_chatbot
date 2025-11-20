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
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 mx-2 fill-current text-gray-600" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path></svg>
            <span class="text-sm text-gray-500 dark:text-gray-800">Tạo mới</span>
        </div>
        <a class="text-sm text-white font-medium bg-[#56a661] hover:shadow-md transition px-6 py-2.5 rounded-full cursor-pointer" href="{{ route('admin.builder.create') }}">Thêm mới</a>
    </div>

    <form action="{{ route('admin.builder.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl space-y-4">
        @csrf
        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">
                Tên menu
            </div>
            <div class="w-full">
                <x-admin::form.input
                    name="name"
                    :value="old('name')"
                    placeholder="Nhập tên menu"
                    class="w-full"
                />
            </div>
        </div>
        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">
                Slug
            </div>
            <div class="w-full">
                <x-admin::form.input
                    name="slug"
                    :value="old('slug')"
                    placeholder="Nhập slug"
                    class="w-full"
                />
            </div>
        </div>
        <div class="flex items-center">
            <div class="block w-40 flex-none font-medium text-sm">
                Mô tả ngắn
            </div>
            <div class="w-full">
                <x-admin::form.input
                    name="description"
                    :value="old('description')"
                    placeholder="Nhập Mô tả ngắn"
                    class="w-full"
                />
            </div>
        </div>

        <x-admin::form.button
            type="submit"
            color="success"
            radius="lg"
        >
            Tạo mới
        </x-admin::form.button>
    </form>
@endsection

@push('footer')
@endpush
