@props([
    'w' => '20',
    'h' => '20',
    'fill' => 'none',
    'stroke' => '',
    'class' => ''
])

<svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" width="{{ $w }}" height="{{ $h }}" viewBox="0 0 24 24"><g fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8m0 0l-3-3m3 3l-3 3"/></g></svg>