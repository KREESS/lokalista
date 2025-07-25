@extends('layouts.master')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="row">
            {{-- HERO SECTION --}}
            <div class="col-lg-5 align-self-center">
                <div class="p-5 ms-lg-n4">
                    <h1 class="my-4 fw-bold">
                        <span style="color: #000000;">Selamat Datang Di</span>
                        <span style="color: #ff7700;"> LOKALISTA</span>.
                    </h1>
                    <p class="fs-5" style="color: #d68e44;">
                        LOKALISTA menghubungkan usaha kecil dan menengah Indramayu ke dunia digital.
                        Kami mempermudah Anda menemukan produk-produk lokal berkualitas dengan harga bersaing, 
                        sambil membantu pelaku UMKM tumbuh dan berkembang bersama teknologi.
                    </p>
                </div>
            </div>

            {{-- CAROUSEL --}}
            <div class="col-lg-5 offset-lg-1 text-end">
                <div id="carouselExampleIndicators" class="carousel slide custom-carousel" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/lokalista/slide5.jpeg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="/lokalista/slide1.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="/lokalista/slide2.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item active">
                            <img src="/lokalista/slide3.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="/lokalista/slide4.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="/lokalista/slide6.jpg" class="d-block w-100" alt="...">
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
        </div>
    </div>
</div>

{{-- BANNER IKLAN --}}
<div class="row my-5">
    <div class="col-md-12">
        <div class="rounded-4 shadow-lg px-4 py-5 text-center text-white promo-banner position-relative overflow-hidden" style="background: linear-gradient(135deg, #f26514, #ffd014);" data-aos="fade-up">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-pattern" style="opacity: 0.1;"></div>
            <h2 class="fw-bold mb-3 animate__animated animate__pulse animate__infinite">🎉 Promo Spesial Bulan Ini!</h2>
            <p class="lead mb-0">Dapatkan diskon hingga <strong>30%</strong> untuk produk pilihan lokal Indramayu! 💥</p>
        </div>
    </div>
</div>
{{-- FILTER KATEGORI --}}
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

                                    {{-- Tombol SEMUA --}}
                                    <a href="{{ route('home.produk') }}" 
                                    class="btn custom-filter-btn m-2 {{ Request::is('home/produk') ? 'active' : '' }}">
                                        Semua
                                    </a>

                                    {{-- Tombol KATEGORI --}}
                                    @foreach ($kategori as $kat)
                                        <a href="{{ route('home.produk_kategori', $kat->id_kategori) }}" 
                                        class="btn custom-filter-btn m-2 {{ Request::is('produk/kategori/'.$kat->id_kategori) ? 'active' : '' }}">
                                            {{ Str::title($kat->nama_kategori) }}
                                        </a>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PRODUK TERSEDIA --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="fw-bold text-orange" style="color:#ff7700;">PRODUK TERBARU</h5>
                        </div>
                    </div>

                    {{-- LIST PRODUK --}}
                    <section style="background-color: #ff770036; border-radius: 30px;">
                        <div class="container py-5">
                            <div class="row">
                                <div class="col-md-14">
                                    <div class="row">
                                        @php
                        if (!function_exists('rupiah')) {
                            function rupiah($angka) {
                                return 'Rp ' . number_format($angka, 2, ',', '.');
                            }
                        }
                    @endphp
                    @forelse ($produk as $data)
                    <div class="col-6 col-md-3 mb-3 d-flex align-items-stretch">
                        <div class="card produk-card shadow-sm rounded-lg border-0 w-100" style="border-radius: 30px;">
                                <div class="overflow-hidden rounded-top">
                                    <img src="/produk/{{ $data->foto_produk }}" alt="{{ $data->nama_produk }}" class="card-img-top produk-img" height="180">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <p class="small text-muted mb-1">{{ Str::title($data->nama_kategori) }}</p>
                                    <a href="{{ route('home.produk_detail', $data->id_produk) }}" class="h6 text-dark text-decoration-none mb-2">
                                        {{ Str::title($data->nama_produk) }}
                                    </a>
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="small text-danger"><s>{{ rupiah($data->harga_produk) }}</s></p>
                                        <h5 class="text-warning fw-bold mt-auto">{{ rupiah($data->harga_produk) }}</h5>
                                    </div>
                                    <a href="{{ route('home.produk_detail', $data->id_produk) }}" class="btn btn-sm mt-3 rounded-pill text-white fw-semibold" style="background: linear-gradient(135deg, #f26514, #ffd014);">
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

{{-- FOOTER FULL WIDTH FIXED --}}
<div style="background: linear-gradient(135deg, #f26514, #ffd014); color:white; width:100vw; margin-left: calc(-50vw + 50%); margin-top: 100px; padding-top: 60px; padding-bottom: 40px;">
    <footer class="text-white">
        <div class="container">
            <div class="row footer-responsive-wrapper">

                {{-- ABOUT US --}}
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="fw-bold mb-3 text-white">About Us</h5>
                    <p class="text-white">
                        LOKALISTA adalah platform untuk mendukung UMKM Indramayu dengan teknologi. Temukan produk lokal berkualitas dengan mudah dan cepat.
                    </p>
                    <ul class="list-unstyled text-white">
                        <li>
                            <i class="bi bi-geo-alt-fill text-light me-2"></i>
                            Jl. MT Haryono No 11/B - Sindang, Indramayu
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-whatsapp text-light me-2"></i>
                            <a href="https://wa.me/6281320802262" target="_blank" class="text-white text-decoration-none">
                                Chat via WhatsApp Admin</a>
                        </li>
                        
                        <li class="mb-3">
                            <i class="bi bi-envelope-fill text-light me-2"></i>
                            <a href="mailto:diskopindag_imy@yahoo.com" class="text-white text-decoration-none">diskopindag_imy@yahoo.com</a>
                        </li>
                    </ul>
                </div>

                {{-- CATEGORIES --}}
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="fw-bold mb-3 text-white">Categories</h5>
                    <ul class="list-unstyled text-white small">
                        @forelse ($kategori as $item)
                            <li>{{ $item->nama_kategori }}</li>
                        @empty
                            <li>Belum ada kategori</li>
                        @endforelse
                    </ul>
                </div>

                {{-- INSTAGRAM --}}
                <div class="col-md-4 mb-4 footer-instagram" data-aos="fade-up" data-aos-delay="300">
                    <h5 class="fw-bold mb-3 text-white">Instagram</h5>
                    <div class="d-flex gap-2 align-items-center">
                        <a href="https://www.instagram.com/diskopdagin_imy?igsh=dzZrdm9obGF4eXJ1" target="_blank">
                            <img src="{{ asset('lokalista/IGlogo.png') }}" alt="Instagram Icon" width="40" height="40" class="rounded-circle" style="background-color: white; padding: 5px;">
                        </a>
                        <span class="text-white small">@diskopdagin_imy</span>
                    </div>
                </div>

            {{-- FRAME DISKOPDAGIN --}}
            <div class="row align-items-center p-3 px-3 rounded mb-4 mt-4 footer-diskopdagin" 
            style="background: linear-gradient(135deg, #f23d14, #ff7e14);" 
            data-aos="zoom-in">
           <div class="col-md-2 text-center mb-2 mb-md-0">
               <img src="{{ asset('lokalista/logoimy.png') }}" alt="Diskopdagin Logo" class="img-fluid" style="max-height: 80px;">
           </div>
           <div class="col-md-10">
               <p class="mb-0 text-white fw-semibold">
                   Aplikasi ini merupakan inisiatif dari <strong>Dinas Koperasi, UKM, Perdagangan dan Perindustrian (Diskopdagin)</strong> Kabupaten Indramayu untuk mendukung pertumbuhan UMKM lokal melalui transformasi digital.
               </p>
           </div>
       </div>
       
            <hr class="border-light mt-4">
            <div class="text-center text-white small">
                © {{ now()->year }} <strong>LOKALISTA</strong> — Mendukung UMKM Indramayu.
            </div>
        </div>
    </footer>
</div>
</div>
@endsection


@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="/metrica/dist/assets/libs/@midzer/tobii/tobii.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
/* === BANNER PROMO === */
.promo-banner {
    position: relative;
    background-size: cover;
    background-position: center;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
}
.bg-pattern::before {
    content: "";
    background-image: url('https://www.transparenttextures.com/patterns/arches.png');
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: 0;
}
.promo-banner h2,
.promo-banner p {
    position: relative;
    z-index: 2;
}

/* === CAROUSEL === */
.custom-carousel {
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}
.carousel-indicators li {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #ED7D31 !important;
    margin: 5px;
}
.carousel-indicators .active {
    background-color: #ED7D31 !important;
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: brightness(0) invert(1);
}
@media (max-width: 576px) {
    .custom-carousel {
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        margin-top: 20px;
    }

    .custom-carousel img {
        height: 180px;
        object-fit: cover;
    }

    .carousel-indicators li {
        width: 8px;
        height: 8px;
        margin: 3px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 20px;
        height: 20px;
    }
}


/* === FILTER BUTTON === */
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
.custom-filter-btn.active {
    background-color: #fff !important;
    color: #000 !important;
}
.filter-options {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

/* === PRODUK CARD === */
.produk-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    background-color: #fff;
    border: none;
}
.produk-card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
.produk-card img {
    object-fit: cover;
    width: 100%;
    height: 160px;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
}
.produk-card .card-body {
    display: flex;
    flex-direction: column;
    padding: 16px;
}
.produk-card .card-body p,
.produk-card .card-body a,
.produk-card .card-body h5 {
    margin: 0;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .produk-card img {
        height: 140px;
    }
    .produk-card .card-body {
        padding: 12px;
    }
    .produk-card .btn {
        font-size: 13px;
        padding: 6px 10px;
    }
    .produk-card .card-body p,
    .produk-card .card-body a,
    .produk-card .card-body h5 {
        font-size: 13px;
    }
}
@@media (max-width: 576px) {
    .footer-flex-top {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .footer-about,
    .footer-categories {
        flex: 0 0 48%;
        max-width: 48%;
    }

    .footer-about p,
    .footer-about ul,
    .footer-categories ul {
        margin-bottom: 0.5rem;
    }

/* Logo Instagram di footer */
.footer-instagram img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    background-color: white;
    padding: 5px;
}

/* Ukuran saat mobile */
@media (max-width: 576px) {
    .footer-instagram img {
        width: 40px;
        height: 40px;
        padding: 4px;
    }

    .footer-instagram span {
        font-size: 14px;
    }

    .footer-instagram .d-flex {
        align-items: center;
        gap: 10px;
    }
}
    footer h5 {
        font-size: 15px;
        margin-bottom: 8px;
    }

    footer p, footer li, footer a {
        font-size: 13px;
        line-height: 1.4;
    }

    footer .container {
        padding-left: 16px;
        padding-right: 16px;
    }
}
@media (max-width: 576px) {
    .footer-diskopdagin {
        flex-direction: column !important;
        text-align: center;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .footer-diskopdagin img {
        max-width: 100px;
        margin-bottom: 10px;
    }

    .footer-diskopdagin p {
        font-size: 14px;
        line-height: 1.6;
        padding: 0 5px;
    }
}


</style>
@endsection


@section('js')
<script src="/metrica/dist/assets/libs/shufflejs/shuffle.min.js"></script>
<script src="/metrica/dist/assets/libs/@midzer/tobii/tobii.min.js"></script>
<script src="/metrica/dist/assets/JS/pages/gallery.init.js"></script>

<!-- AOS Animate On Scroll -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
    });
</script>
@endsection