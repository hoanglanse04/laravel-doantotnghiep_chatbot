<div>
    <div class="flex items-center justify-between">
        <label class="block text-xs font-medium text-gray-700">{{ $field->name }}</label>
        @if (Auth::guard('admin')->user()->role == "superadmin")
            <div class="text-xs bg-gray-100 text-gray-600 px-1 rounded-md">{{ $field->slug }}</div>
        @endif
    </div>
    <div class="mt-2">
        @foreach(json_decode($field->options, true) as $key => $option)
            <label class="inline-flex items-center">
                <input type="radio" name="{{ $field->slug }}" value="{{ $key }}"
                       {{ $field->value == $key ? 'checked' : '' }} class="mr-2">
                {{ $option }}
            </label>
        @endforeach
    </div>
</div>
