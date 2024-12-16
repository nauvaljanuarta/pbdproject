@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Daftar Penjualan</h2>
        </div>
    </div>

    <!-- Tabel Penjualan -->
    <div class="row justify-content-center">
        <div class="card col-md-12">
            <h4 class="card-header">List Penjualan</h4>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID Penjualan</th>
                                <th>Nama User</th>
                                <th>Margin Penjualan (%)</th>
                                <th>Subtotal</th>
                                <th>PPN</th>
                                <th>Total</th>
                                <th>Waktu Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penjualans as $penjualan)
                                <tr>
                                    <td>{{ $penjualan->idpenjualan }}</td>
                                    <td>{{ $penjualan->nama_user }}</td>
                                    <td>{{ $penjualan->margin_persen }}%</td>
                                    <td>Rp {{ number_format($penjualan->subtotal_nilai, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($penjualan->ppn, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($penjualan->total_nilai, 0, ',', '.') }}</td>
                                    <td>{{ $penjualan->created_at }}</td>
                                    <td>
                                        <a href="{{ route('detail.penjualan', $penjualan->idpenjualan) }}" class="btn btn-primary btn-sm">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
