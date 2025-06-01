@extends('customer.layout.master')

@section('content')
    <style>
        .produk-card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease-in-out;
        }
        .produk-img {
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .produk-card:hover .produk-img {
            transform: scale(1.1);
        }
        .kategori-link {
            color: goldenrod;
            font-size: 15px;
            display: block;
            padding: 8px 12px;
            border-radius: 8px;
            transition: 0.3s;
            text-decoration: none;
        }
        .kategori-link:hover {
            background-color: #ffe8a1;
            color: #c08000;
        }
        .btn-lihat {
            background: linear-gradient(45deg, #ffa500, #ffcc00);
            border: none;
            color: #fff;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-lihat:hover {
            background: linear-gradient(45deg, #ffcc00, #ffa500);
            color: #fff;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col align-self-center">
                            <h4 class="page-title pb-md-0">Produk</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Produk</li>
                            </ol>
                        </div>
                        <div class="col-auto align-self-center">
                            <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                                <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                                <span id="Select_date">
                                    @php echo date('d M'); @endphp
                                </span>
                                <i data-feather="calendar" class="align-self-center icon-xs ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Kategori -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm rounded-lg">
                    <div class="card-body">
                        <h5 class="text-center mb-3">Kategori Produk</h5>
                        <hr>
                        <ul class="list-unstyled">
                            @foreach ($kategori as $kategori)
                                <li class="mb-2">
                                    <a href="{{ route('customer.produk_kategori', $kategori->id_kategori) }}" class="kategori-link">
                                        {{ Str::title($kategori->nama_kategori) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Produk -->
            <div class="col-md-9">
                <div class="row">
                    @php
                        function rupiah($angka) {
                            return 'Rp ' . number_format($angka, 2, ',', '.');
                        }
                    @endphp

                    @foreach ($produk as $data)
                        <div class="col-md-4 mb-4 d-flex align-items-stretch">
                            <div class="card produk-card shadow-sm rounded-lg border-0 w-100">
                                <div class="overflow-hidden rounded-top">
                                    <img src="/produk/{{ $data->foto_produk }}" alt="" class="card-img-top produk-img" height="180">
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted small mb-1">{{ Str::title($data->nama_kategori) }}</p>

                                    <a href="{{ route('customer.produk_detail', $data->id_produk) }}"
                                        class="h6 text-dark text-decoration-none mb-2">
                                        {{ Str::title($data->nama_produk) }}
                                    </a>

                                    <h5 class="text-warning fw-bold mt-auto">{{ rupiah($data->harga_produk) }}</h5>

                                    <a href="{{ route('customer.produk_detail', $data->id_produk) }}"
                                        class="btn btn-lihat btn-sm mt-3 rounded-pill">
                                        Lihat Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
