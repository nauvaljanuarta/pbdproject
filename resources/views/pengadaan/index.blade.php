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
                            <td>{{ $pengadaan->idpengadaan }}</td>
                            <td>{{ $pengadaan->user->username }}</td>
                            <td>{{ $pengadaan->vendor->nama_vendor }}</td>
                            <td>{{ $pengadaan->status }}</td>
                            <td>Rp {{ number_format($pengadaan->total_nilai, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengadaan->timestamp)->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('detail.pengadaan', $pengadaan->idpengadaan) }}" class="btn btn-info btn-sm">Lihat</a>
                                <form action="{{ route('destroy.pengadaan', $pengadaan->idpengadaan) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengadaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
