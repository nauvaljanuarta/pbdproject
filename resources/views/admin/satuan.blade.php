@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Satuan</h2>
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
                                <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm{{ $s->idsatuan }}">Edit</button>

                                <!-- Delete Button -->
                                <form action="{{ route('destroy.satuan', $s->idsatuan) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn rounded-pill btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Form for Each Satuan (Outside Table) -->
                        <div class="collapse mt-4" id="editForm{{ $s->idsatuan }}">
                            <div class="card">
                                <h4 class="card-header">Edit Satuan</h4>
                                <div class="card-body">
                                    <form action="{{ route('update.satuan', ['id' => $s->idsatuan]) }}" method="POST" id="editSatuanForm{{ $s->idsatuan }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="edit_idsatuan{{ $s->idsatuan }}" name="idsatuan" value="{{ $s->idsatuan }}">
                                        <div class="mb-3">
                                            <label for="edit_nama_satuan{{ $s->idsatuan }}" class="form-label">Nama Satuan</label>
                                            <input type="text" class="form-control" id="edit_nama_satuan{{ $s->idsatuan }}" name="nama_satuan" value="{{ $s->nama_satuan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_status{{ $s->idsatuan }}" class="form-label">Status</label>
                                            <select class="form-control" id="edit_status{{ $s->idsatuan }}" name="status" required>
                                                <option value="1" {{ $s->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $s->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-warning">Update Satuan</button>
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
    function openEditModal(id, nama_satuan, status) {
        document.getElementById('edit_idsatuan' + id).value = id;
        document.getElementById('edit_nama_satuan' + id).value = nama_satuan;
        document.getElementById('edit_status' + id).value = status;

        // Set the action for the form to point to the correct route
        document.getElementById('editSatuanForm' + id).action = "{{ url('admin/satuan') }}/" + id;
    }
</script>

@endsection
