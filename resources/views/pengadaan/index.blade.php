@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Daftar Pengadaan</h2>
            <a href="{{ route('create.pengadaan') }}" class="btn btn-primary mb-3">Tambah Pengadaan Baru</a>
        </div>
    </div>

    <!-- Table Pengadaan -->
    <div class="row justify-content-center">
        <div class="card col-md-12">
            <h4 class="card-header">Daftar Pengadaan</h4>
            <div class="table-responsive p-2">
                <table class="table table-hover">
                    <thead class="table">
                        <tr>
                            <th>ID Pengadaan</th>
                            <th>Nama User</th>
                            <th>Nama Vendor</th>
                            <th>Status</th>
                            <th>Total Nilai</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengadaans as $pengadaan)
                        <tr>
                            <td>{{ $pengadaan->id_pengadaan }}</td>
                            <td>{{ $pengadaan->nama_user }}</td>
                            <td>{{ $pengadaan->nama_vendor }}</td>
                            <td>{{ $pengadaan->status_pengadaan }}</td>
                            <td>Rp {{ number_format($pengadaan->total, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengadaan->waktu_pengadaan)->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('detail.pengadaan', $pengadaan->id_pengadaan) }}" class="btn rounded-pill btn-warning">Lihat</a>
                                <form action="{{ route('destroy.pengadaan', $pengadaan->id_pengadaan) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengadaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn rounded-pill btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
