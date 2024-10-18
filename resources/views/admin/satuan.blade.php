@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-">
            <h2 class="mb-4">Satuan</h2>
        </div>
    </div>
</div>

<!-- Add Form (Always Visible) -->
<div class="row justify-content-center mt-3">
    <div class="col-md-11">
        <div class="card">
            <h4 class="card-header">Add New Satuan</h4>
            <div class="card-body">
                <form action="{{ route('add.satuan') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_satuan" class="form-label">Nama Satuan</label>
                        <input type="text" class="form-control" name="nama_satuan" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Satuan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<br>

<!-- Table List -->
<div class="row justify-content-center">
    <div class="card col-md-11">
        <h4 class="card-header">List Satuan</h4>
        <div class="table-responsive p-2">
            <table class="table table-hover">
                <thead class="table">
                    <tr>
                        <th>ID</th>
                        <th>Nama Satuan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($satuan as $s)
                    <tr>
                        <td>{{ $s->idsatuan }}</td>
                        <td>{{ $s->nama_satuan }}</td>
                        <td>{{ $s->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm"
                            onclick="openEditModal('{{ $s->idsatuan }}', '{{ $s->nama_satuan }}', '{{ $s->status }}')">Edit</button>

                            <!-- Delete Button -->
                            <form action="{{ route('destroy.satuan', $s->idsatuan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn rounded-pill btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
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

<!-- Edit Form (Initially Hidden) -->
<div class="row justify-content-center mt-3">
    <div class="collapse col-md-11" id="editForm">
        <div class="card">
            <h4 class="card-header">Edit Satuan</h4>
            <div class="card-body">
                <form action="{{ route('update.satuan', ['id' => $s->idsatuan]) }}" method="POST" id="editSatuanForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_idsatuan" name="idsatuan">
                    <div class="mb-3">
                        <label for="edit_nama_satuan" class="form-label">Nama Satuan</label>
                        <input type="text" class="form-control" id="edit_nama_satuan" name="nama_satuan" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Satuan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, nama_satuan, status) {
    document.getElementById('edit_idsatuan').value = id;
    document.getElementById('edit_nama_satuan').value = nama_satuan;
    document.getElementById('edit_status').value = status;

    // Set the action for the form to point to the correct route
    document.getElementById('editSatuanForm').action = "{{ url('admin/satuan') }}/" + id;
}
</script>

@endsection
