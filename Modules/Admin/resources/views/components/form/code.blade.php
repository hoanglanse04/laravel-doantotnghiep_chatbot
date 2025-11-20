@props([
    'name',
    'placeholder' => '',
    'description' => '',
    'value' => '',
    'height' => '200px',
    'class' => '',
    'theme' => 'github',
    'mode' => 'html',
])

@php
    $inputId = 'ace_editor_' . uniqid();
    $hiddenInputId = 'hidden_input_' . uniqid();
@endphp

<div class="relative {{ $class }}">
    <div id="{{ $inputId }}" style="height: {{ $height }};" class="border rounded ace-editor"></div>
    <input type="hidden" name="{{ $name }}" id="{{ $hiddenInputId }}" value="{{ old($name, $value) }}">

    @if ($description)
        <p class="text-xs mt-1 text-gray-500">{{ $description }}</p>
    @endif

    @if ($errors->has($name))
        <p class="text-red-500 text-xs mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>

@push('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log(1)
            const editor = ace.edit("{{ $inputId }}");
            editor.setTheme("ace/theme/{{ $theme }}");
            editor.session.setMode("ace/mode/{{ $mode }}");
            editor.setValue(@json(old($name, $value)));
            editor.session.setUseWorker(false);

            const hiddenInput = document.getElementById("{{ $hiddenInputId }}");
            editor.session.on('change', function () {
                hiddenInput.value = editor.getValue();
            });
        });
    </script>
@endpush
