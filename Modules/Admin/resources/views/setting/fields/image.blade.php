<div class="w-full space-y-2">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-medium text-gray-700">{{ $field->name }}</label>
        @if (Auth::guard('admin')->user()->role == "superadmin")
            <div class="text-xs bg-gray-100 text-gray-600 px-1 rounded-md">{{ $field->slug }}</div>
        @endif
    </div>
    <!-- Ảnh demo -->
    <div class="flex items-center space-x-3">
        <img id="preview-{{ $field->slug }}" src="{{ $field->value ? $field->value : asset('assets/frontend/img/image_placeholder.jpg') }}" class="w-10 h-10 rounded object-cover border-2 border-gray-200 cursor-pointer">

        <label class="cursor-pointer bg-[#56a661] text-white px-3 py-1.5 text-xs rounded">
            Chọn ảnh
            <input type="file" name="{{ $field->slug }}" id="input-{{ $field->slug }}" class="hidden" accept="image/*">
        </label>
    </div>
</div>

<script>
    document.getElementById('input-{{ $field->slug }}').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-{{ $field->slug }}').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
