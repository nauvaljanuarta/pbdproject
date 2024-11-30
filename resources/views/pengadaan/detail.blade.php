@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Pengadaan Barang</h2>
        </div>
    </div>

    <!-- Form Pengadaan -->
    <div class="row justify-content-center mt-3">
        <div class="col-md-11">
            <div class="card">
                <h4 class="card-header">Tambah Pengadaan Baru</h4>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="supplier" class="form-label">Supplier</label>
                            <select class="form-control" name="supplier_id" required>
                                @foreach
                                    <option value=""></option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                            <input type="date" class="form-control" name="tanggal_pengadaan" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="1">Pending</option>
                                <option value="2">Selesai</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah Pengadaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Pengadaan -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-11">
            <div class="card">
                <h4 class="card-header">Detail Pengadaan</h4>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Barang</label>
                            <select class="form-control" name="barang_id" required>
                                @foreach
                                    <option value=""></option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga_satuan" class="form-label">Harga Satuan</label>
                            <input type="number" class="form-control" name="harga_satuan" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah Barang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Pengadaan -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-11">
            <div class="card">
                <h4 class="card-header">Daftar Pengadaan Barang</h4>
                <div class="table-responsive p-2">
                    <table class="table table-hover">
                        <thead class="table">
                            <tr>
                                <th>ID Pengadaan</th>
                                <th>Supplier</th>
                                <th>Tanggal Pengadaan</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach()
                            <tr>
                                <td>{{ }}</td>
                                <td>{{  }}</td>
                                <td>{{  }}</td>
                                <td>{{  }}</td>
                                <td>{{  }}</td>
                                <td>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editPengadaanModal{{  }}">Edit</button>

                                    <!-- Delete Form -->
                                    <form action="" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editPengadaanModal{{  }}" tabindex="-1" aria-labelledby="editPengadaanLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPengadaanLabel">Edit Pengadaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="edit_supplier" class="form-label">Supplier</label>
                                                    <select class="form-control" name="supplier_id">
                                                        @foreach()
                                                            <option value="{{ }}" {{  }}>{{ }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="edit_tanggal_pengadaan" class="form-label">Tanggal Pengadaan</label>
                                                    <input type="date" class="form-control" name="tanggal_pengadaan" value="{{  }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="edit_status" class="form-label">Status</label>
                                                    <select class="form-control" name="status">
                                                        <option value="1" {{  }}>Pending</option>
                                                        <option value="2" {{     '' }}>Selesai</option>
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-warning">Update Pengadaan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
