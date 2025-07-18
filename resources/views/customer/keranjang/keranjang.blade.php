@extends('customer.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col align-self-center">
                            <h4 class="page-title pb-md-0">Keranjang</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Keranjang</li>
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
        </div>

        @php
            function rupiah($angka)
            {
                $hasil_rupiah = 'Rp ' . number_format($angka, 2, ',', '.');
                return $hasil_rupiah;
            }
        @endphp
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    @if (session('success'))
                        <div class="alert alert-success border-0" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                
                    @if (session('gagal'))
                        <div class="alert alert-danger border-0" role="alert">
                            {{ session('gagal') }}
                        </div>
                    @endif
                <div class="card">
                    <!--end card-header-->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Harga</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Checkout</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($keranjang && $keranjang->count() > 0)
                                        @foreach ($keranjang as $item)  <!-- Iterasi setiap item di keranjang -->
                                            <tr>
                                                <td>
                                                    <!-- Menampilkan gambar produk -->
                                                    <img src="/produk/{{ $item->foto_produk }}" alt="" height="40" class="me-2">
                                                    <p class="d-inline-block align-middle mb-0">
                                                        <a href="{{ route('customer.produk_detail', $item->id_produk) }}"
                                                            class="d-inline-block align-middle mb-0 product-name">{{ Str::title($item->nama_produk) }}</a>
                                                        <br>
                                                        <span class="text-muted font-13">{{ Str::title($item->nama_kategori) }}</span>
                                                    </p>
                                                </td>
                                                <td>{{ rupiah($item->harga_produk) }}</td>
                                                <td>
                                                    <form action="{{ route('customer.keranjang_update', $item->id_keranjang) }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="text" name="id_produk" value="{{ $item->id_produk }}" hidden>
                                                        <input class="form-control w-25" style="display:inline-block" name="quantity" type="number" value="{{ $item->quantity }}">
                                                        <button type="submit" class="btn btn-sm btn-primary">Perbaharui</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    @php
                                                        $total = $item->harga_produk * $item->quantity;
                                                        echo rupiah($total);
                                                    @endphp
                                                </td>
                                                <td>
                                                    <a href="{{ route('customer.checkout', $item->id_keranjang) }}" class="btn btn-sm btn-warning">
                                                        Checkout <i class="fas fa-long-arrow-alt-right ml-1"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <!-- Form untuk submit delete, tersembunyi -->
                                                    <form id="keranjang-form-{{ $item->id_keranjang }}" action="{{ route('customer.keranjang_delete', $item->id_keranjang) }}" method="POST" class="d-none">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                
                                                    <!-- Tombol Hapus dengan konfirmasi -->
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id_keranjang }})">
                                                        <i class="ti ti-trash"></i> Hapus
                                                    </button>
                                                </td>                                                
                                                
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Keranjang Anda kosong</td>
                                        </tr>
                                    @endif
                                </tbody>                                
                            </table>
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-->
                </div>
                <!--end card-body-->
            </div>
            <!--end col-->

        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script>
         window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2500);
    </script> --}}
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Produk ini akan dihapus dari keranjang!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('keranjang-form-' + id).submit();
                    }
                })
            }
        
            // Auto hide alert success
            window.setTimeout(function () {
                $(".alert").fadeTo(500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 2500);
        </script>
@endsection
