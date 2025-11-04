
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Profil Pengguna</h1>

    <div class="bg-white rounded shadow p-6">
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nama:</label>
            <p>{{ $user->name }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email:</label>
            <p>{{ $user->email }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Subscription:</label>
            @if($user->subscription && $user->subscription->is_active)
                <p class="text-green-600 font-semibold">Aktif sampai {{ $user->subscription->expired_at->format('d M Y') }}</p>
            @else
                <p class="text-red-600 font-semibold">Tidak aktif</p>
            @endif
        </div>
    </div>
</div>
@endsection
