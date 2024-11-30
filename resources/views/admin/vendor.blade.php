@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Vendor</h2>
        </div>
    </div>
</div>

<!-- Add Form (Always Visible) -->
<div class="row justify-content-center mt-3">
    <div class="col-md-11">
        <div class="card">
            <h4 class="card-header">Add New Vendor</h4>
            <div class="card-body">
                <form action="{{ route('add.vendor') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_vendor" class="form-label">Nama Vendor</label>
                        <input type="text" class="form-control" name="nama_vendor" required>
                    </div>
                    <div class="mb-3">
                        <label for="badan_hukum" class="form-label">Badan Hukum</label>
                        <select class="form-control" name="badan_hukum" required>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="A">Active</option>
                            <option value="I">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<br>

<!-- Table List -->
<div class="row justify-content-center">
    <div class="card col-md-11">
        <h4 class="card-header">List Vendor</h4>
        <div class="table-responsive p-2">
            <table class="table table-hover">
                <thead class="table">
                    <tr>
                        <th>ID</th>
                        <th>Nama Vendor</th>
                        <th>Badan Hukum</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $v)
                    <tr>
                        <td>{{ $v->idvendor }}</td>
                        <td>{{ $v->nama_vendor }}</td>
                        <td>{{ $v->badan_hukum == 'Y' ? 'Yes' : 'No' }}</td>
                        <td>{{ $v->status == 'A' ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm{{ $v->idvendor }}"
                            onclick="openEditModal('{{ $v->idvendor }}', '{{ $v->nama_vendor }}', '{{ $v->badan_hukum }}', '{{ $v->status }}')">Edit</button>

                            <!-- Delete Button -->
                            <form action="{{ route('destroy.vendor', $v->idvendor) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn rounded-pill btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Form (Hidden) -->
                    <div class="collapse mt-4" id="editForm{{ $v->idvendor }}">
                        <div class="card">
                            <h4 class="card-header">Edit Vendor</h4>
                            <div class="card-body">
                                <form action="{{ route('update.vendor', $v->idvendor) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="idvendor" value="{{ $v->idvendor }}">
                                    <div class="mb-3">
                                        <label for="edit_nama_vendor{{ $v->idvendor }}" class="form-label">Nama Vendor</label>
                                        <input type="text" class="form-control" name="nama_vendor" value="{{ $v->nama_vendor }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_badan_hukum{{ $v->idvendor }}" class="form-label">Badan Hukum</label>
                                        <select class="form-control" name="badan_hukum" required>
                                            <option value="Y" {{ $v->badan_hukum == 'Y' ? 'selected' : '' }}>Yes</option>
                                            <option value="N" {{ $v->badan_hukum == 'N' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_status{{ $v->idvendor }}" class="form-label">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="A" {{ $v->status == 'A' ? 'selected' : '' }}>Active</option>
                                            <option value="I" {{ $v->status == 'I' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Update Vendor</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
