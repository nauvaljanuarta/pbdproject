@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Detail Penerimaan</h2>
        </div>
    </div>

    <!-- Informasi Penerimaan -->
    <div class="card mb-4">
        <h4 class="card-header">Informasi Penerimaan</h4>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>ID Pengadaan: </strong> {{ $penerimaan->idpengadaan }}
                </div>
                <div class="col-md-6">
                    <strong>User Penerima: </strong> {{ $penerimaan->penerima ?? 'Tidak Diketahui' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Status: </strong>
                    @if($penerimaan->status_penerimaan === 'P')
                        Pending
                    @elseif($penerimaan->status_penerimaan === 'A')
                        Diterima
                    @elseif($penerimaan->status_penerimaan === 'R')
                        Retur
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Tanggal Penerimaan: </strong> {{ $penerimaan->tanggal_penerimaan }}
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Barang Penerimaan -->
    <div class="card">
        <h4 class="card-header">Detail Barang</h4>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Diterima</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailPenerimaan as $key => $detail)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $detail->nama_barang }}</td>
                                <td>{{ $detail->jumlah_terima }}</td>
                                <td>Rp {{ number_format($detail->harga_satuan_terima, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->sub_total_terima, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
