@extends('admin::layouts.master')
@section('title', 'Cài đặt hệ thống')

@section('content')
    <h1 class="mb-6">Cài đặt</h1>

    <form action="{{ route('admin.setting.update', 1) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <!-- Tabs Navigation -->
        <div class="tabs-nav max-w-max flex bg-[#f2f5f1] rounded-2xl overflow-hidden p-1.5 space-x-1">
            @foreach($settings as $index => $setting)
                <button
                    type="button"
                    class="tab-link px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 cursor-pointer rounded-xl"
                    data-tab="tab-{{ $setting->id }}"
                    {{ $index === 0 ? 'style=background:#e7ede7;' : '' }}
                >
                    {{ $setting->name }}
                </button>
            @endforeach
        </div>

       <!-- Tabs Content -->
        <div class="tabs-content mt-4">
            @foreach($settings as $index => $setting)
                <div id="tab-{{ $setting->id }}" class="tab-panel {{ $index === 0 ? '' : 'hidden' }}">

                    <!-- Nhóm Container -->
                    <div class="group-container grid grid-cols-2 gap-4" data-tab="{{ $setting->id }}">
                        @foreach($setting->children as $child)
                            <!-- Group Item: Kéo cả nhóm + fields -->
                            <div class="group-item p-4 mb-4 rounded-2xl" data-group-id="{{ $child->id }}">
                                <div class="flex items-center">
                                    <!-- SVG Drag Handle cho Group -->
                                    {{-- <span class="drag-handle cursor-move mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M9 19.23q-.508 0-.87-.36T7.77 18t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m6 0q-.508 0-.87-.36t-.36-.87t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m-6-6q-.508 0-.87-.36T7.77 12t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m6 0q-.508 0-.87-.36t-.36-.87t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m-6-6q-.508 0-.87-.36T7.77 6t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m6 0q-.508 0-.87-.36T13.77 6t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36"/>
                                        </svg>
                                    </span> --}}

                                    <h3 class="font-semibold">{{ $child->name }}</h3>
                                </div>

                                <!-- Container chứa các field (sortable) -->
                                <div class="fields-container mt-4 rounded-xl space-y-2" data-group-id="{{ $child->id }}">
                                    @foreach($child->fields as $field)
                                        <div class="flex items-start">
                                            <!-- SVG Drag Handle cho Field -->
                                            <span class="drag-handle cursor-move">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-gray-400 mr-1" width="20" height="20" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M9 19.23q-.508 0-.87-.36T7.77 18t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m6 0q-.508 0-.87-.36t-.36-.87t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m-6-6q-.508 0-.87-.36T7.77 12t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m6 0q-.508 0-.87-.36t-.36-.87t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m-6-6q-.508 0-.87-.36T7.77 6t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36m6 0q-.508 0-.87-.36T13.77 6t.36-.87t.87-.36t.87.36t.36.87t-.36.87t-.87.36"/>
                                                </svg>
                                            </span>
                                            <div class="field-item w-full p-2 rounded-lg bg-white flex items-center border border-solid border-gray-100" data-field-id="{{ $field->id }}">
                                                @include('admin::setting.fields.' . $field->type, ['field' => $field])
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input hidden lưu thứ tự nhóm và field sau khi kéo thả -->
        <input type="hidden" name="group_order" id="group_order">
        <input type="hidden" name="field_order" id="field_order">

        <x-admin::form.button
            type="submit"
            color="success"
            radius="lg"
        >
            Lưu cài đặt
        </x-admin::form.button>
    </form>

    <script src="{{ asset('assets/libs/sortable/sortable.min.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".tab-link");
            const panels = document.querySelectorAll(".tab-panel");
            const groupOrderInput = document.getElementById("group_order");
            const fieldOrderInput = document.getElementById("field_order");

            // Xử lý chuyển tab
            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    const target = this.getAttribute("data-tab");

                    panels.forEach(panel => panel.classList.add("hidden"));
                    document.getElementById(target).classList.remove("hidden");

                    tabs.forEach(t => t.style.background = "");
                    this.style.background = "#e7ede7";
                });
            });

            // Kéo & thả nhóm (di chuyển cả group + fields)
            document.querySelectorAll(".group-container").forEach(container => {
                new Sortable(container, {
                    animation: 200,
                    handle: ".drag-handle",
                    group: "groups",
                    onEnd: function() {
                        let order = [];
                        container.querySelectorAll(".group-item").forEach((item, index) => {
                            order.push({
                                id: item.getAttribute("data-group-id"),
                                order: index + 1 // Lưu thứ tự mới (bắt đầu từ 1)
                            });
                        });

                        fetch("{{ route('admin.setting.updateOrder') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            },
                            body: JSON.stringify({ groups: order })
                        });
                    }
                });
            });

            // Kéo & thả field trong nhóm
            document.querySelectorAll(".fields-container").forEach(container => {
                new Sortable(container, {
                    animation: 200,
                    handle: ".drag-handle",
                    group: {
                        name: "fields",
                        pull: false,
                        put: true
                    },
                    onEnd: function() {
                        let groupId = container.getAttribute("data-group-id");
                        let fieldOrder = [];

                        container.querySelectorAll(".field-item").forEach((item, index) => {
                            fieldOrder.push({
                                id: item.getAttribute("data-field-id"),
                                order: index + 1,
                                group_id: groupId
                            });
                        });

                        fetch("{{ route('admin.setting.updateFieldOrder') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            },
                            body: JSON.stringify({ fields: fieldOrder })
                        });
                    }
                });
            });

        });
    </script>
@endsection
