@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Margin Penjualan</h2>
        </div>
    </div>

    <!-- Add Form (Always Visible) -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-11">
            <div class="card">
                <h4 class="card-header">Add New Margin</h4>
                <div class="card-body">
                    <form action="{{ route('add.margin') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="persen" class="form-label">Persen Margin (%)</label>
                            <input type="number" step="0.01" class="form-control" name="persen" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Margin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <!-- Table List -->
    <div class="row justify-content-center">
        <div class="card col-md-11">
            <h4 class="card-header">List Margin Penjualan</h4>
            <div class="table-responsive p-2">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Persen</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($margins as $margin)
                        <tr>
                            <td>{{ $margin->idmargin_penjualan }}</td>
                            <td>{{ $margin->user_name }}</td>
                            <td>{{ $margin->persen }}%</td>
                            <td>{{ $margin->status == 1 ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $margin->created_at }}</td>
                            <td>{{ $margin->updated_at }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm{{ $margin->idmargin_penjualan }}">Edit</button>

                                <!-- Delete Button -->
                                <form action="{{ route('destroy.margin', $margin->idmargin_penjualan) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn rounded-pill btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Form for Each Margin (Outside Table) -->
                        <div class="collapse mt-4" id="editForm{{ $margin->idmargin_penjualan }}">
                            <div class="card">
                                <h4 class="card-header">Edit Margin</h4>
                                <div class="card-body">
                                    <form action="{{ route('update.margin', ['id' => $margin->idmargin_penjualan]) }}" method="POST" id="editForm{{ $margin->idmargin_penjualan }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="idmargin_penjualan" value="{{ $margin->idmargin_penjualan }}">
                                        <div class="mb-3">
                                            <label for="iduser" class="form-label">User</label>
                                            <select class="form-control" name="iduser" required>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->iduser }}" {{ $margin->iduser == $user->iduser ? 'selected' : '' }}>
                                                        {{ $user->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="persen" class="form-label">Persen Margin (%)</label>
                                            <input type="number" step="0.01" class="form-control" name="persen" value="{{ $margin->persen }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control" name="status" required>
                                                <option value="1" {{ $margin->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $margin->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Update Margin</button>
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
    function openEditModal(id, iduser, persen, status) {
        // Isi input dengan data dari parameter
        document.getElementById('edit_idmargin' + id).value = id;
        document.getElementById('edit_iduser' + id).value = iduser;
        document.getElementById('edit_persen' + id).value = persen;
        document.getElementById('edit_status' + id).value = status;

        // Set the action form untuk update
        document.getElementById('editForm' + id).action = "{{ url('admin/margin') }}/" + id;
    }
</script>

@endsection
