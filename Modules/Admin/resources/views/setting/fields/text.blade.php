<div class="w-full space-y-2">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-medium text-gray-700">{{ $field->name }}</label>
        @if (Auth::guard('admin')->user()->role == "superadmin")
            <div class="text-xs bg-gray-100 text-gray-600 px-1 rounded-md">{{ $field->slug }}</div>
        @endif
    </div>
    <input type="text" name="{{ $field->slug }}" value="{{ $field->value }}" placeholder="{{ $field->placeholder }}" class="w-full px-3 py-2 bg-gray-100 rounded-lg text-sm border-2 border-solid border-gray-200">
</div>
