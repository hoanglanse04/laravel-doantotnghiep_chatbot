@extends('user::layouts.master')

@section('content')

<div class="space-y-6">
    <div class="flex items-center justify-between text-xl">
        <h2 class="font-semibold text-xl"> Thông tin cơ bản </h2>
    </div>

    <ul class="grid grid-cols-5 gap-6 ml-4">
        <li>
            <div class="uppercase font-semibold text-xs text-gray-600">ID</div>
            <span class="font-semibold mt-1 line-clamp-2">{{ $user->id }}</span>
        </li>
        <li>
            <div class="uppercase font-semibold text-xs text-gray-600">Email</div>
            <span class="font-semibold mt-1 line-clamp-2">{{ $user->email }}</span>
        </li>
        <li>
            <div class="uppercase font-semibold text-xs text-gray-600">Họ và tên</div>
            <span class="font-semibold mt-1 line-clamp-2">{{ $user->name }}</span>
        </li>
        <li>
            <div class="uppercase font-semibold text-xs text-gray-600">Ngày tham gia</div>
            <span class="font-semibold mt-1 line-clamp-2">{{ $user->created_at }}</span>
        </li>
    </ul>
</div>
@endsection
