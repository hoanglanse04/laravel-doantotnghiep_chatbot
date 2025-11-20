@php
    $menus = array(
        array(
            'name'  => 'Tổng quan',
            'children'  => array(
                array(
                    'name'  => 'Bảng điều khiển',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12.204c0-2.289 0-3.433.52-4.381c.518-.949 1.467-1.537 3.364-2.715l2-1.241C9.889 2.622 10.892 2 12 2s2.11.622 4.116 1.867l2 1.241c1.897 1.178 2.846 1.766 3.365 2.715S22 9.915 22 12.203v1.522c0 3.9 0 5.851-1.172 7.063S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.212S2 17.626 2 13.725z"/><path stroke-linecap="round" d="M12 15v3"/></g></svg>',
                    'url'   => 'overview'
                ),
            )
        ),
        array(
            'name'  => 'Công cụ',
            'children'  => array(
                array(
                    'name'  => 'Script',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M14.18 4.276a.75.75 0 0 1 .531.918l-3.973 14.83a.75.75 0 0 1-1.45-.389l3.974-14.83a.75.75 0 0 1 .919-.53m2.262 3.053a.75.75 0 0 1 1.059-.056l1.737 1.564c.737.662 1.347 1.212 1.767 1.71c.44.525.754 1.088.754 1.784c0 .695-.313 1.258-.754 1.782c-.42.499-1.03 1.049-1.767 1.711l-1.737 1.564a.75.75 0 0 1-1.004-1.115l1.697-1.527c.788-.709 1.319-1.19 1.663-1.598c.33-.393.402-.622.402-.818s-.072-.424-.402-.817c-.344-.409-.875-.89-1.663-1.598l-1.697-1.527a.75.75 0 0 1-.056-1.06m-8.94 1.06a.75.75 0 1 0-1.004-1.115L4.761 8.836c-.737.662-1.347 1.212-1.767 1.71c-.44.525-.754 1.088-.754 1.784c0 .695.313 1.258.754 1.782c.42.499 1.03 1.049 1.767 1.711l1.737 1.564a.75.75 0 0 0 1.004-1.115l-1.697-1.527c-.788-.709-1.319-1.19-1.663-1.598c-.33-.393-.402-.622-.402-.818s.072-.424.402-.817c.344-.409.875-.89 1.663-1.598z"/></svg>',
                    'url'   => 'script',
                ),
                array(
                    'name'  => 'Tracking',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="m12 9l4.5-4.5m-4.5 10L18.5 8M12 19.5l7.5-7.5M12 22c4.418 0 8-3.646 8-8.143c0-4.462-2.553-9.67-6.537-11.531A3.45 3.45 0 0 0 12 2m0 20c-4.418 0-8-3.646-8-8.143c0-4.462 2.553-9.67 6.537-11.531A3.45 3.45 0 0 1 12 2m0 20V2"/></svg>',
                    'url'   => 'tracking',
                ),
            )
        ),
        array(
            'name'  => 'Cá nhân',
            'children'  => array(
                array(
                    'name'  => 'Thông tin',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 max-h-4 fill-current text-inherit" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 1.25a4.75 4.75 0 1 0 0 9.5a4.75 4.75 0 0 0 0-9.5M8.75 6a3.25 3.25 0 1 1 6.5 0a3.25 3.25 0 0 1-6.5 0M12 12.25c-2.313 0-4.445.526-6.024 1.414C4.42 14.54 3.25 15.866 3.25 17.5v.102c-.001 1.162-.002 2.62 1.277 3.662c.629.512 1.51.877 2.7 1.117c1.192.242 2.747.369 4.773.369s3.58-.127 4.774-.369c1.19-.24 2.07-.605 2.7-1.117c1.279-1.042 1.277-2.5 1.276-3.662V17.5c0-1.634-1.17-2.96-2.725-3.836c-1.58-.888-3.711-1.414-6.025-1.414M4.75 17.5c0-.851.622-1.775 1.961-2.528c1.316-.74 3.184-1.222 5.29-1.222c2.104 0 3.972.482 5.288 1.222c1.34.753 1.961 1.677 1.961 2.528c0 1.308-.04 2.044-.724 2.6c-.37.302-.99.597-2.05.811c-1.057.214-2.502.339-4.476.339s-3.42-.125-4.476-.339c-1.06-.214-1.68-.509-2.05-.81c-.684-.557-.724-1.293-.724-2.601" clip-rule="evenodd"></path></svg>',
                    'url'   => 'profile',
                ),
                array(
                    'name'  => 'Lịch sử giao dịch',
                    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--solar w-4 h-4 max-h-4 fill-current text-inherit" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M12 1.25a4.75 4.75 0 1 0 0 9.5a4.75 4.75 0 0 0 0-9.5M8.75 6a3.25 3.25 0 1 1 6.5 0a3.25 3.25 0 0 1-6.5 0M12 12.25c-2.313 0-4.445.526-6.024 1.414C4.42 14.54 3.25 15.866 3.25 17.5v.102c-.001 1.162-.002 2.62 1.277 3.662c.629.512 1.51.877 2.7 1.117c1.192.242 2.747.369 4.773.369s3.58-.127 4.774-.369c1.19-.24 2.07-.605 2.7-1.117c1.279-1.042 1.277-2.5 1.276-3.662V17.5c0-1.634-1.17-2.96-2.725-3.836c-1.58-.888-3.711-1.414-6.025-1.414M4.75 17.5c0-.851.622-1.775 1.961-2.528c1.316-.74 3.184-1.222 5.29-1.222c2.104 0 3.972.482 5.288 1.222c1.34.753 1.961 1.677 1.961 2.528c0 1.308-.04 2.044-.724 2.6c-.37.302-.99.597-2.05.811c-1.057.214-2.502.339-4.476.339s-3.42-.125-4.476-.339c-1.06-.214-1.68-.509-2.05-.81c-.684-.557-.724-1.293-.724-2.601" clip-rule="evenodd"></path></svg>',
                    'url'   => 'transaction',
                )
            )
        ),
    );
@endphp
<a href="/" class="block mx-auto max-w-max mb-6 mt-2">
    <img width="140" height="50" alt="logo" src="{{ asset('assets/frontend/img/roblox-6.svg') }}">
</a>
<ul class="h-full space-y-1.5 overflow-y-auto mx-6" id="sidebarMenu">
    @php
        use Illuminate\Support\Str;
        $currentUrl = request()->path();
    @endphp

    @foreach ($menus as $menu)
        @php
            $isActiveParent = !empty($menu['url']) && Str::startsWith($currentUrl, 'user/' . trim($menu['url'], '/'));
            $isActiveSubmenu = !empty($menu['children']) && collect($menu['children'])->contains(
                fn($sub) => Str::startsWith($currentUrl, 'user/' . trim($sub['url'], '/'))
            );
            $isActive = $isActiveParent || $isActiveSubmenu;
        @endphp

        <li class="menu-item mt-0.5 w-full">
            @if (!empty($menu['children']))
                <div class="py-1.5 font-semibold text-sm my-0 flex items-center justify-between whitespace-nowrap px-3 text-gray-700">
                    {{ $menu['name'] }}
                </div>
                <ul class="space-y-0.5">
                    @foreach ($menu['children'] as $submenu)
                        @php
                            $subActive = Str::startsWith($currentUrl, 'user/' . trim($submenu['url'], '/'));
                        @endphp
                        <li>
                            <a href="{{ url('user/' . $submenu['url']) }}"
                               class="py-3 flex items-center text-sm font-medium transition hover:bg-[#e7ede7] hover:font-semibold hover:text-gray-950 rounded-full px-3 cursor-pointer
                               {{ $subActive ? 'font-semibold text-gray-950 bg-[#e7ede7]' : 'text-gray-700' }}">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-center stroke-0 text-center p-1">
                                    {!! $submenu['icon'] !!}
                                </div>
                                <span class="ml-2">{{ $submenu['name'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <a href="{{ url('user/' . $menu['url']) }}"
                   class="py-2 font-semibold text-sm my-0 flex items-center whitespace-nowrap px-2 transition hover:bg-[#e7ede7] hover:font-semibold hover:text-gray-950 rounded-full cursor-pointer
                   {{ $isActive ? 'bg-[#e7ede7] font-semibold text-gray-700' : 'text-gray-700' }}">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-center stroke-0 text-center p-2">
                        {!! $menu['icon'] !!}
                    </div>
                    <span class="ml-2"> {{ $menu['name'] }} </span>
                </a>
            @endif
        </li>
    @endforeach
</ul>

