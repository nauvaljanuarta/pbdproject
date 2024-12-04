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
                            <th>ID Penerimaan</th>
                            <th>ID Pengadaan</th>
                            <th>User Penerima</th>
                            <th>Status</th>
                            <th>Waktu Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penerimaans as $key => $penerimaan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $penerimaan->idpenerimaan }}</td>
                                <td>{{ $penerimaan->idpengadaan }}</td>
                                <td>{{ $penerimaan->user_penerima }}</td>
                                <td>
                                    @if($penerimaan->status === 'P')
                                        Proses
                                    @elseif($penerimaan->status === 'S')
                                        Selesai
                                    @elseif($penerimaan->status === 'R')
                                        Retur
                                    @endif
                                </td>
                                <td>{{ $penerimaan->created_at }}</td>
                                <td>
                                    <a href="{{ route('penerimaan.show', $penerimaan->idpenerimaan) }}" class="btn btn-primary btn-sm">
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
