<div class="bg-red-600 text-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 py-6 px-4 gap-6">

        @foreach ($items as $item)
            @php
                $icon = $item->icon ?? '';
            @endphp
            <div class="flex items-center space-x-2">
                <img src="{{ image($item->image) }}"
                    alt="{{ optional(collect($item->custom_fields)->firstWhere('label', 'Dịch vụ'))['value'] ?? '' }}">
                <div>
                    <div class="font-semibold text-lg">
                        {{ optional(collect($item->custom_fields)->firstWhere('label', 'Dịch vụ'))['value'] ?? '' }}
                    </div>
                    <div class="text-md">
                        {{ optional(collect($item->custom_fields)->firstWhere('label', 'Mô tả'))['value'] ?? '' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
