<div class="w-full space-y-2">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-medium text-gray-700">{{ $field->name }}</label>
        @if (Auth::guard('admin')->user()->role == "superadmin")
            <div class="text-xs bg-gray-100 text-gray-600 px-1 rounded-md">{{ $field->slug }}</div>
        @endif
    </div>
    <textarea name="{{ $field->slug }}" class="w-full min-h-10 p-2 bg-gray-100 rounded-lg text-sm border-2 border-solid border-gray-200" placeholder="{{ $field->placeholder }}">{{ $field->value }}</textarea>
</div>
