@php
    $filters = [
        'per_page' => request('per_page', 20),
        'status' => request('status', ''),
    ];

    $headers = ['Tên khách hàng', 'Số điện thoại', 'Email', 'Nội dung', 'Liên kết', 'Trạng thái', 'Ngày tạo', 'Hành động'];
@endphp

@extends('admin::layouts.master')
@section('title', 'Danh sách Liên hệ')

@section('content')
    <div class="flex items-center justify-between space-x-4 mb-4">
        <h1>Danh sách Liên hệ</h1>
        <a href="{{ route('admin.contact.create') }}"
           class="text-sm text-white font-medium bg-[#56a661] hover:shadow-md transition px-6 py-2.5 rounded-full cursor-pointer">
            Thêm mới
        </a>
    </div>

    <x-admin::table :headers="$headers" :rows="$data">
        <x-slot:filters>
            <x-admin::filters>
                <x-slot:content>
                    <x-admin::form.select
                        size="sm"
                        name="status"
                        :selected="$filters['status']"
                        :options="array_merge(['' => 'Chọn trạng thái'], collect(\App\Enums\Common::getStatuses())->mapWithKeys(fn($status) => [$status->value => $status->label()])->toArray())"
                    />
                    <x-admin::form.select
                        size="sm"
                        name="per_page"
                        :selected="$filters['per_page']"
                        :options="[
                            '20' => '20 bản ghi',
                            '50' => '50 bản ghi',
                            '100' => '100 bản ghi',
                            '200' => '200 bản ghi'
                        ]"
                    />
                </x-slot:content>
            </x-admin::filters>
        </x-slot:filters>

        <x-slot:tbody>
            @foreach($data as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-center">
                        <input type="checkbox" name="id[]" value="{{ $row->id }}" class="checkbox w-4 h-4 cursor-pointer text-[#56a661] bg-gray-100 border-gray-300 rounded-sm focus:ring-[#56a661] focus:ring-2">
                    </td>
                    <td class="px-4 py-4 text-sm">
                        <a href="{{ route('admin.contact.show', $row->id) }}" class="text-gray-700">
                            <p>{{ $row->name }}</p>
                        </a>
                    </td>
                    <td class="px-4 py-2 text-xs">{{ $row->phone ?: 'N/A' }}</td>
                    <td class="px-4 py-2 text-xs">{{ $row->email ?: 'N/A' }}</td>
                    <td class="px-4 py-2 text-xs">{{ $row->content }}</td>
                    <td class="px-4 py-2 text-xs">{{ $row->url }}</td>
                    <td class="px-4 py-2 text-xs">{{ $row->status }}</td>
                    <td class="px-4 py-2 text-xs">{{ $row->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <x-admin::form.dropdown
                            size="xs"
                            classContainer="mx-auto text-center block max-w-max"
                            :items="[
                                ['label' => 'Chỉnh sửa', 'href' => route('admin.contact.edit', $row->id)],
                                ['label' => 'Xóa', 'onclick' => 'deleteResource('.$row->id.', \'contact\')', 'class' => 'text-red-600']
                            ]"
                        >
                            <x-admin::form.button
                                type="button"
                                size="md"
                                variant="default"
                                class="!bg-transparent hover:!bg-gray-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" class="iconify iconify--solar w-4 fill-current text-gray-500" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd" d="M2.25 12a2.75 2.75 0 1 1 5.5 0a2.75 2.75 0 0 1-5.5 0M5 10.75a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5M9.25 12a2.75 2.75 0 1 1 5.5 0a2.75 2.75 0 0 1-5.5 0M12 10.75a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5m7-1.5a2.75 2.75 0 1 0 0 5.5a2.75 2.75 0 0 0 0-5.5M17.75 12a1.25 1.25 0 1 1 2.5 0a1.25 1.25 0 0 1-2.5 0" clip-rule="evenodd"></path>
                                </svg>
                            </x-admin::form.button>
                        </x-admin::form.dropdown>
                    </td>
                </tr>
            @endforeach
        </x-slot:tbody>

    </x-admin::table>
@endsection
