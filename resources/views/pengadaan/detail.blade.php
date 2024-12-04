@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Pengadaan</h2>
        </div>
    </div>

    <!-- Tampilkan Detail Pengadaan -->
    <div class="card">
        <h4 class="card-header">Informasi Pengadaan</h4>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>User : </strong> {{ $pengadaan->user_pengadaan}}
                </div>
                <div class="col-md-6">
                    <strong>Vendor : </strong> {{ $pengadaan->nama_vendor }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Status : </strong>
                    @if($pengadaan->status_pengadaan == 'Proses')
                        Proses
                    @elseif($pengadaan->status_pengadaan == 'Diterima')
                        Selesai
                    @elseif($pengadaan->status_pengadaan == 'Batal')
                        Batal
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Subtotal Nilai : </strong> Rp {{ number_format($pengadaan->subtotal, 0, ',', '.') }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>PPN:</strong> Rp {{ number_format($pengadaan->nilai_ppn, 0, ',', '.') }}
                </div>
                <div class="col-md-6">
                    <strong>Total Nilai:</strong> Rp {{ number_format($pengadaan->total, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Pengadaan -->
    <div class="card mt-4">
        <h4 class="card-header">Detail Barang Pengadaan</h4>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
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
                        @foreach($details as $key => $detail)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <!-- Akses nama_barang melalui relasi barang -->
                                <td>{{ $detail->nama_barang }}</td>
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
    <div class="row mt-4">
        <div class="col-md-12 text-right">
            <form action="{{ route('add.penerimaan', $pengadaan->id_pengadaan) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Confirm Penerimaan</button>
            </form>
        </div>
    </div>





</div>
@endsection
