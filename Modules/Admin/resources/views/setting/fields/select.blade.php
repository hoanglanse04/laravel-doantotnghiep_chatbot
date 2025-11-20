<div class="space-y-2 w-full">
    <div class="flex items-center justify-between">
        <label class="block text-xs font-medium text-gray-700">{{ $field->name }}</label>
        @if (Auth::guard('admin')->user()->role == "superadmin")
            <div class="text-xs bg-gray-100 text-gray-600 px-1 rounded-md">{{ $field->slug }}</div>
        @endif
    </div>
    <select name="{{ $field->slug }}" class="w-full p-2 border-2 border-solid border-gray-200 rounded-lg text-sm">
        @foreach(json_decode($field->options, true) as $key => $option)
            <option value="{{ $key }}" {{ $field->value == $key ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    </select>
</div>
