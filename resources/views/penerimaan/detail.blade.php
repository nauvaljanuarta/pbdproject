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
                        @if ($penerimaan->status_penerimaan === 'P')
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
                            @foreach ($detailPenerimaan as $key => $detail)
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

        <!-- Tombol Aksi -->
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between">
                {{-- Tombol Masukkan Stok --}}
                <form action="{{ route('terima.stock', $penerimaan->idpenerimaan) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Masukkan Stok</button>
                </form>

                {{-- Tombol Retur --}}
                <button type="button" class="btn btn-danger" id="btnRetur" onclick="showReturForm()">Retur</button>
            </div>
        </div>

        <!-- Form Alasan Retur (hidden by default) -->
        <div class="card" id="formRetur" style="display: none;">
            <div class="card-body">
                <h4 class="card-header">Alasan Retur</h4>
                <form action="{{ route('add.retur', $penerimaan->idpenerimaan) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="alasan">Alasan Retur</label>
                        <textarea class="form-control" id="alasan" name="alasan" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger mt-3">Kirim Retur</button>
                    <button type="button" class="btn btn-secondary mt-3" onclick="hideReturForm()">Batal</button>
                </form>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Script untuk Menampilkan dan Menyembunyikan Form -->
    <script>
        // Menampilkan form alasan retur
        function showReturForm() {
            document.getElementById("formRetur").style.display = "block"; // Menampilkan form
            document.getElementById("btnRetur").style.display = "none"; // Menyembunyikan tombol "Retur"
        }

        // Menyembunyikan form alasan retur
        function hideReturForm() {
            document.getElementById("formRetur").style.display = "none"; // Menyembunyikan form
            document.getElementById("btnRetur").style.display = "inline-block"; // Menampilkan kembali tombol "Retur"
        }
    </script>
@endsection
