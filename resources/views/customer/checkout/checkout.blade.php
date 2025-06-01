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
                                        <td class="text-dark  border-bottom-0"><strong>
                                                @php
                                                    $total_bayar = $total + $harga_ongkir;
                                                    echo rupiah($total_bayar);
                                                @endphp
                                            </strong></td>
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
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Rekening Pembayaran</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">

                                {{-- Pilihan Metode Pembayaran --}}
                                <div class="mb-3">
                                    <label for="payment-method">Metode Pembayaran</label>
                                    <select class="form-select" id="payment-method" name="payment_method" required>
                                        <option value="">-- Pilih Metode Pembayaran --</option>
                                        <option value="rekening">Rekening Bank</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                </div>

                                {{-- Section Rekening --}}
                                <div id="rekening-section" style="display:none;">
                                    @foreach ($rekening as $r)
                                        <div class="row no-gutters mb-3">
                                            <div class="col-md-3 align-self-center text-center">
                                                <img height="50"
                                                    src="/rekening/{{ strtolower($r->jenis_rekening) }}.jpg"
                                                    alt="Logo {{ $r->jenis_rekening }}">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body p-2">
                                                    <p class="card-text mb-0">
                                                        Nama Rekening : <b> {{ Str::title($r->nama_rek) }} </b><br>
                                                        Nomor Rekening : <b> {{ $r->no_rek }} </b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>

                                {{-- Section QRIS --}}
                                <div id="qris-section" style="display:none;">
                                    <h5>QRIS Pembayaran</h5>
                                    <div id="qris-code" style="text-align: center; margin-top: 20px;">
                                        <p id="qris-expired" style="margin-top: 10px; font-weight: bold; color: red;"></p>
                                        {{-- QR code akan muncul di sini --}}
                                    </div>
                                    <form id="payment-form" style="text-align:center; margin-top:15px;">
                                        <input type="hidden" name="amount" value="{{ $total + $harga_ongkir }}">
                                        <button type="submit" id="pay-btn" class="btn btn-primary"
                                            style="margin-bottom: 30px;">Bayar
                                            Sekarang</button>
                                    </form>
                                </div>

                                {{-- Form Upload Bukti Bayar untuk Rekening --}}
                                <div id="form-rekening" style="display:none;">
                                    <div class="text-center align-items-center mb-3">
                                        <h4 class="header-title mb-2">Upload Bukti Bayar (Rekening Bank)</h4>
                                        <img id="output1" src="/dapuranita/default-produk.png" height="200"
                                            width="200" alt="Preview Bukti Bayar" class="rounded">
                                    </div>
                                    <form action="{{ route('customer.pesanan_store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('post')

                                        <div class="mb-3">
                                            <label for="jenis-transaksi">Jenis Transaksi</label>
                                            <select class="form-select @error('metode') is-invalid @enderror"
                                                name="metode" id="jenis-transaksi" required>
                                                <option value="lunas">Lunas [Tagihan : @php echo rupiah($total_bayar); @endphp]</option>
                                                <option value="dp">DP [Tagihan : @php
                                                    $dp = $total_bayar * 0.5;
                                                    echo rupiah($dp);
                                                @endphp]</option>
                                            </select>
                                            @error('metode')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Input Hidden lainnya --}}
                                        @foreach ($keranjang as $item)
                                            <input type="text" name="id_keranjang[]"
                                                value="{{ $item->id_keranjang }}" hidden>
                                            <input type="hidden" name="id_produk[]" value="{{ $item->id_produk }}">
                                            <input type="hidden" name="quantity[]" value="{{ $item->quantity }}">
                                        @endforeach
                                        <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                                        <input type="hidden" name="harga_produk" value="{{ $total }}">
                                        <input type="hidden" name="ongkir" value="{{ $harga_ongkir }}">
                                        <input type="hidden" name="total_bayar" value="{{ $total_bayar }}">
                                        <input type="text" name="dp" value="{{ $dp }}" hidden>

                                        <label for="bukti_bayar">Upload Bukti Pembayaran</label>
                                        <input type="file" name="bukti_bayar"
                                            class="form-control mb-2 @error('bukti_bayar') is-invalid @enderror"
                                            accept="image/*" id="imgInp1" required>
                                        @error('bukti_bayar')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <button type="submit" class="btn btn-success w-100">Upload Bukti
                                            Pembayaran</button>
                                    </form>
                                </div>

                                {{-- Form Upload Bukti Bayar untuk QRIS --}}
                                <div id="form-qris" style="display:none;">
                                    <div class="text-center align-items-center mb-3">
                                        <h4 class="header-title mb-2">Upload Bukti Bayar (QRIS)</h4>
                                        <img id="output2" src="/dapuranita/default-produk.png" height="200"
                                            width="200" alt="Preview Bukti Bayar" class="rounded">
                                    </div>
                                    <form action="{{ route('customer.pesanan_store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('post')

                                        {{-- Input Hidden sama dengan form rekening --}}
                                        @foreach ($keranjang as $item)
                                            <input type="text" name="id_keranjang[]"
                                                value="{{ $item->id_keranjang }}" hidden>
                                            <input type="hidden" name="id_produk[]" value="{{ $item->id_produk }}">
                                            <input type="hidden" name="quantity[]" value="{{ $item->quantity }}">
                                        @endforeach
                                        <input type="text" name="id_user" value="{{ Auth::user()->id }}" hidden>
                                        <input type="hidden" name="harga_produk" value="{{ $total }}">
                                        <input type="hidden" name="ongkir" value="{{ $harga_ongkir }}">
                                        <input type="hidden" name="total_bayar" value="{{ $total_bayar }}">
                                        <input type="text" name="dp" value="{{ $dp }}" hidden>

                                        <label for="bukti_bayar_qris">Upload Bukti Pembayaran</label>
                                        <input type="file" name="bukti_bayar"
                                            class="form-control mb-2 @error('bukti_bayar') is-invalid @enderror"
                                            accept="image/*" id="imgInp2" required>
                                        @error('bukti_bayar')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <button type="submit" class="btn btn-success w-100">Upload Bukti
                                            Pembayaran</button>
                                    </form>
                                </div>

                            </div>

                            <style>
                                #qris-code img {
                                    width: 250px;
                                    height: 250px;
                                    object-fit: contain;
                                }
                            </style>

                            <script>
                                const paymentSelect = document.getElementById('payment-method');
                                const rekeningSection = document.getElementById('rekening-section');
                                const qrisSection = document.getElementById('qris-section');
                                const formRekening = document.getElementById('form-rekening');
                                const formQris = document.getElementById('form-qris');

                                paymentSelect.addEventListener('change', function() {
                                    if (this.value === 'rekening') {
                                        rekeningSection.style.display = 'block';
                                        qrisSection.style.display = 'none';
                                        formRekening.style.display = 'block';
                                        formQris.style.display = 'none';
                                    } else if (this.value === 'qris') {
                                        rekeningSection.style.display = 'none';
                                        qrisSection.style.display = 'block';
                                        formRekening.style.display = 'none';
                                        formQris.style.display = 'block';
                                    } else {
                                        rekeningSection.style.display = 'none';
                                        qrisSection.style.display = 'none';
                                        formRekening.style.display = 'none';
                                        formQris.style.display = 'none';
                                    }
                                });

                                function startCountdown(seconds) {
                                    const expiredElem = document.getElementById('qris-expired');
                                    let remaining = seconds;

                                    function updateTimer() {
                                        const minutes = Math.floor(remaining / 60);
                                        const secs = remaining % 60;

                                        expiredElem.textContent = `Kode akan kadaluarsa dalam ${minutes}:${secs.toString().padStart(2, '0')} menit`;

                                        if (remaining <= 0) {
                                            // expiredElem.textContent = 'Kode QR sudah kadaluarsa';
                                            document.getElementById('qris-code').innerHTML =
                                                '<p style="color:red;">Kode QR sudah tidak berlaku. Silakan refresh halaman.</p>';

                                            clearInterval(timer);
                                            // document.getElementById("pay-btn").disabled = true;
                                            document.getElementById("pay-btn").style.display = "inline-block";
                                        }

                                        remaining--;
                                    }

                                    updateTimer(); // Update pertama langsung
                                    const timer = setInterval(updateTimer, 1000); // Update setiap detik
                                }

                                // Script untuk QRIS Payment (submit form)
                                document.getElementById("payment-form")?.addEventListener("submit", function(e) {
                                    e.preventDefault();

                                    const amount = document.querySelector('input[name="amount"]').value;

                                    fetch('/api/process-payment', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                            },
                                            body: JSON.stringify({
                                                amount: parseInt(amount)
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.qr) {
                                                document.getElementById('qris-code').innerHTML = `
            <img src="${data.qr}" alt="QR Code Pembayaran" style="max-width: 300px;">
            <p id="qris-expired" style="margin-top: 10px; font-weight: bold; color: red;"></p>
        `;

                                                // ✅ Sembunyikan tombol bayar sekarang
                                                document.getElementById("pay-btn").style.display = "none";

                                                // ⏳ Jalankan countdown expired jika ada
                                                if (data.expired_at) {
                                                    startCountdown(data.expired_at);
                                                }
                                            } else {
                                                alert('Gagal mendapatkan QR Code');
                                            }
                                        })

                                        .catch(error => {
                                            console.error(error);
                                            alert('Terjadi kesalahan saat memproses pembayaran');
                                        });
                                });

                                let countdownInterval;

                                function startCountdown(seconds) {
                                    clearInterval(countdownInterval); // clear interval sebelumnya jika ada
                                    const countdownEl = document.getElementById('qris-expired');
                                    if (!countdownEl) return;

                                    let timeLeft = seconds;

                                    function updateCountdown() {
                                        const minutes = Math.floor(timeLeft / 60);
                                        const seconds = timeLeft % 60;
                                        countdownEl.textContent = `Kode QR berlaku dalam ${minutes}:${seconds.toString().padStart(2, '0')} menit`;

                                        if (timeLeft <= 0) {
                                            clearInterval(countdownInterval);
                                            countdownEl.textContent = "QR Code sudah kedaluwarsa";
                                            document.getElementById('qris-code').innerHTML = "";
                                        }

                                        timeLeft--;
                                    }

                                    updateCountdown(); // tampilkan langsung
                                    countdownInterval = setInterval(updateCountdown, 1000);
                                }


                                // Preview gambar upload bukti bayar rekening
                                document.getElementById('imgInp1').addEventListener('change', function(e) {
                                    const [file] = this.files;
                                    if (file) {
                                        document.getElementById('output1').src = URL.createObjectURL(file);
                                    }
                                });

                                // Preview gambar upload bukti bayar QRIS
                                document.getElementById('imgInp2').addEventListener('change', function(e) {
                                    const [file] = this.files;
                                    if (file) {
                                        document.getElementById('output2').src = URL.createObjectURL(file);
                                    }
                                });
                            </script>



                            {{-- <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h4 class="card-title">Rekening Pembayaran</h4>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-header-->
                            <div class="card-body">
                                @foreach ($rekening as $rekening)
                                    <div class="row no-gutters">
                                        <div class="col-md-3 align-self-center text-center">
                                            @if ($rekening->jenis_rekening == 'bni')
                                                <img class="" height="50" src="/rekening/BNI.jpg"
                                                    alt="Card image">
                                            @elseif ($rekening->jenis_rekening == 'bri')
                                                <img class="" height="50" src="/rekening/bri.png"
                                                    alt="Card image">
                                            @elseif ($rekening->jenis_rekening == 'bsi')
                                                <img class="" height="50" src="/rekening/bsi.jpg"
                                                    alt="Card image">
                                            @elseif ($rekening->jenis_rekening == 'bca')
                                                <img class="" height="50" src="/rekening/bca.png"
                                                    alt="Card image">
                                            @elseif ($rekening->jenis_rekening == 'mandiri')
                                                <img class="" height="50" src="/rekening/mandiri.png"
                                                    alt="Card image">
                                            @endif

                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    Nama Rekening : <b> {{ Str::title($rekening->nama_rek) }} </b><br>
                                                    Nomor Rekening : <b> {{ $rekening->no_rek }} </b>
                                                </p>
                                            </div>
                                            <!--end card-body-->
                                        </div>
                                        <hr>
                                        <!--end col-->
                                    </div>
                                @endforeach
                            </div> --}}
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
