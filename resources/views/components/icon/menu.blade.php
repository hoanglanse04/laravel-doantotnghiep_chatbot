@props([
    'w' => '20',
    'h' => '20',
    'fill' => 'none',
    'stroke' => 'currentColor',
    'class' => ''
])

<svg xmlns="http://www.w3.org/2000/svg" class="{{ $class }}" width="{{ $w }}" height="{{ $h }}" viewBox="0 0 24 24"><path fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-linecap="round" stroke-width="1.5" d="M20 7H4m16 5H4m16 5H4"/></svg>