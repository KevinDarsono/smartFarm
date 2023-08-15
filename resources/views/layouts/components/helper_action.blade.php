@if ($show)
    <a class='btn btn-sm btn-info' href="{{ route($route.'.show', $id) }}"><i class="bi bi-eye"></i></a>
@endif
@if ($edit)
    <a class='btn btn-sm btn-primary' href="{{ route($route.'.edit', $id) }}"><i class="bi bi-pencil-square"></i></a>
@endif
@if ($delete)
    <form id="delete-{{ $id }}" action="{{ route($route.'.destroy', $id) }}" method="POST" style="display: inline">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-sm btn-danger text-white">
            <i class="bi bi-archive"></i>
        </button>
    </form>
@endif
