@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Navigasi halaman">
        <ul>
            {{-- Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li><span class="page disabled" aria-disabled="true"><i class="bi bi-chevron-left"></i></span></li>
            @else
                <li>
                    <a class="page" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="page disabled" aria-disabled="true">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="page active" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a class="page" href="{{ $url }}" aria-label="Ke halaman {{ $page }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Berikutnya --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="page" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li><span class="page disabled" aria-disabled="true"><i class="bi bi-chevron-right"></i></span></li>
            @endif
        </ul>
    </nav>
@endif