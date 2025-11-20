@props([
    'w' => '20',
    'h' => '20',
    'fill' => 'none',
    'stroke' => '#2C2C2C',
    'class' => ''
])

<svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" width="{{ $w }}" height="{{ $h }}" viewBox="0 0 24 24"><g fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="1.5"><circle cx="11.5" cy="11.5" r="9.5"/><path stroke-linecap="round" d="m20 20l2 2"/></g></svg>