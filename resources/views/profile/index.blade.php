@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
<h1>Profile</h1>
@stop

@section('content')
<!-- Displaying success message if exists -->
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


{{-- KARTU STATUS LANGGANAN (KHUSUS MITRA) --}}
@if ($user->isMitra())
<div class="col-md-6">
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">Status Langganan</h3>
        </div>
        <div class="card-body">

            @if ($user->subscription_status === 'Active' && $user->subscription_expires_at > now())
            <div class="alert alert-success">
                <h5><i class="icon fas fa-check"></i> Akun Aktif!</h5>
                Langganan Anda aktif sampai: <b>{{ $user->subscription_expires_at->format('d M Y, H:i') }}</b>
            </div>
            <p>Perpanjang atau tambah masa aktif langganan.</p>
            <form action="{{ route('profile.subscribe') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-credit-card"></i> Bayar
                </button>
            </form>

            @elseif (!$user->subscription_expires_at || $user->subscription_expires_at <= now())
                <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Akun Expired</h5>
                @if ($user->subscription_expires_at)
                Langganan Anda telah berakhir pada: <b>{{ $user->subscription_expires_at->format('d M Y') }}</b>
                @else
                Anda belum memiliki langganan aktif.
                @endif
        </div>
        <p>Silakan perpanjang langganan Anda.</p>
        <form action="{{ route('profile.subscribe') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-credit-card"></i> Bayar
            </button>
        </form>

        @elseif ($user->subscription_status === 'Inactive')
        <div class="alert alert-warning">
            <h5><i class="icon fas fa-pause-circle"></i> Akun Dinonaktifkan</h5>
            Akun Anda saat ini dinonaktifkan oleh Admin.
            @if ($user->subscription_expires_at > now())
            <br>Sisa masa aktif Anda: <b>{{ $user->subscription_expires_at->diffForHumans() }}</b>
            @endif
        </div>
        <p>Harap hubungi Admin untuk mengaktifkan kembali akun Anda.</p>
        {{-- Tombol bayar kita DISABLE --}}
        <button type="button" class="btn btn-secondary btn-block" disabled>
            <i class="fas fa-credit-card"></i> Bayar (Dibekukan)
        </button>

        @endif
    </div>
</div>
@endif


<!-- Profile Information Card -->
<div class="card-col-md-4">
    <div class="card-header">
        <h3 class="card-title">Profile Information</h3>
    </div>
    <div class="card-body">
        <!-- Profile form to update name and email -->
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

<!-- Password Reset Card -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Reset Password</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('profile.reset-password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="form-control" required>
                @error('current_password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger">Reset Password</button>
        </form>
    </div>
</div>

@stop
@section('js')

@if(isset($snap_token))
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script type="text/javascript">
    // CSRF token for AJAX
    const csrfToken = '{{ csrf_token() }}';

    // Get snap token and order id from session (passed by controller)
    const snapToken = "{{ session('snap_token') ?? '' }}";
    const orderId = "{{ session('payment_data.order_id') ?? '' }}";

    if (snapToken) {
        // Open Midtrans Snap UI
        snap.pay(snapToken, {
            onSuccess: function(result) {
                // Notify server to mark subscription active
                fetch("{{ route('profile.payment.complete') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                            transaction_id: result.transaction_id ?? result.transactionId ?? null,
                            result: result
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Redirect back to profile with a status
                        window.location.href = "{{ route('profile.index') }}?status=success";
                    })
                    .catch(err => {
                        console.error('Error notifying server:', err);
                        window.location.href = "{{ route('profile.index') }}?status=error";
                    });
            },
            onPending: function(result) {
                window.location.href = "{{ route('profile.index') }}?status=pending";
            },
            onError: function(result) {
                window.location.href = "{{ route('profile.index') }}?status=error";
            },
            onClose: function() {
                window.location.href = "{{ route('profile.index') }}?status=closed";
            }
        });
    }
</script>
@endif

@stop