@extends('customer.layout.master')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="page-title">Produk</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Produk</li>
                        </ol>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-outline-primary btn-sm" id="Dash_Date">
                            <span id="Day_Name">Today:</span>&nbsp;
                            <span id="Select_date">@php echo date('d M'); @endphp</span>
                            <i data-feather="calendar" class="icon-xs ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        function rupiah($angka) {
            return 'Rp ' . number_format($angka, 2, ',', '.');
        }
    @endphp

    <div class="row">
        <div class="col-12">
            @if (session('gagal'))
                <div class="alert alert-danger border-0" role="alert">
                    {{ session('gagal') }}
                </div>
            @endif

            <div class="card shadow rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <img src="/produk/{{ $produk->foto_produk }}" alt="" class="img-fluid rounded w-100 shadow-sm">
                        </div>
                        <div class="col-lg-6">
                            <span class="badge bg-warning text-dark mb-2">{{ Str::title($produk->nama_kategori) }}</span>
                            <h3 class="fw-bold mb-2">{{ Str::title($produk->nama_produk) }}</h3>
                            <h4 class="text-danger fw-bold mb-3">{{ rupiah($produk->harga_produk) }}</h4>
                            <h6 class="fw-semibold">Deskripsi :</h6>
                            <p class="text-muted">@php echo htmlspecialchars_decode($produk->deskripsi_produk); @endphp</p>
                            <h6 class="fw-semibold">Sekilas Info :</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="las la-check-circle text-success me-1"></i> Pesanan Akan Langsung Dibuat apabila ada pesanan</li>
                                <li class="mb-2"><i class="las la-check-circle text-success me-1"></i> Pembuatan Pesanan Berdasarkan First Order First Serve</li>
                                <li><i class="las la-check-circle text-success me-1"></i> Jaminan Kualitas Bahan dan Proses Pembuatan</li>
                            </ul>

                            <div class="mt-4">
                                <form action="{{ route('customer.keranjang_store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="d-flex align-items-center mb-3">
                                        <input class="form-control me-3" style="width:100px;" type="number" name="quantity" min="1" value="1" max="{{ $produk->stok }}">
                                        <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                        <button type="submit" class="btn btn-primary px-4"  style="background-color: #EDA752; border: none; color: white; transition: 0.3s;"><i class="mdi mdi-cart me-2" ></i>Masukan Keranjang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-5 mb-3 fw-bold">Komentar Teratas</h4>
    <div class="row">
        @foreach ( $komentar as $komentar)
        <div class="col-lg-12 mb-3">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <img class="rounded-circle me-3" src="assets/images/small/opp-1.png" alt="" height="50">
                        <div>
                            <h6 class="mb-1">{{ Str::upper($komentar->name) }}</h6>
                            <p class="text-muted mb-0">{{ $komentar->komentar_produk }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('js')
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 2500);
</script>
@endsection