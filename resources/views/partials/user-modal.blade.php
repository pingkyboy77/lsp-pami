<!-- Modal Tambah/Edit User -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="userForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="userId">

                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3" id="passwordSection">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password-input" class="form-control"
                                placeholder="The password must be at least 8 characters." minlength="8">
                            <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                                <i class="fa-solid fa-eye" id="eye-icon"></i>
                            </span>
                        </div>
                        <small class="text-muted" id="password-note"></small>
                    </div>

                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">-- Choose Role --</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
