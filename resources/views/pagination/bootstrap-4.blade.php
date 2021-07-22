@if ($paginator->hasPages())
    <nav class="clearfix text-center">
        <ul class="pagination pagination- justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item" aria-disabled="true" aria-label="Previous">
                    <span aria-hidden="true" class="page-link rounded-xs color-black bg-theme shadow-l border-0">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link rounded-xs color-black bg-theme shadow-l border-0" rel="prev" aria-label="Previous">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item" aria-disabled="true"><span class="page-link rounded-xs color-black bg-theme shadow-l border-0">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active page-item" aria-current="page"><span class="page-link rounded-xs color-black bg-highlight shadow-l border-0">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link rounded-xs color-black bg-theme shadow-l border-0">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link rounded-xs color-black bg-theme shadow-l border-0" rel="next" aria-label="Next">&rsaquo;</a>
                </li>
            @else
                <li class="page-item" aria-disabled="true" aria-label="Next">
                    <span aria-hidden="true" class="page-link rounded-xs color-black bg-theme shadow-l border-0">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
