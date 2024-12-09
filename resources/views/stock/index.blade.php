    @extends('layout.main')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2 class="mb-4">Transaksi Stok Barang</h2>
            </div>
        </div>

        <div class="card mt-4">
            <h4 class="card-header">Current Stock per Barang</h4>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Current Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($currentStocks as $key => $currentStock)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $currentStock->nama_barang }}</td>
                                    <td>{{ $currentStock->current_stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<br>
        <!-- Tabel Transaksi Stok -->
        <div class="card mb-4">
            <h4 class="card-header">Daftar Transaksi Stok</h4>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jenis Transaksi</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Stok Setelah Transaksi</th>
                                <th>ID Transaksi</th>
                                <th>Tanggal Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stocks as $key => $transaction)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $transaction->nama_barang }}</td>
                                    <td>
                                        @if($transaction->jenis_transaksi == 'R')
                                            Retur
                                        @elseif($transaction->jenis_transaksi == 'P')
                                            Penerimaan
                                        @elseif($transaction->jenis_transaksi == 'S')
                                            Penjualan
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->jenis_transaksi == 'P')
                                            {{ $transaction->masuk }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->jenis_transaksi == 'R' || $transaction->jenis_transaksi == 'S')
                                            {{ $transaction->keluar }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>{{ $transaction->stock }}</td>
                                    <td>
                                        @if($transaction->jenis_transaksi == 'R')
                                            {{ $transaction->idtransaksi }} (Retur)
                                        @elseif($transaction->jenis_transaksi == 'P')
                                            {{ $transaction->idtransaksi }} (Penerimaan)
                                        @elseif($transaction->jenis_transaksi == 'S')
                                            {{ $transaction->idtransaksi }} (Penjualan)
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
