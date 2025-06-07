@extends('customer.layout.master')

@section('content')
<style>
    .checkout-success {
        background-color: #fff8f0;
        padding: 60px 20px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .checkout-success h2 {
        color: #ff6600;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .checkout-success p {
        font-size: 1.1rem;
        color: #333;
    }

    .btn-orange {
        background-color: #ff6600;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s ease;
    }

    .btn-orange:hover {
        background-color: #e65900;
    }

    .btn-outline-orange {
        border: 2px solid #ff6600;
        color: #ff6600;
        background: transparent;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s ease;
    }

    .btn-outline-orange:hover {
        background-color: #ff6600;
        color: white;
    }

    .success-icon {
        font-size: 60px;
        color: #ff6600;
        margin-bottom: 20px;
        animation: bounce 1s ease-in-out;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

<div class="container d-flex justify-content-center align-items-center mt-5 mb-5">
    <div class="checkout-success text-center col-md-8">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2>Pembayaran Berhasil!</h2>
        <p>Terima kasih, pesanan kamu sedang kami proses.</p>

        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('customer.pesanan') }}" class="btn btn-orange">
                <i class="fas fa-box"></i> Lihat Pesanan
            </a>
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-orange">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
