@php
    if (!function_exists('rupiah')) {
        function rupiah($angka) {
            return 'Rp ' . number_format($angka, 2, ',', '.');
        }
    }
@endphp

@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col align-self-center">
                        <h4 class="page-title pb-md-0">Pesanan Masuk</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pesanan Masuk</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                            <span class="day-name">Today:</span>&nbsp;
                            <span>{{ date('d M') }}</span>
                            <i data-feather="calendar" class="align-self-center icon-xs ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL PESANAN --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Produk</th>
                                    <th>Quantity</th>
                                    <th>Total Tagihan</th>
                                    <th>Pengiriman</th>
                                    <th>Status Transaksi</th>
                                    <th>Tipe Pembayaran</th>
                                    <th>Action</th>
                                    <th>Tanggal Pesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesanan as $data)
                                    <tr>
                                        <td>#PP00{{ $data->id_pesanan }}</td>
                                        <td>
                                            @if($data->foto_produk)
                                                <img src="/produk/{{ $data->foto_produk }}" class="thumb-sm rounded-circle me-2">
                                                {{ Str::title($data->nama_produk) }}
                                            @else
                                                <span class="text-danger">Produk tidak ditemukan</span>
                                            @endif
                                        </td>
                                        <td>{{ $data->quantity }} / Pcs</td>
                                        <td>{{ rupiah($data->total_ongkir) }}</td>
                                        <td>
                                            {{ $data->alamat_lengkap ?? '-' }},
                                            {{ $data->nama_kota ?? '-' }},
                                            {{ $data->nama_prov ?? '-' }}
                                        </td>
                                        <td>{{ $data->status }}</td>
                                        <td><span class="badge badge-soft-primary p-2">{{ Str::upper($data->tipe_pembayaran) }}</span></td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn-terima" data-url="{{ route('admin.pesanan_terima', $data->id_pesanan) }}" style="color:green">
                                                <i class="ti ti-checks"></i> Terima
                                            </a> |
                                            <a href="{{ route('admin.pesanan_tolak', $data->id_pesanan) }}" style="color:red">
                                                <i class="ti ti-circle-x"></i> Tolak
                                            </a> |
                                            <a href="javascript:void(0)" class="btn-hapus" data-url="{{ route('admin.pesanan_hapus', $data->id_pesanan) }}" style="color:orange">
                                                <i class="ti ti-trash"></i> Hapus
                                            </a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($data->updated_at)->format('d-M-Y') }}</td>
                                    </tr>

                                    {{-- MODAL BUKTI --}}
                                    <div class="modal fade" id="buktiModal-{{ $data->id_pesanan }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Bukti Pembayaran</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-3 text-center">
                                                            @if ($data->tipe_pembayaran == 'dp')
                                                                <img src="/bukti_bayar/{{ $data->bukti_bayar_dp }}" class="img-fluid" data-action="zoom">
                                                            @else
                                                                <img src="/bukti_bayar/{{ $data->bukti_bayar }}" class="img-fluid" data-action="zoom">
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <h5>#PP00{{ $data->id_pesanan }}</h5>
                                                            <h5>Total Tagihan: {{ rupiah($data->tipe_pembayaran == 'dp' ? $data->total_dp : $data->total_ongkir) }}</h5>
                                                            <span class="badge bg-soft-secondary">Klik gambar untuk zoom</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="/js/zoom.css">
@endsection

@section('js')
    <script src="/js/zoom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @section('js')
    <script src="/js/zoom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-terima').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Konfirmasi Pembayaran',
                        text: "Apakah Yakin Pembayaran Telah Sesuai?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Terima',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });

            document.querySelectorAll('.btn-hapus').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Yakin ingin menghapus pesanan?',
                        text: "Data akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });
        });
    </script>
@endsection
