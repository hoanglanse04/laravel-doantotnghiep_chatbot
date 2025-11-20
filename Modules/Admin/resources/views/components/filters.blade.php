<div class="flex items-center justify-between gap-4">
    <div class="flex items-center space-x-4">
        <x-admin::form.input
            name="keywords"
            placeholder="Tìm kiếm..."
            value="{{ request(key: 'keywords') }}"
            size="sm"
            class="w-3xs"
        >
            @slot('startContent')
                <div class="absolute inset-y-0 start-1 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            @endslot
        </x-admin::form.input>

        <!-- Dropdown Bulk Actions -->
        <x-admin::form.dropdown
            classContainer="hidden bulk-actions-dropdown"
            size="sm"
            variant="flat"
            radius="md"
            :items="[
                ['label' => 'Xóa các mục đã chọn', 'href' => '#', 'class' => 'text-red-600', 'onclick' => 'bulkDelete()']
            ]"
        >
            <x-admin::form.button
                type="button"
                size="sm"
                variant="primary"
            >
                Hành động
            </x-admin::form.button>
        </x-admin::form.dropdown>
    </div>

    <div class="space-x-2 min-w-max">
        <x-admin::form.button
            type="submit"
            size="sm"
            variant="primary"
        >
            Tìm kiếm
        </x-admin::form.button>
        <x-admin::form.button
            type="reset"
            size="sm"
            variant="secondary"
        >
            Đặt lại
        </x-admin::form.button>
        {{ $content }}
    </div>
</div>
