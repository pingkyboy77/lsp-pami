
<div class="btn-group gap-2" role="group" aria-label="Profile Section Actions">
    <a href="{{ route('admin.lsp.sections.edit', $item->key) }}" class="btn btn-outline-warning btn-sm rounded">
        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
    </a>
    <button class="btn btn-outline-danger btn-sm rounded btn-delete" data-url="{{ route('admin.lsp.sections.destroy', $item->key) }}">
        <i class="fa-solid fa-trash me-1"></i>Delete
    </button>
</div>