@props([
    'items' => [],
    'size' => 'sm', // xs, sm, md, lg, xl
    'variant' => 'flat', // flat, bordered, faded, underlined
    'radius' => 'md', // none, sm, md, lg, full
    'align' => 'left', // left, right, center
    'class' => '',
    'classContainer' => 'uk-inline',
    'classItem' => 'uk-dropdown-item block text-xs !px-4 py-2 !text-gray-700 hover:bg-gray-200 w-full text-left font-medium cursor-pointer'
])

@php
    $sizes = [
        'xs' => 'text-xs py-1',
        'sm' => 'text-sm py-1.5',
        'md' => 'text-md py-2',
        'lg' => 'text-lg py-3',
        'xl' => 'text-xl py-4'
    ];

    $variants = [
        'flat' => 'bg-white border border-gray-200',
        'bordered' => 'border border-gray-400',
        'faded' => 'bg-gray-100 border border-gray-300',
        'underlined' => 'border-b-2 border-gray-400 bg-transparent'
    ];

    $radiusClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'full' => 'rounded-full'
    ];
@endphp

<div class="{{ $classContainer }}">
    <!-- Nút kích hoạt dropdown sẽ được truyền từ slot -->
    {{ $slot }}

    <!-- Nội dung dropdown -->
    <div uk-dropdown="mode: click; pos: bottom-{{ $align }}; animation: uk-animation-scale-up">
        <ul class="uk-nav uk-dropdown-nav">
            @foreach ($items as $item)
                @if(isset($item['divider']) && $item['divider'] === true)
                    <li class="border-t my-2"></li>
                @else
                    <li>
                        @if(isset($item['href']))
                            <a href="{{ $item['href'] }}" class="{{ $classItem }}">
                                @if(isset($item['icon']))
                                    <i class="{{ $item['icon'] }} mr-2"></i>
                                @endif
                                {{ $item['label'] }}
                            </a>
                        @elseif(isset($item['onclick']))
                            <button type="button" onclick="{{ $item['onclick'] }}" class="{{ $classItem }}">
                                @if(isset($item['icon']))
                                    <i class="{{ $item['icon'] }} mr-2"></i>
                                @endif
                                {{ $item['label'] }}
                            </button>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
