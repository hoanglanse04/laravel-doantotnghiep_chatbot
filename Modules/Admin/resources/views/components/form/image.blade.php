@props([
    'name',
    'value' => null,
    'size' => 'sm',
    'class' => '',
])

@php
    $sizes = [
        'xs' => 'text-xs px-2 py-1',
        'sm' => 'text-sm px-3 py-1.5',
        'md' => 'text-sm px-3 py-2',
        'lg' => 'text-lg px-4 py-3',
        'xl' => 'text-lg px-4 py-4'
    ];

    $sizeClass = ($sizes[$size] ?? $sizes['sm']) . ' ' . $class;
    $imageId = 'preview-' . $name;
    $inputId = 'input-' . $name;
@endphp

<div class="flex items-center space-x-3">
    <!-- Ảnh demo -->
    <img id="{{ $imageId }}"
         src="{{ $value ? asset($value) : asset('assets/frontend/img/image_placeholder.jpg') }}"
         class="w-10 h-10 rounded object-cover border-2 border-gray-200 cursor-pointer"
    >

    <!-- Input chọn ảnh -->
    <label class="cursor-pointer bg-[#56a661] text-white px-3 py-1.5 text-xs rounded">
        Chọn ảnh
        <input type="file" name="{{ $name }}" id="{{ $inputId }}" class="hidden">
    </label>
</div>

<!-- Script xem trước ảnh -->
<script>
    document.getElementById('{{ $inputId }}').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('{{ $imageId }}').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
