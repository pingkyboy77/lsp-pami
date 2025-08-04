
<div class="btn-group gap-2" role="group" aria-label="User Actions">
    <button class="btn btn-outline-warning btn-sm rounded editUser" data-id="{{ $row->id }}">
        <i class="fa-solid fa-pen-to-square me-1"></i>Edit
    </button>
    <button class="btn btn-outline-danger btn-sm rounded deleteUser" data-id="{{ $row->id }}">
        <i class="fa-solid fa-trash me-1"></i>Delete
    </button>
</div>

