@extends('admin::layouts.master')
@section('title', isset($data) ? 'Chỉnh sửa sản phẩm' : 'Thêm mới sản phẩm')

@section('head')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />
    <style>
        li.uk-active a {
            background-color: #fff
        }
        .filepond--item {
            width: calc(50% - 0.5em);
        }
        @media (min-width: 30em) {
            .filepond--item {
                width: calc(33.33% - 0.5em);
            }
        }
        @media (min-width: 50em) {
            .filepond--item {
                width: calc(20% - 0.5em);
            }
        }
    </style>
@endsection

@section('content')
    @isset($data)
        @php
            $images = is_array($data->multiple_image)
                ? $data->multiple_image
                : json_decode($data->multiple_image, true) ?? [];
        @endphp
    @endisset


    <div class="mb-6">
        <div class="relative group flex items-center">
            <a class="text-sm text-gray-500 dark:text-gray-800" href="{{ route('admin.product.index') }}">
                Sản phẩm
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 mx-2 fill-current text-gray-600" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8.512 4.43a.75.75 0 0 1 1.057.082l6 7a.75.75 0 0 1 0 .976l-6 7a.75.75 0 0 1-1.138-.976L14.012 12L8.431 5.488a.75.75 0 0 1 .08-1.057" clip-rule="evenodd"></path></svg>
            <span class="text-sm text-gray-500 dark:text-gray-800">{{ isset($data) ? 'Cập nhật' : 'Tạo mới'}}</span>
        </div>
    </div>

    <form action="{{ isset($data) ? route('admin.product.update', $data->id) : route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($data)
            @method('PUT')
        @endisset
        <div class="max-w-5xl space-y-2">
            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Tên sản phẩm </div>
                <div class="w-full">
                    <x-admin::form.input
                        name="name"
                        :value="old('name', $data->name ?? '')"
                        placeholder="Nhập tên sản phẩm"
                        class="w-full"
                    />
                </div>
            </div>

            @if (isset($data))
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
            @endif

            <div class="flex items-center">
                <div class="block w-40 flex-none font-medium text-sm"> Mã sản phẩm </div>
                <div class="w-full">
                    <x-admin::form.input
                        name="sku"
                        :value="old('sku', $data->sku ?? '')"
                        placeholder="SKU"
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
                <div class="block w-40 flex-none font-medium text-sm">
                    Giá bán
                </div>
                <div class="w-full flex items-center justify-between space-x-4">
                    <x-admin::form.input
                        name="price"
                        default="0"
                        :value="old('price', !empty($data->price) ? number_format($data->price, 0, '.', '.') : '')"
                        placeholder="Giá niêm yết"
                        class="w-full"
                        oninput="formatCurrency(this); calculateDiscount();"
                        endContent="<span class='finalPrice absolute top-1/2 right-2 transform -translate-y-1/2 text-xs'>{{ isset($data) ? number_format($data->final_price, 0, '.', '.') : 0 }} đ</span>"
                    />

                    <x-admin::form.input
                        name="discount_percentage"
                        default="0"
                        :value="old('discount_percentage', $data->discount_percentage ?? '')"
                        placeholder="% giảm"
                        class="w-36"
                        oninput="calculateDiscount()"
                        endContent="<span class='discountValue absolute top-1/2 right-2 transform -translate-y-1/2 text-xs'>{{ isset($data) ? number_format($data->discount_price, 0, '.', '.') : 0 }} đ</span>"
                    />
                </div>
            </div>
        </div>

        <div class="my-6">
            <ul uk-switcher="connect: .my-tab" class="flex items-center space-x-2">
                <li>
                    <a href="#" class="text-xs px-4 py-3 bg-[#f2f5f1] rounded-t-lg block uppercase font-medium transition"> Ảnh </a>
                </li>
                <li>
                    <a href="#" class="text-xs px-4 py-3 bg-[#f2f5f1] rounded-t-lg block uppercase font-medium transition"> Thuộc tính </a>
                </li>
                <li>
                    <a href="#" class="text-xs px-4 py-3 bg-[#f2f5f1] rounded-t-lg block uppercase font-medium transition"> SEO </a>
                </li>
            </ul>
            <div class="uk-switcher my-tab">
                <!-- Upload images :: filepond -->
                <div class="p-6 rounded-b-lg rounded-r-lg bg-white">
                    <ul class="mb-4 text-xs">
                        <li>- Tải lên tối đa là 10 ảnh</li>
                        <li>- Ảnh đầu tiên sẽ là ảnh đại diện sản phẩm</li>
                        <li>- Định dạng tải lên được cho phép jpg, jpeg, png, webp</li>
                        <li>- Ảnh khi tải lên trùng tên sẽ tự động thêm số thứ tự tăng dần ở cuối tập tin (abc.jpg => abc1.jpg)</li>
                        <li>- Ảnh tải lên sẽ được nén và tối ưu sang định dạng .webp chuẩn của google (giảm kích thước tệp, di động tải xuống nhanh hơn và tốt cho seo)</li>
                    </ul>
                    <input id="multiple_image" name="multiple_image[]" type="file" multiple data-allow-reorder="true">
                </div>
                {{-- Thuộc tính --}}
                <div class="p-6 rounded-b-lg rounded-r-lg bg-white">
                    <div id="specifications-wrapper">
                        @foreach($data->specifications ?? [] as $index => $spec)
                            <div class="flex gap-2 mb-2 items-start">
                                <x-admin::form.input
                                    name="specifications[{{ $index }}][label]"
                                    :value="$spec['label'] ?? ''"
                                    placeholder="Tên thông số"
                                    class="w-1/2"
                                />

                                <x-admin::form.input
                                    name="specifications[{{ $index }}][value]"
                                    :value="$spec['value'] ?? ''"
                                    placeholder="Giá trị"
                                    class="w-1/2"
                                />

                                <x-admin::form.button
                                    type="button"
                                    color="danger"
                                    class="remove-spec px-2 min-w-10 h-10"
                                >
                                    ✕
                                </x-admin::form.button>
                            </div>
                        @endforeach
                    </div>

                    <x-admin::form.button
                        type="button"
                        color="success"
                        radius="lg"
                        id="add-spec"
                    >
                        Thêm thông số
                    </x-admin::form.button>
                </div>
                <!-- SEO -->
                <div class="p-6 rounded-b-lg rounded-r-lg bg-white space-y-2">
                    <div class="flex items-center">
                        <div class="block w-40 flex-none font-medium text-sm"> Nội dung </div>
                        <div class="w-full">
                            <textarea id="editor" name="content" id="content" cols="30" rows="10" class="hidden">{{ isset($data) ? $data->content : old('content') }}</textarea>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="block w-40 flex-none font-medium text-sm"> Thông số sản phẩm </div>
                        <div class="w-full">
                            <textarea id="details" name="details" id="details" cols="30" rows="10" class="hidden">{{ isset($data) ? $data->details : old('details') }}</textarea>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="block w-40 flex-none font-medium text-sm"> Tính năng sản phẩm </div>
                        <div class="w-full">
                            <textarea id="description" name="description" id="description" cols="30" rows="5" class="w-full p-2 px-3 text-sm border-2 border-gray-200 rounded-md outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ isset($data) ? $data->description : old('description') }}</textarea>
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
        document.getElementById('add-spec').addEventListener('click', () => {
            const wrapper = document.getElementById('specifications-wrapper');

            // Đếm số lượng cặp hiện có bằng input name
            const currentIndex = wrapper.querySelectorAll('input[name^="specifications["][name$="[label]"]').length;

            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2', 'mb-2', 'spec-item');
            div.innerHTML = `
                <input type="text" name="specifications[${currentIndex}][label]" class="w-full flex items-center w-full text-sm px-3 py-2 bg-white border-2 border-solid border-gray-200 rounded-md w-1/2" placeholder="Tên thông số">
                <input type="text" name="specifications[${currentIndex}][value]" class="w-full flex items-center w-full text-sm px-3 py-2 bg-white border-2 border-solid border-gray-200 rounded-md w-1/2" placeholder="Giá trị">
                <button type="button" class="font-medium transition cursor-pointer min-w-10 h-10 text-sm px-3 py-2 bg-red-600 text-white hover:bg-red-700 rounded-md remove-spec px-2">✕</button>`;
            wrapper.appendChild(div);
        });


        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-spec')) {
                e.target.parentElement.remove();
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const priceInput = document.querySelector("input[name='price']");
            const discountInput = document.querySelector("input[name='discount_percentage']");
            const discountValueSpan = document.querySelector(".discountValue");
            const finalPriceSpan = document.querySelector(".finalPrice");

            function formatCurrency(input) {
                let value = input.value.replace(/\D/g, ''); // Chỉ giữ lại số

                // Nếu không có giá trị (người dùng xóa hết), đặt lại input thành chuỗi rỗng
                if (value === '') {
                    input.value = '';
                    return;
                }

                // Format số
                let formatted = new Intl.NumberFormat('vi-VN').format(value);
                input.value = formatted;

                calculateDiscount();
            }

            function calculateDiscount() {
                let price = parseFloat(priceInput.value.replace(/\D/g, '')) || 0;
                let discount = parseFloat(discountInput.value) || 0;

                if (discount > 100) {
                    discount = 100;
                    discountInput.value = 100;
                }

                // Tính số tiền giảm và giá cuối cùng
                let discountAmount = Math.round((price * discount) / 100);
                let finalPrice = price - discountAmount;

                // Cập nhật giao diện
                discountValueSpan.textContent = `${discountAmount.toLocaleString()} đ`;
                finalPriceSpan.textContent = `${finalPrice.toLocaleString()} đ`;
            }


            priceInput.addEventListener("input", function () {
                formatCurrency(priceInput);
            });

            discountInput.addEventListener("input", function() {
                calculateDiscount();
            });
        });

        CKEDITOR.replace('editor', {
            filebrowserBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}',
            filebrowserImageBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}',
            filebrowserFlashBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}?type=Flash',
            filebrowserUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Flash'
        });
        CKEDITOR.replace('details', {
            filebrowserBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}',
            filebrowserImageBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}',
            filebrowserFlashBrowseUrl: '{{ asset(route('admin.ckfinder_browser')) }}?type=Flash',
            filebrowserUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: '{{ asset(route('admin.ckfinder_connector')) }}?command=QuickUpload&type=Flash'
        });

        CKEDITOR.replace('description', {
            // Define the toolbar groups as it is a more accessible solution.
            toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
                },
                {
                "name": "links",
                "groups": ["links"]
                },
                {
                "name": "paragraph",
                "groups": ["list", "blocks"]
                },
                {
                "name": "document",
                "groups": ["mode"]
                },
                {
                "name": "insert",
                "groups": ["insert"]
                },
                {
                "name": "styles",
                "groups": ["styles"]
                },
                {
                "name": "about",
                "groups": ["about"]
                }
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
        });
    </script>

    <!-- FilePond library -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        // Register the plugin
        FilePond.registerPlugin(
            FilePondPluginFilePoster,
            FilePondPluginImagePreview,
        );

        // Get a reference to the file input element
        const multipleImage = document.querySelector('#multiple_image');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // add file for multipleImage
        var filesMultipleImage = [
            @if(isset($images) && count($images) > 0)
                @foreach ($images as $image)
                {
                    source: '{{ $image }}',
                    options: {
                        type: 'local',
                        metadata: {
                            poster: '{{ image($image) }}',
                        }
                    }
                },
                @endforeach
            @endif
        ];
        const pondMultipleImage = FilePond.create(multipleImage, {
            labelIdle: 'Ảnh trình chiếu <span class="filepond--label-action"> Duyệt </span>',
            labelFileSizeNotAvailable: 'Kích thước không có sẵn',
            labelFileLoading: 'Đang tải',
            labelFileProcessing: 'Đang tải lên',
            labelFileProcessingComplete: 'Tải lên hoàn tất',
            labelFileProcessingAborted: 'Đã hủy tải lên',
            labelFileProcessingError: 'Lỗi trong quá trình tải lên',
            labelFileProcessingRevertError: 'Lỗi trong quá trình hoàn nguyên',
            labelFileRemoveError: 'Lỗi trong quá trình xóa',
            labelTapToCancel: 'Nhấn để hủy',
            labelTapToUndo: 'Nhấn để hoàn tác',
            labelButtonRemoveItem: 'Xoá',
            labelButtonAbortItemLoad: 'Huỷ bỏ',
            labelTapToRetry: 'Chạm để thử lại',
            labelButtonRetryItemLoad: 'Thử lại',
            labelButtonAbortItemProcessing: 'Hủy bỏ',
            labelButtonUndoItemProcessing: 'Hoàn tác',
            labelButtonRetryItemProcessing: 'Thử lại',
            labelButtonProcessItem: 'Tải lên',
            allowFilePoster: true,
            maxFiles: 10,
            required: false,
            allowMultiple: true,
            allowReplace: false,
            instantUpload: true,

            // Tuỳ chỉnh hiển thị của danh sách ảnh
            filePosterMaxHeight: '220px',
            filePosterMinHeight: '220px',
            imagePreviewHeight: '220px',
            server: {
                url: '{{ url("/") }}',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                process: '/admin/uploads/process?folder=product&input=multiple_image',
                revert: './admin/uploads/revert',
                restore: './admin/uploads/restore?id=',
                fetch: './admin/uploads/fetch?data=',
                load: '/admin/uploads/load?file='
            },

            files: filesMultipleImage,
        });
    </script>
@endsection
