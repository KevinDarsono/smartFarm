{{-- @if (!empty($breadcrumbs)) --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $label => $link)
                @if (is_int($label) && !is_int($link))
                    <li class="breadcrumb-item">{{ $link }}</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ $link }}">{{ $label }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>
{{-- @endif --}}
