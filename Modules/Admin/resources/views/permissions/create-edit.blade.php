@extends('admin::layouts.master')
@section('title', isset($data) ? 'Chỉnh sửa bài viết' : 'Thêm mới bài viết')

@section('head')
    <style>
        li.uk-active a {
            background-color: #fff
        }
    </style>
@endsection

@section('content')
    <div class="mb-6">
        <div class="relative group flex items-center">
            <a class="text-sm text-gray-500 dark:text-gray-800" href="{{ route('admin.page.index') }}">
                Bài viết
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 mx-2 fill-current text-gray-600" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path></svg>
            <span class="text-sm text-gray-500 dark:text-gray-800">{{ isset($data) ? 'Cập nhật' : 'Tạo mới'}}</span>
        </div>
    </div>

    <form action="{{ isset($data) ? route('admin.page.update', $data->id) : route('admin.page.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($data)
            @method('PUT')
        @endisset
        <div class="max-w-5xl space-y-2">
            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Tên bài viết </div>
                <div class="w-full">
                    <x-admin::form.input
                        name="title"
                        :value="old('title', $data->title ?? '')"
                        placeholder="Nhập tên"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Liên kết </div>
                <div class="w-full">
                    <x-admin::form.input
                        name="slug"
                        :value="old('slug', $data->slug ?? '')"
                        placeholder="Nhập liên kết"
                        description="không nên thay đổi url khi đã index tránh mất thứ hạng seo"
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
                        :selected="old('status', $data->status ?? '')"
                        placeholder="Trạng thái"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Chuyên mục </div>
                <div class="w-full">
                    <x-admin::form.select
                        name="category_id"
                        :options="['' => 'Thuộc về lớn nhất'] + $categories"
                        :selected="old('category_id', $data->category_id ?? 0)"
                        placeholder="Thuộc về menu"
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

        <div class="my-6">
            <ul uk-switcher="connect: .my-tab" class="flex items-center space-x-2">
                <li>
                    <a href="#" class="text-xs px-4 py-3 bg-[#f2f5f1] rounded-t-lg block uppercase font-medium transition"> SEO </a>
                </li>
            </ul>
            <div class="uk-switcher my-tab">
                <!-- SEO -->
                <div class="p-6 rounded-b-lg rounded-r-lg bg-white space-y-2">
                    <div class="flex items-center">
                        <div class="block w-40 flex-none font-medium text-sm"> Nội dung </div>
                        <div class="w-full">
                            <textarea id="editor" name="content" id="content" cols="30" rows="10" class="hidden">{{ isset($data) ? $data->content : old('content') }}</textarea>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="block w-40 flex-none font-medium text-sm"> Seo title </div>
                        <div class="w-full">
                            <x-admin::form.input
                                name="meta_title"
                                :value="old('meta_title', $data->meta_title ?? '')"
                                placeholder="Tiêu đề seo"
                                class="w-full"
                            />
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="block w-40 flex-none font-medium text-sm"> Seo description </div>
                        <div class="w-full">
                            <x-admin::form.textarea
                                name="meta_description"
                                :value="old('meta_description', $data->meta_description ?? '')"
                                placeholder="Mô tả seo"
                                class="w-full"
                            />
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="block w-40 flex-none font-medium text-sm"> Seo keywords </div>
                        <div class="w-full">
                            <x-admin::form.input
                                name="meta_keywords"
                                :value="old('meta_keywords', $data->meta_keywords ?? '')"
                                placeholder="Từ khóa seo"
                                class="w-full"
                            />
                        </div>
                    </div>
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
    <script src="{{ asset('assets/libs/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('editor', {
            filebrowserBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}',
            filebrowserImageBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}',
            filebrowserFlashBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}?type=Flash',
            filebrowserUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Flash'
        });
    </script>
@endsection
