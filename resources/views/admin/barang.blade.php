@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-">
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
                {{-- <form action="{{ route('add.barang') }}" method="POST"> --}}
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
                            @foreach($satuan as $s)
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
                    @foreach($barang as $b)
                    <tr>
                        <td>{{ $b->idbarang }}</td>
                        <td>{{ $b->nama }}</td>
                        <td>{{ $b->jenis }}</td>
                        <td>
                            @php
                                $nama_satuan = collect($satuan)->firstWhere('idsatuan', $b->idsatuan)->nama_satuan ?? 'Tidak Ditemukan';
                            @endphp
                            {{ $nama_satuan }}
                        </td>
                        <td>{{ $b->harga }}</td>
                        <td>{{ $b->status == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="collapse" data-bs-target="#editForm"
                            onclick="openEditModal('{{ $b->idbarang }}', '{{ $b->nama }}', '{{ $b->jenis }}', '{{ $b->idsatuan }}', '{{ $b->harga }}', '{{ $b->status }}')">Edit</button>

                            {{-- <form action="{{ route('destroy.barang', $b->idbarang) }}" method="POST" style="display:inline;"> --}}
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
    </div>
</div>
@endsection
