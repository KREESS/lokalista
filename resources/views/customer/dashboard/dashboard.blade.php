@extends('customer.layout.master');

@section('content')
    <div class="container-fluid">
        {{-- <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col align-self-center">
                            <h4 class="page-title pb-md-0">Dashboard</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <!--end col-->
                        <div class="col-auto align-self-center">
                            <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                                <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                                <span class="" id="Select_date">
                                    @php
                                        echo date('d M');
                                    @endphp
                                </span>
                                <i data-feather="calendar" class="align-self-center icon-xs ms-1"></i>
                            </a>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div> --}}

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-5 align-self-center">
                        <div class="p-5 ms-lg-n4"> <!-- Tambah margin kiri negatif untuk geser -->
                            <h1 class="my-4 fw-bold">
                                <span style="color: #000000;">Selamat Datang Di</span> 
                                <span style="color: #ff7700;"> LOKALISTA</span>.
                            </h1>
                            <p class="fs-5" style="color: #d68e44;">
                                LOKALISTA menghubungkan usaha kecil dan menengah Indramayu ke dunia digital.
                                Kami mempermudah Anda menemukan produk-produk lokal berkualitas dengan harga bersaing, 
                                sambil membantu pelaku UMKM tumbuh dan berkembang bersama teknologi.
                            </p>
                            {{-- <button type="button" class="btn btn-lg rounded-pill px-4 py-2 mt-3 shadow-sm"
                                style="background-color: #ff7700; border: none; color: white; transition: 0.3s;">
                                Get Started
                            </button> --}}
                        </div>
                    </div>
                    <!--end col-->
                    <style>
                        .custom-carousel {
                            border-radius: 50px;
                            overflow: hidden;
                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                            /* margin-left: auto; Biar ke pojok kanan */
                        }
                    
                        .carousel-indicators li {
                            width: 10px;
                            height: 10px;
                            border-radius: 50%;
                            background-color: #ED7D31 !important; /* warna oren */
                            margin: 5px;
                        }
                    
                        .carousel-indicators .active {
                            background-color: #ED7D31 !important;
                        }
                    
                        .carousel-control-prev-icon,
                        .carousel-control-next-icon {
                            filter: brightness(0) invert(1);
                        }
                    </style>
                    
                    <div class="col-lg-5 offset-lg-1 text-end"> <!-- Geser sedikit ke kanan -->
                        <div id="carouselExampleIndicators" class="carousel slide custom-carousel" data-bs-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="/dapuranita/img-1.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="/dapuranita/img-2.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="/dapuranita/img-3.jpg" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>
                    </div>
                    
                    <!--end col-->
                </div>
            </div>
        </div>
        <style>
            #grid .picture-item {
                padding: 10px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
        
            #grid .picture-item img {
                border-radius: 15px;
                transition: transform 0.3s ease;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
        
            #grid .picture-item:hover img {
                transform: scale(1.05);
                box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            }
        
            .custom-filter-btn {
                background-color: #ff7700;
                color: #fff;
                border: none;
                border-radius: 30px;
                padding: 10px 25px;
                font-size: 16px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
        
            .custom-filter-btn:hover {
                background-color: #d68e44;
                transform: translateY(-3px);
                box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            }
        
            /* Aktif warna putih */
            .custom-filter-btn.active {
                background-color: #fff !important;
                color: #000 !important;
            }
        
            .filter-options {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
            }
        </style>
        
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="filters-group mb-4">
                    <div class="btn-group filter-options flex-wrap" role="group" aria-label="Filter Options">
                        @foreach ($kategori as $kat)
                            <a href="{{ route('customer.dashboard_kategori', $kat->id_kategori) }}" 
                               class="btn custom-filter-btn m-2 
                               {{ Request::is('customer/dashboard/kategori/'.$kat->id_kategori) ? 'active' : '' }}">
                                {{ Str::title($kat->nama_kategori) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>  
        <style>
            .produk-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
        
            .produk-card:hover {
                transform: scale(1.05);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }
        </style>
        <section style="background-color: #ff770036; border-radius: 30px;">
            <div class="container py-5">
              <div class="row">
                <!-- Produk -->
                <div class="col-md-14">
                    <div class="row">
                        @php
                            function rupiah($angka) {
                                return 'Rp ' . number_format($angka, 2, ',', '.');
                            }
                        @endphp

                    @forelse ($produk as $data)
                        <div class="col-md-3 mb-3 d-flex align-items-stretch">
                            <div style="border-radius: 30px;" class="card produk-card shadow-sm rounded-lg border-0 w-100">
                                <div class="d-flex justify-content-between p-3">
                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-1-strong" style="width: 35px; height: 35px;">
                                        <p class="text-white mb-0 small">x3</p>
                                    </div>
                                </div>
                                <!-- Gambar Produk -->
                                <div class="overflow-hidden rounded-top">
                                    <img src="/produk/{{ $data->foto_produk }}" alt="{{ $data->nama_produk }}" class="card-img-top produk-img" height="180">
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <!-- Kategori Produk -->
                                    <p class="small"><a href="#!" class="text-muted">{{ Str::title($data->nama_kategori) }}</a></p>

                                    <!-- Nama Produk dan Link ke Detail -->
                                    <a href="{{ route('customer.dashboard_detail', $data->id_produk) }}" class="h6 text-dark text-decoration-none mb-2">
                                        {{ Str::title($data->nama_produk) }}
                                    </a>

                                    <!-- Harga Asli dan Harga Diskon -->
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="small text-danger"><s>{{ rupiah($data->harga_produk) }}</s></p>
                                        <h5 class="text-warning fw-bold mt-auto">{{ rupiah($data->harga_produk) }}</h5>
                                    </div>
                                    <!-- Tombol untuk Melihat Produk -->
                                    <a href="{{ route('customer.produk_detail', $data->id_produk) }}" style="color: #ff7700" class="btn btn-lihat btn-sm mt-3 rounded-pill">
                                        Lihat Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="alert alert-outline-danger" role="alert">
                                <strong>Maaf </strong> Produk Saat ini Tidak Tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>
              </div>
            </div>
          </section>          
          
        {{-- <div id="grid" class="row g-3">
            <div class="col-md-4 col-lg-3 picture-item" data-groups='["craft"]'>
                <a href="/dapuranita/kerajinan1.jpg" class="lightbox">
                    <img src="/dapuranita/kerajinan1.jpg" alt="" class="img-fluid" />
                </a>
            </div>
            <div class="col-md-4 col-lg-3 picture-item" data-groups='["drink"]'>
                <a href="/dapuranita/minuman1.jpeg" class="lightbox">
                    <img src="/dapuranita/minuman1.jpeg" alt="" class="img-fluid" />
                </a>
            </div>
            <div class="col-md-4 col-lg-3 picture-item" data-groups='["craft"]'>
                <a href="/dapuranita/kerajinan2.jpg" class="lightbox">
                    <img src="/dapuranita/kerajinan2.jpg" alt="" class="img-fluid" />
                </a>
            </div>
            <div class="col-md-4 col-lg-3 picture-item" data-groups='["food"]'>
                <a href="/dapuranita/img-7.jpg" class="lightbox">
                    <img src="/dapuranita/img-7.jpg" alt="" class="img-fluid" />
                </a>
            </div>
            <div class="col-md-4 col-lg-3 picture-item" data-groups='["drink"]'>
                <a href="/dapuranita/minuman3.jpeg" class="lightbox">
                    <img src="/dapuranita/minuman3.jpeg" alt="" class="img-fluid" />
                </a>
            </div>
            <div class="col-md-4 col-lg-3 picture-item" data-groups='["health"]'>
                <a href="/dapuranita/kesehatan.jpg" class="lightbox">
                    <img src="/dapuranita/kesehatan1.jpg" alt="" class="img-fluid" />
                </a>
            </div>
            <div class="col-md-4 col-lg-3 picture-item" data-groups='["food"]'>
                <a href="/dapuranita/img-10.jpg" class="lightbox">
                    <img src="/dapuranita/img-10.jpg" alt="" class="img-fluid" />
                </a>
            </div>
            <div class="col-md-4 col-lg-3 picture-item" data-groups='["drink"]'>
                <a href="/dapuranita/minuman2.jpg" class="lightbox">
                    <img src="/dapuranita/minuman2.jpg" alt="" class="img-fluid" />
                </a>
            </div>
        </div> --}}
        

        {{-- <div class="row">
            @php
                function rupiah($angka)
                {
                    $hasil_rupiah = 'Rp ' . number_format($angka, 2, ',', '.');
                    return $hasil_rupiah;
                }
            @endphp
            @foreach ($produk as $data)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="ribbon1 rib1-danger">
                                <span class="text-white text-center rib1-danger">New</span>
                            </div>
                            <!--end ribbon-->
                            <img src="/produk/{{ $data->foto_produk }}" alt="" class="d-block mx-auto my-4"
                                height="150">
                            <div class="d-flex justify-content-between align-items-center my-4">
                                <div>
                                    <p class="text-muted mb-2">{{ Str::title($data->nama_kategori) }}</p>
                                    <a href="#" class="header-title">{{ Str::title($data->nama_produk) }}</a>
                                </div>
                                <div>
                                    <h4 class="text-dark mt-0 mb-2">{{ rupiah($data->harga_produk) }}</h4>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-de-warning">Masukan Keranjang</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}
    </div>
@endsection

@section('css')
    <link href="/metrica/dist/assets/libs/@midzer/tobii/tobii.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('js')
    <script src="/metrica/dist/assets/libs/shufflejs/shuffle.min.js"></script>
    <script src="/metrica/dist/assets/libs/@midzer/tobii/tobii.min.js"></script>
    <script src="/metrica/dist/assets/JS/pages/gallery.init.js"></script>
@endsection
