@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Barang</h2>
        </div>
    </div>
</div>

<!-- Add Form (Always Visible) -->
<div class="row justify-content-center mt-3">
    <div class="col-md-11">
        <div class="card">
            <h4 class="card-header">Add New Barang</h4>
            <div class="card-body">
                <form action="{{ route('add.barang') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <select class="form-control" name="jenis" required>
                            <option value="A">Type A</option>
                            <option value="B">Type B</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="idsatuan" class="form-label">Satuan</label>
                        <select class="form-control" name="idsatuan" required>
                            @foreach($satuans as $s)
                                <option value="{{ $s->idsatuan }}">{{ $s->nama_satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Barang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<br>

<!-- Table List -->
<div class="row justify-content-center">
    <div class="card col-md-11">
        <h4 class="card-header">List Barang</h4>
        <div class="table-responsive p-2">
            <table class="table table-hover">
                <thead class="table">
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $b)
                    <tr>
                        <td>{{ $b->idbarang }}</td>
                        <td>{{ $b->nama }}</td>
                        <td>{{ $b->jenis }}</td>
                        <td>
                            @php
                                $nama_satuan = collect($satuans)->firstWhere('idsatuan', $b->idsatuan)->nama_satuan ?? 'Tidak Ditemukan';
                            @endphp
                            {{ $nama_satuan }}
                        </td>
                        <td>{{ $b->harga }}</td>
                        <td>{{ $b->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm{{ $b->idbarang }}"
                            onclick="openEditModal('{{ $b->idbarang }}', '{{ $b->nama }}', '{{ $b->jenis }}', '{{ $b->idsatuan }}', '{{ $b->harga }}', '{{ $b->status }}')">Edit</button>

                            <!-- Delete Button -->
                            <form action="{{ route('destroy.barang', $b->idbarang) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn rounded-pill btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Form (Hidden) -->
                    <div class="collapse mt-4" id="editForm{{ $b->idbarang }}">
                        <div class="card">
                            <h4 class="card-header">Edit Barang</h4>
                            <div class="card-body">
                                <form action="{{ route('update.barang', $b->idbarang) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="idbarang" value="{{ $b->idbarang }}">
                                    <div class="mb-3">
                                        <label for="edit_nama{{ $b->idbarang }}" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" name="nama" value="{{ $b->nama }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_jenis{{ $b->idbarang }}" class="form-label">Jenis</label>
                                        <select class="form-control" name="jenis" required>
                                            <option value="A" {{ $b->jenis == 'A' ? 'selected' : '' }}>Type A</option>
                                            <option value="B" {{ $b->jenis == 'B' ? 'selected' : '' }}>Type B</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_idsatuan{{ $b->idbarang }}" class="form-label">Satuan</label>
                                        <select class="form-control" name="idsatuan" required>
                                            @foreach($satuans as $s)
                                                <option value="{{ $s->idsatuan }}" {{ $b->idsatuan == $s->idsatuan ? 'selected' : '' }}>{{ $s->nama_satuan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_harga{{ $b->idbarang }}" class="form-label">Harga</label>
                                        <input type="number" class="form-control" name="harga" value="{{ $b->harga }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_status{{ $b->idbarang }}" class="form-label">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="1" {{ $b->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $b->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Update Barang</button>
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
