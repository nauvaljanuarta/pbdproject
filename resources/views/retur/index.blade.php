@extends('layout.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">List Retur</h2>
        </div>
    </div>

    <div class="card">
        <h4 class="card-header">Retur</h4>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Penerimaan</th>
                            <th>User Penerima</th>
                            <th>Status</th>
                            <th>Tanggal Retur</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($returs as $key => $retur)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $retur->idpenerimaan }}</td>
                                <td>{{ $retur->user->username }}</td> <!-- Menampilkan nama user penerima -->
                                <td>
                                    @if($retur->status === 'P')
                                        <span class="text-warning">Pending</span>
                                    @elseif($retur->status === 'A')
                                        <span class="text-success">Diterima</span>
                                    @elseif($retur->status === 'R')
                                        <span class="text-danger">Retur</span>
                                    @endif
                                </td>
                                <td>{{ $retur->created_at }}</td>
                                <td>
                                    <a href="{{ route('retur.detail', $retur->idretur) }}" class="btn btn-primary btn-sm">
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
