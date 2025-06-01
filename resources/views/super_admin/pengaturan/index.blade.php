@extends('super_admin.layout.master')

@section('content')
<div class="container-fluid">
    <h4>Pengaturan Sistem</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('superadmin.pengaturan.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Aplikasi</label>
            <input type="text" name="nama_aplikasi" class="form-control" value="{{ $settings['nama_aplikasi'] ?? '' }}">
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <input type="text" name="metode_pembayaran" class="form-control" value="{{ $settings['metode_pembayaran'] ?? '' }}">
            <small class="text-muted">Contoh: Transfer Bank, COD, E-wallet</small>
        </div>

        <div class="mb-3">
            <label>Biaya Ongkir (Rp)</label>
            <input type="number" name="ongkir" class="form-control" value="{{ $settings['ongkir'] ?? 0 }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    </form>
</div>
@endsection
