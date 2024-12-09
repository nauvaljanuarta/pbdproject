@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Pengadaan</h2>
        </div>
    </div>

    <!-- Table Pengadaan -->
    <div class="row justify-content-center">
        <div class="card col-md-12">
            <h4 class="card-header">List Pengadaan</h4>
            <div class="table-responsive p-2">
                <table class="table table-hover">
                    <thead class="table">
                        <tr>
                            <th>ID Pengadaan</th>
                            <th>Nama User</th>
                            <th>Nama Vendor</th>
                            <th>PPN (11%)</th>
                            <th>Total Nilai</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengadaans as $pengadaan)
                        <tr>
                            <td>{{ $pengadaan->id_pengadaan }}</td>
                            <td>{{ $pengadaan->user_pengadaan }}</td>
                            <td>{{ $pengadaan->nama_vendor }}</td>
                            <td>Rp {{ number_format($pengadaan->nilai_ppn, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pengadaan->total, 0, ',', '.') }}</td>
                            <td>{{ ($pengadaan->waktu_pengadaan) }}</td>
                            <td>
                                @if($pengadaan->status_pengadaan === 'C')
                                    <span class="text-danger">Batal</span>
                                @elseif($pengadaan->status_pengadaan === 'A')
                                    <span class="text-success">Diterima</span>
                                @elseif($pengadaan->status_pengadaan === 'P')
                                    <span class="text-warning">Pending</span>
                                @endif
                            </td>
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
    <br>
    <a href="{{ route('create.pengadaan') }}" class="btn btn-primary mb-3">Tambah Pengadaan Baru</a>

</div>
@endsection
