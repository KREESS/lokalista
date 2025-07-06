@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #fff8f0;
    }

    .reset-container {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
        max-width: 500px;
        margin: auto;
    }

    .reset-title {
        color: #ff7700;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .btn-orange {
        background-color: #ff7700;
        color: white;
        border: none;
    }

    .btn-orange:hover {
        background-color: #e86500;
    }

    label {
        font-weight: 500;
    }
</style>

<div class="container mt-5">
    <div class="reset-container">
        <h4 class="reset-title text-center">Atur Ulang Password</h4>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $email) }}" required>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">Password Baru</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-orange">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
