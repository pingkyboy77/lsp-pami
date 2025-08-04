
<div class="btn-group gap-2" role="group" aria-label="License Actions">
    <a href="{{ route('admin.licenses.edit', $license->id) }}" class="btn btn-outline-warning btn-sm rounded">
        <i class="bi bi-pencil-square me-1"></i>Edit
    </a>
    <button class="btn btn-outline-danger btn-sm rounded btn-delete" 
            data-url="{{ route('admin.licenses.destroy', $license->id) }}" 
            data-title="{{ $license->title }}">
        <i class="bi bi-trash me-1"></i>Delete
    </button>
</div>