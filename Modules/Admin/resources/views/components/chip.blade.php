@props([
    'status', // string hoặc enum
])

@php
    use App\Enums\Common;

    $value = strtolower($status);

    try {
        $enum = Common::from($value);
        $label = $enum->label();
    } catch (\ValueError $e) {
        $enum = null;
        $label = ucfirst($value);
    }

    $color = match ($enum) {
        // STATUS
        Common::ACTIVE => 'bg-green-100 text-green-800',
        Common::INACTIVE => 'bg-red-100 text-red-800',
        Common::DRAFT => 'bg-yellow-100 text-yellow-800',
        Common::PUBLISHED => 'bg-green-100 text-green-800',
        Common::ARCHIVED => 'bg-gray-200 text-gray-800',

        // GENDER
        Common::MALE => 'bg-blue-100 text-blue-800',
        Common::FEMALE => 'bg-pink-100 text-pink-800',
        Common::OTHER => 'bg-purple-100 text-purple-800',

        default => 'bg-gray-100 text-gray-600',
    };
@endphp

<span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $color }}">
    {{ $label }}
</span>
