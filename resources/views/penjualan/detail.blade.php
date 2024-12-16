@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Detail Penjualan</h2>
        </div>
    </div>

    <!-- Informasi Penjualan -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Informasi Penjualan</h4>
        </div>
        <div class="card-body">
            <p><strong>ID Penjualan:</strong> {{ $penjualan->idpenjualan }}</p>
            <p><strong>Nama User:</strong> {{ $penjualan->nama_user }}</p>
            <p><strong>Margin Penjualan:</strong> {{ $penjualan->margin_persen ?? 0 }}%</p>
            <p><strong>Subtotal:</strong> Rp {{ number_format($penjualan->subtotal_nilai, 0, ',', '.') }}</p>
            <p><strong>PPN:</strong> Rp {{ number_format($penjualan->ppn, 0, ',', '.') }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($penjualan->total_nilai, 0, ',', '.') }}</p>
            <p><strong>Waktu Transaksi:</strong> {{ $penjualan->created_at }}</p>
        </div>
    </div>

    <!-- Detail Barang -->
    <div class="card">
        <div class="card-header">
            <h4>Detail Barang</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Detail</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $detail)
                            <tr>
                                <td>{{ $detail->iddetail_penjualan }}</td>
                                <td>{{ $detail->nama_barang }}</td>
                                <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada detail barang untuk penjualan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
