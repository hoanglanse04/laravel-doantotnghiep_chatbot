<div class="flex items-center">
    <input type="checkbox" name="{{ $field->slug }}" value="1" {{ $field->value == 1 ? 'checked' : '' }} class="mr-2">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-medium text-gray-700">{{ $field->name }}</label>
        @if (Auth::guard('admin')->user()->role == "superadmin")
            <div class="text-xs bg-gray-100 text-gray-600 px-1 rounded-md">{{ $field->slug }}</div>
        @endif
    </div>
</div>
