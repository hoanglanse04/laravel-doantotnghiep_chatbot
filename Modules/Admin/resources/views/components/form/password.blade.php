@props([
    'name',
    'placeholder' => 'Enter your password',
    'size' => 'sm',
    'class' => ''
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
@endphp

<div class="relative w-full">
    <input
        id="{{ $name }}"
        type="password"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        class="border-2 border-solid border-gray-200 rounded-lg w-full {{ $sizeClass }}"
    />
    <button type="button" onclick="togglePassword('{{ $name }}')" class="absolute right-3 top-2 text-gray-500">
        <span id="toggle-icon-{{ $name }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"></path><path fill="currentColor" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20s7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4S4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"></path></svg>
        </span>
    </button>
</div>
<script>
    function togglePassword(id) {
        const passwordInput = document.getElementById(id);
        const toggleIcon = document.getElementById('toggle-icon-' + id);
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M2.69 6.705a.75.75 0 0 0-1.38.59zm12.897 6.624l-.274-.698zm-6.546.409a.75.75 0 1 0-1.257-.818zm-2.67 1.353a.75.75 0 1 0 1.258.818zM22.69 7.295a.75.75 0 0 0-1.378-.59z"></path></svg>`;
        } else {
            passwordInput.type = 'password';
            toggleIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"></path></svg>`;
        }
    }
</script>
