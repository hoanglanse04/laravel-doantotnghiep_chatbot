@unless ($breadcrumbs->isEmpty())
    <div class="breadcrumbs bg-[#faf6f2] font-medium">
        <nav class="max-w-7xl mx-auto px-4 py-5">
            <ol class="rounded flex flex-wrap text-sm space-x-3">
                @foreach ($breadcrumbs as $breadcrumb)
                    @if ($breadcrumb->url && !$loop->last)
                        <li>
                            <a href="{{ $breadcrumb->url }}" class="flex items-center space-x-3 text-[#0b1315] hover:opacity-60">
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><g class="home-outline"><path fill="currentColor" fill-rule="evenodd" d="M10.033 2.883a3 3 0 0 1 3.934 0l7 6.076A3 3 0 0 1 22 11.225V19a3 3 0 0 1-3 3h-3.5a1.5 1.5 0 0 1-1.5-1.5v-6.813h-4V20.5A1.5 1.5 0 0 1 8.5 22H5a3 3 0 0 1-3-3v-7.775a3 3 0 0 1 1.033-2.266zm2.623 1.51a1 1 0 0 0-1.312 0l-7 6.077a1 1 0 0 0-.344.755V19a1 1 0 0 0 1 1h3v-6.313a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2V20h3a1 1 0 0 0 1-1v-7.775a1 1 0 0 0-.345-.755z" class="Vector (Stroke)" clip-rule="evenodd"/></g></svg> --}}
                                <p>{{ $breadcrumb->title }}</p>
                            </a>
                        </li>
                    @else
                        <li class="text-[#0b1315] hover:opacity-60 cursor-default">
                            {{ $breadcrumb->title }}
                        </li>
                    @endif

                    @unless($loop->last)
                        <li class="text-[#0b1315] opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 12 24"><defs><path id="weuiArrowOutlined0" fill="currentColor" d="m7.588 12.43l-1.061 1.06L.748 7.713a.996.996 0 0 1 0-1.413L6.527.52l1.06 1.06l-5.424 5.425z"/></defs><use fill-rule="evenodd" href="#weuiArrowOutlined0" transform="rotate(-180 5.02 9.505)"/></svg>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
@endunless
