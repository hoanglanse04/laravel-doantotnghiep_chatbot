@props([
    'title' => '',
    'description' => '',
    'colSpan' => 'col-span-12 lg:col-span-6',
    'icon' => '',
    'route' => '',
])

<div class="lg:grid grid-cols-7 gap-4 lg:gap-6 bg-white rounded-2xl shadow-md p-4 lg:p-6 flex flex-col items-center justify-center {{ $colSpan }}">
    <div class="col-span-1 p-2 lg:p-4 h-fit bg-[#e2e2e2] rounded-lg">
        {{ $icon ?? '' }}
    </div>
    <div class="col-span-6 lg:space-y-4 space-y-2">
        <h2 class="lg:text-xl text-base line-clamp-1 font-bold text-start">{{ $title }}</h2>
        <p class="lg:line-clamp-3 lg:h-[72px] lg:text-base text-sm text-gray-500 lg:font-semibold text-start">{{ $description }}</p>
        <a href="{{ $route }}" class="flex items-center gap-2 text-base font-semibold hover:underline">
            Xem thêm
        </a>
    </div>
</div>
