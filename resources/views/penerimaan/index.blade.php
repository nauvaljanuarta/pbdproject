@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">List Penerimaan</h2>
        </div>
    </div>

    <div class="card">
        <h4 class="card-header">Penerimaan</h4>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pengadaan</th>
                            <th>User Penerima</th>
                            <th>Status</th>
                            <th>Tanggal Penerimaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penerimaans as $penerimaan)
                            <tr>
                                <td>{{ $penerimaan->idpenerimaan }}</td>
                                <td>{{ $penerimaan->idpengadaan }}</td>
                                <td>{{ $penerimaan->penerima }}</td> <!-- Menampilkan username -->
                                <td>
                                    @if($penerimaan->status_penerimaan === 'P')
                                        <span class ="text-warning">Pending</span>
                                    @elseif($penerimaan->status_penerimaan === 'A')
                                        <span class ="text-success">Diterima</span>
                                    @elseif($penerimaan->status_penerimaan === 'R')
                                        <span class="text-danger">Retur</span>
                                    @endif
                                </td>
                                <td>{{ $penerimaan->tanggal_penerimaan }}</td>
                                <td>
                                    <a href="{{ route('detail.penerimaan', $penerimaan->idpenerimaan) }}" class="btn btn-primary btn-sm">
                                        Lihat Detail
                                    </a>
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
