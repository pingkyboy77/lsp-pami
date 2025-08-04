<!-- resources/views/admin/peserta-sertifikat/_action.blade.php -->
<div class="btn-group">
    <a href="{{ route('admin.peserta-sertifikat.edit', $row->id) }}" class="btn btn-outline-warning btn-sm rounded"><i class="bi bi-pencil-square me-1"></i>Edit</a>
    <form action="{{ route('admin.peserta-sertifikat.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-outline-danger btn-sm rounded btn-delete"><i class="bi bi-trash me-1"></i>Delete</button>
    </form>
</div>
