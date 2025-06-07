@extends('customer.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col align-self-center">
                            <h4 class="page-title pb-md-0">Checkout</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Checkout</li>
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

        {{-- @php
            function rupiah($angka)
            {
                $hasil_rupiah = 'Rp ' . number_format($angka, 2, ',', '.');
                return $hasil_rupiah;
            }
        @endphp --}}

        <?php
        if (!function_exists('rupiah')) {
            function rupiah($angka)
            {
                $hasil_rupiah = 'Rp ' . number_format($angka, 2, ',', '.');
                return $hasil_rupiah;
            }
        }
        ?>

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Sekilas Pesanan</h4>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-header-->
                    <div class="card-body">
                        <div class="table-responsive shopping-cart">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($keranjang as $item)
                                        <tr>
                                            <td>
                                                <img src="/produk/{{ $item->foto_produk }}" alt="" height="40">
                                                <p class="d-inline-block align-middle mb-0 product-name">
                                                    {{ $item->nama_produk }}
                                                </p>
                                            </td>
                                            <td>
                                                {{ $item->quantity }}
                                            </td>
                                            <td>
                                                @php
                                                    $stok = $item->quantity;
                                                    $harga = $item->harga_produk;
                                                    $total = $harga * $stok;
                                                    echo rupiah($total);
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <!--end re-table-->
                        <div class="total-payment">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold">Subtotal</td>
                                        <td>{{ rupiah($total) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Berat Produk</td>
                                        <td>{{ $berat_total }} Gram</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">
                                            Pengiriman (Ongkir)
                                            <br>
                                            [JNE-REG]
                                        </td>
                                        <td>
                                            {{-- @php
                                                foreach ($ongkir as $ongkir) {
                                                    // dd($ongkir['costs'][1]);
                                                    $cost = $ongkir['costs'][1];
                                                    foreach ($cost as $costs) {
                                                        $costs = $cost['cost'];
                                                        foreach ($costs as $costs) {
                                                            $harga_ongkir = $costs['value'];
                                                            $estimasi = $costs['etd'];
                                                        }
                                                    }
                                                }
                                                echo rupiah($harga_ongkir);
                                            @endphp --}}
                                            @php
                                                $harga_ongkir = 0;
                                                $estimasi = '';

                                                foreach ($ongkir as $ongkirItem) {
                                                    if (!empty($ongkirItem['costs'])) {
                                                        $cost = $ongkirItem['costs'][1] ?? $ongkirItem['costs'][0];

                                                        if (!empty($cost['cost'])) {
                                                            foreach ($cost['cost'] as $costDetail) {
                                                                $harga_ongkir = $costDetail['value'] ?? 0;
                                                                $estimasi = $costDetail['etd'] ?? '';
                                                                // Jika hanya butuh satu, bisa break di sini
                                                                break;
                                                            }
                                                        }
                                                    }
                                                }

                                                echo rupiah($harga_ongkir);
                                            @endphp

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Estimasi Tiba</td>
                                        <td>{{ $estimasi }} Hari</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold  border-bottom-0">Total</td>
                                        <td class="text-dark  border-bottom-0">
                                            <strong>
                                                @php
                                                    $total_bayar = $total + $harga_ongkir;
                                                    echo rupiah($total_bayar);
                                                @endphp
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                        <!--end total-payment-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Alamat Pengiriman</h4>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-header-->
                    <div class="card-body">
                        <form class="mb-0">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Penerima <small
                                                class="text-danger font-13">*</small></label>
                                        <input type="text" name="nama" class="form-control" id="firstname"
                                            value="{{ $pengiriman->nama_penerima }}" placeholder="Nama Penerima" readonly>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Provinsi<small
                                                class="text-danger font-13">*</small></label>
                                        <input type="text" class="form-control" id="firstname"
                                            value="{{ $pengiriman->nama_prov }}" placeholder="Nama Penerima" readonly>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kota<small class="text-danger font-13">*</small></label>
                                        <input type="text" class="form-control" id="firstname"
                                            value="{{ $pengiriman->nama_kota }}" placeholder="Nama Penerima" readonly>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kode Pos<small
                                                class="text-danger font-13">*</small></label>
                                        <input type="text" class="form-control" id="firstname"
                                            value="{{ $pengiriman->kode_pos }}" placeholder="Nama Penerima" readonly>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nomor Telp<small
                                                class="text-danger font-13">*</small></label>
                                        <input type="text" class="form-control" id="firstname"
                                            value="{{ $pengiriman->no_telp }}" placeholder="Nama Penerima" readonly>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label my-2">Alamat Lengkap<small
                                                class="text-danger font-13">*</small></label>
                                        <input type="text" class="form-control" required=""
                                            value="{{ $pengiriman->alamat_lengkap }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="#" class="text-primary"></a>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('alamat.index') }}" class="text-primary">Ubah Alamat <i
                                            class="fas fa-long-arrow-alt-right ml-1"></i></a>
                                </div>
                            </div>
                        </form>
                        <!--end form-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
<form method="POST" action="{{ route('checkout.proses') }}" id="formCheckout">
    @csrf

    <!-- Data dinamis dari keranjang -->
    @foreach ($keranjang as $item)
        <input type="hidden" name="id_produk[]" value="{{ $item['id_produk'] }}">
        <input type="hidden" name="quantity[]" value="{{ $item['quantity'] }}">
    @endforeach

    <!-- Data tetap -->
    <input type="hidden" name="total_bayar" value="{{ $total_bayar }}">
    <input type="hidden" name="ongkir" value="{{ $harga_ongkir }}">

    <!-- Tombol Bayar -->
    <button type="submit" class="btn btn-warning mt-3" id="pay-button">Bayar Sekarang</button>
</form>




                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->

                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end col-->
        </div>
    </div>
@endsection

@section('js')
    <script>
        imgInp1.onchange = evt => {
            const [file] = imgInp1.files
            if (file) {
                output1.src = URL.createObjectURL(file)
            }
        };
    </script>
@endsection
