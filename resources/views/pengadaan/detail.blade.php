@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Detail Pengadaan</h2>
        </div>
    </div>

    <!-- Tampilkan Detail Pengadaan -->
    <div class="card">
        <h4 class="card-header">Informasi Pengadaan</h4>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>User:</strong> {{ $pengadaan->user->username }}
                </div>
                <div class="col-md-6">
                    <strong>Vendor:</strong> {{ $pengadaan->vendor->nama_vendor }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Status:</strong>
                    @if($pengadaan->status == 'P')
                        Proses
                    @elseif($pengadaan->status == 'S')
                        Selesai
                    @elseif($pengadaan->status == 'C')
                        Batal
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Subtotal Nilai:</strong> Rp {{ number_format($pengadaan->subtotal_nilai, 0, ',', '.') }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>PPN:</strong> Rp {{ number_format($pengadaan->ppn, 0, ',', '.') }}
                </div>
                <div class="col-md-6">
                    <strong>Total Nilai:</strong> Rp {{ number_format($pengadaan->total_nilai, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Pengadaan -->
    <div class="card mt-4">
        <h4 class="card-header">Detail Barang Pengadaan</h4>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengadaan->details as $key => $detail)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $detail->barang->nama }}</td>
                                <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
