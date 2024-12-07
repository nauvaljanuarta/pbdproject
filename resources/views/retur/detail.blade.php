@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Detail Retur</h2>
        </div>
    </div>

    <!-- Informasi Retur -->
    <div class="card mb-4">
        <h4 class="card-header">Informasi Retur</h4>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>ID Retur: </strong> {{ $retur->idretur }}
                </div>
                <div class="col-md-6">
                    <strong>User Penerima: </strong> {{ $retur->nama_user ?? 'Tidak Diketahui' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Status: </strong>
                    @if($retur->status === 'P')
                        Pending
                    @elseif($retur->status === 'A')
                        Diterima
                    @elseif($retur->status === 'R')
                        Retur
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Tanggal Retur: </strong> {{ $retur->created_at }}
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Barang Retur -->
    <div class="card">
        <h4 class="card-header">Detail Barang Retur</h4>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Retur</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal Retur</th>
                            <th>Alasan Retur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailRetur as $key => $detail)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $detail->nama_barang }}</td>
                            <td>{{ $detail->jumlah_dikembalikan }}</td>
                            <td>Rp {{ number_format($detail->harga_satuan_terima, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->sub_total_terima, 0, ',', '.') }}</td>
                            <td>{{ $detail->alasan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
