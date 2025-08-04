<div class="btn-group gap-2" role="group" aria-label="Association Actions">
    <a href="{{ route('admin.home.associations.edit', $row->id) }}" class="btn btn-outline-warning btn-sm rounded">
        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
    </a>

    <form method="POST" action="{{ route('admin.home.associations.destroy', $row->id) }}" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-outline-danger btn-sm rounded btn-delete-modal">
            <i class="fa-solid fa-trash me-1"></i>Delete
        </button>
    </form>

</div>
