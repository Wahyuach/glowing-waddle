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

<!-- Profile Information Card -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Profile Information</h3>
    </div>
    <div class="card-body">
        <!-- Profile form to update name and email -->
        <form action="{{ route('profil.update') }}" method="POST">
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

<!-- Subscription Status (Only for Admins) -->
@if($user->isAdmin())
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Subscription Status</h3>
    </div>
    <div class="card-body">
        <p><strong>Status:</strong> {{ ucfirst($subscriptionStatus) }}</p>

        <!-- Show Subscribe/Payment button based on status -->
        @if($subscriptionStatus === 'inactive')
        <form action="{{ route('profil.subscribe') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Subscribe Now</button>
        </form>
        @else
        <!-- No button if the status is active -->
        <p>You are already subscribed. Thank you!</p>
        @endif
    </div>
</div>
@endif

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
                fetch("{{ route('profil.payment.complete') }}", {
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
                        window.location.href = "{{ route('profil.index') }}?status=success";
                    })
                    .catch(err => {
                        console.error('Error notifying server:', err);
                        window.location.href = "{{ route('profil.index') }}?status=error";
                    });
            },
            onPending: function(result) {
                window.location.href = "{{ route('profil.index') }}?status=pending";
            },
            onError: function(result) {
                window.location.href = "{{ route('profil.index') }}?status=error";
            },
            onClose: function() {
                window.location.href = "{{ route('profil.index') }}?status=closed";
            }
        });
    }
</script>
@endif

@stop