<div class="border-2 border-solid border-[#f7f9f7] rounded-lg">
    <div class="flex flex-col relative gap-4 w-full">
        <form method="GET" enctype="multipart/form-data" class="p-4 z-0 flex flex-col relative justify-between gap-4 bg-white overflow-auto rounded-2xl shadow-sm w-full">
            {{-- Bộ lọc --}}
            {{ $filters ?? '' }}

            {{-- Bảng dữ liệu --}}
            <table class="min-w-full h-auto table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-[#f2f5f1] text-left text-gray-600 uppercase text-sm">
                        <th class="w-10 px-4 py-3 text-xs font-semibold whitespace-nowrap rounded-l-lg">
                            <input id="select-all" type="checkbox" class="w-4 h-4 cursor-pointer text-[#56a661] bg-gray-100 border-gray-300 rounded-sm focus:ring-[#56a661] focus:ring-2">
                        </th>
                        @foreach($headers as $header)
                            <th class="px-4 py-3 text-xs font-semibold whitespace-nowrap @if ($loop->last) rounded-r-lg text-center @endif">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{ $tbody ?? '' }}
                </tbody>
            </table>

            {{-- Phân trang --}}
            <div class="flex justify-between items-center py-1 px-1">
                <div class="text-sm text-gray-600">
                    Hiển thị {{ $rows->firstItem() ?? 0 }} - {{ $rows->lastItem() ?? 0 }} trên tổng số {{ $rows->total() }} bản ghi
                </div>
                {{ $rows->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
