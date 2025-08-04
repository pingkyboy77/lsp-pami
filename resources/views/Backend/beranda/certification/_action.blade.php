<div class="btn-group gap-2" role="group" aria-label="Certification Actions">
    <a href="{{ route('admin.home.certifications.edit', $item->id) }}" class="btn btn-outline-warning btn-sm rounded">
        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
    </a>
    <button class="btn btn-outline-danger btn-sm rounded btn-delete" data-url="{{ route('admin.home.certifications.destroy', $item->id) }}">
        <i class="fa-solid fa-trash me-1"></i>Delete
    </button>
</div>
