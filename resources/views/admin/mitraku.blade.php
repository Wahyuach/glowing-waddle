@extends('adminlte::page')


@section('title', 'Dashboard Admin')

@section('content_header')

<h1>Dashboard Admin</h1>
@stop


@section('content')


@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif




<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manajemen Mitra</h3>
        </div>

        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mitra</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($usersMitra as $mitra)
                    <tr>

                        <td>
                            {{ $mitra->name }}<br>
                            <small class="text-muted">{{ $mitra->email }}</small>
                        </td>


                        <td>
                            @if ($mitra->subscription_status === 'Active')
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>


                        <td>

                            <form action="{{ route('users.toggleStatus', $mitra->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin mengubah status mitra ini?');">
                                @csrf

                                @if ($mitra->subscription_status === 'Active')
                                <button type="submit" class="btn btn-danger btn-xs" title="Nonaktifkan Mitra">
                                    <i class="fas fa-fw fa-times-circle"></i>
                                </button>
                                @else
                                <button type="submit" class="btn btn-success btn-xs" title="Aktifkan Mitra">
                                    <i class="fas fa-fw fa-check-circle"></i>
                                </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            Belum ada data user mitra.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@stop