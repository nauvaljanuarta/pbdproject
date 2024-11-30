@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Users</h2>
        </div>
    </div>

    <!-- Add Form (Always Visible) -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-11">
            <div class="card">
                <h4 class="card-header">Add New User</h4>
                <div class="card-body">
                    <form action="{{ route('add.user') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="idrole" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->idrole }}">{{ $role->nama_role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <!-- Table List -->
    <div class="row justify-content-center">
        <div class="card col-md-11">
            <h4 class="card-header">List Users</h4>
            <div class="table-responsive p-2">
                <table class="table table-hover">
                    <thead class="table">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->iduser }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->role->nama_role }}</td>
                            <td>
                                <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm{{ $user->iduser }}">Edit</button>

                                <!-- Delete Button -->
                                <form action="{{ route('destroy.user', $user->iduser) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn rounded-pill btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Form for Each User (Outside Table) -->
                        <div class="collapse mt-4" id="editForm{{ $user->iduser }}">
                            <div class="card">
                                <h4 class="card-header">Edit User</h4>
                                <div class="card-body">
                                    <form action="{{ route('update.user', ['id' => $user->iduser]) }}" method="POST" id="editUserForm{{ $user->iduser }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="edit_iduser{{ $user->iduser }}" name="iduser" value="{{ $user->iduser }}">
                                        <div class="mb-3">
                                            <label for="edit_username{{ $user->iduser }}" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="edit_username{{ $user->iduser }}" name="username" value="{{ $user->username }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_password{{ $user->iduser }}" class="form-label">Password (Leave empty to keep current)</label>
                                            <input type="password" class="form-control" id="edit_password{{ $user->iduser }}" name="password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_role{{ $user->iduser }}" class="form-label">Role</label>
                                            <select name="idrole" class="form-control" id="edit_role{{ $user->iduser }}" required>
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->idrole }}" {{ $role->idrole == $user->idrole ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Update User</button>
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
    function openEditModal(id, username, role_id) {
        document.getElementById('edit_iduser' + id).value = id;
        document.getElementById('edit_username' + id).value = username;

        // Set the action for the form to point to the correct route
        document.getElementById('editUserForm' + id).action = "{{ url('admin/user') }}/" + id;

        // Set the role dropdown selected value
        document.getElementById('edit_role' + id).value = role_id;
    }
</script>

@endsection
