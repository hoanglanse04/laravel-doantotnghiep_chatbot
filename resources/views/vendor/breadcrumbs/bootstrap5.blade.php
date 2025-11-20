@unless ($breadcrumbs->isEmpty())
    <nav class="container mx-auto" aria-label="breadcrumb">
        <ol class="breadcrumb rounded flex flex-wrap text-sm space-x-3">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li>
                        <a href="{{ $breadcrumb->url }}" class="flex items-center space-x-3 text-[#000000] hover:text-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                                <path d="M12 2.0996094L1 12L4 12L4 21L9 21L9 14L15 14L15 21L20 21L20 12L23 12L19 8.4003906L19 4L17 4L17 6.5996094L12 2.0996094 z" fill="#fff" />
                            </svg>
                            <p>{{ $breadcrumb->title }}</p>
                        </a>
                    </li>
                @else
                    <li class="text-white">
                        {{ $breadcrumb->title }}
                    </li>
                @endif

                @unless($loop->last)
                    <li class="text-gray-200 opacity-80">
                        |
                    </li>
                @endif

            @endforeach
        </ol>
    </nav>
@endunless
