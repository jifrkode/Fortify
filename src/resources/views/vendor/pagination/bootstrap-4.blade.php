@if ($paginator->hasPages())
    <nav>
        <div class="pagination-container">
            <div class="pagination">
                {{-- "Previous" Link --}}
                @if ($paginator->onFirstPage())
                    <span class="page disabled">&lt;</span>
                @else
                    <a class="page" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lt;</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="page disabled">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="page active">{{ $page }}</span>
                            @else
                                <a class="page" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- "Next" Link --}}
                @if ($paginator->hasMorePages())
                    <a class="page" href="{{ $paginator->nextPageUrl() }}" rel="next">&gt;</a>
                @else
                    <span class="page disabled">&gt;</span>
                @endif
            </div>
        </div>
    </nav>
@endif