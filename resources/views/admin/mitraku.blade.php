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




<div class="col">
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
                        <th>Aktif Sampai</th>
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
                            @if ($mitra->subscription_expires_at)
                            <small>
                                <b class="countdown-timer"
                                    data-expires="{{ $mitra->subscription_expires_at->toIso8601String() }}">
                                    Menghitung...
                                </b>
                            </small>
                            @else
                            <small class="text-muted"><i>N/A</i></small>
                            @endif
                        </td>
                        <td>

                            <form action="{{ route('users.toggleStatus', $mitra->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin mengubah status mitra ini?');">
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

                            <form action="{{ route('users.addSubscriptionTime', $mitra->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tambah 7 hari untuk mitra ini?');">
                                @csrf
                                <input type="hidden" name="days" value="7">
                                <button type="submit" class="btn btn-info btn-xs" title="Tambah 7 Hari">
                                    <i class="fas fa-fw fa-plus"></i> 7
                                </button>
                            </form>

                            <form action="{{ route('users.addSubscriptionTime', $mitra->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tambah 30 hari untuk mitra ini?');">
                                @csrf
                                <input type="hidden" name="days" value="30">
                                <button type="submit" class="btn btn-warning btn-xs" title="Tambah 30 Hari">
                                    <i class="fas fa-fw fa-plus"></i> 30
                                </button>
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

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElements = document.querySelectorAll('.countdown-timer');

        if (countdownElements.length > 0) {

            const timerInterval = setInterval(function() {
                const now = new Date().getTime();

                countdownElements.forEach(function(element) {
                    const expirationTime = new Date(element.dataset.expires).getTime();

                    const distance = expirationTime - now;

                    if (distance < 0) {
                        element.innerHTML = "Telah Berakhir";
                        element.className = "text-danger"; 
                    } else {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        element.innerHTML = days + "h " + hours + "j " + minutes + "m " + seconds + "d";
                        element.className = "text-success"; 
                    }
                });
            }, 1000);
        }
    });
</script>
@stop