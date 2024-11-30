@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Roles</h2>
        </div>
    </div>

    <!-- Add Form (Always Visible) -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-11">
            <div class="card">
                <h4 class="card-header">Add New Role</h4>
                <div class="card-body">
                    <form action="{{ route('add.role') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_role" class="form-label">Role Name</label>
                            <input type="text" class="form-control" name="nama_role" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <!-- Table List -->
    <div class="row justify-content-center">
        <div class="card col-md-11">
            <h4 class="card-header">List Roles</h4>
            <div class="table-responsive p-2">
                <table class="table table-hover">
                    <thead class="table">
                        <tr>
                            <th>ID</th>
                            <th>Role Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->idrole }}</td>
                            <td>{{ $role->nama_role }}</td>
                            <td>
                                <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm{{ $role->idrole }}">Edit</button>

                                <!-- Delete Button -->
                                <form action="{{ route('destroy.role', $role->idrole) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn rounded-pill btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Form for Each Role (Outside Table) -->
                        <div class="collapse mt-4" id="editForm{{ $role->idrole }}">
                            <div class="card">
                                <h4 class="card-header">Edit Role</h4>
                                <div class="card-body">
                                    <form action="{{ route('update.role', ['id' => $role->idrole]) }}" method="POST" id="editRoleForm{{ $role->idrole }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="edit_idrole{{ $role->idrole }}" name="idrole" value="{{ $role->idrole }}">
                                        <div class="mb-3">
                                            <label for="edit_nama_role{{ $role->idrole }}" class="form-label">Role Name</label>
                                            <input type="text" class="form-control" id="edit_nama_role{{ $role->idrole }}" name="nama_role" value="{{ $role->nama_role }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Update Role</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Open the edit modal and prefill the fields when the Edit button is clicked
    function openEditModal(id, nama_role) {
        document.getElementById('edit_idrole' + id).value = id;
        document.getElementById('edit_nama_role' + id).value = nama_role;

        // Set the action for the form to point to the correct route
        document.getElementById('editRoleForm' + id).action = "{{ url('admin/role') }}/" + id;
    }
</script>

@endsection
