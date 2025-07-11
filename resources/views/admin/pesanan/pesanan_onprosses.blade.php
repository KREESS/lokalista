@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col align-self-center">
                            <h4 class="page-title pb-md-0">Pesanan Di Terima</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Pesanan Di Terima</li>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!--end card-header-->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Produk</th>
                                        <th>Quantity</th>
                                        <th>Pengiriman</th>
                                        <th>invoice</th>
                                        <th>Action</th>
                                        <th>Tanggal Order</th>
                                    </tr>
                                    <!--end tr-->
                                </thead>
                                <tbody>
                                    @php
                                        function rupiah($angka)
                                        {
                                            $hasil_rupiah = 'Rp ' . number_format($angka, 2, ',', '.');
                                            return $hasil_rupiah;
                                        }
                                    @endphp
                                    @foreach ($pesanan as $data)
                                        <tr>
                                            <td>#PP00{{ $data->id_pesanan }}</td>
                                            <td><img src="/produk/{{ $data->foto_produk }}" alt=""
                                                    class="thumb-sm rounded-circle me-2">
                                                {{ Str::title($data->nama_produk) }}</td>
                                            <td>{{ $data->quantity }} / Pcs</td>
                                            <td>{{ $data->nama_kota . ' [ ' . $data->nama_prov . ' ] ' }}</td>
                                            <td><a href="{{ route('admin.pesanan_invoice', $data->id_pesanan) }}"
                                                    target="_blank" class="btn btn-sm btn-secondary"><i
                                                        class="ti ti-file-invoice"> Invoice</i></a></td>
                                            <<td>
                                                @if ($data->status == 2)
                                                    {{-- Jika status 2 (onproses), tampilkan tombol Kirim Produk --}}
                                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#modalKirim{{ $data->id_pesanan }}">
                                                        <i class="ti ti-truck-delivery"></i> Kirim Produk
                                                    </button>
                                            
                                                    <!-- Modal Kirim Produk -->
                                                    <div class="modal fade" id="modalKirim{{ $data->id_pesanan }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="modalLabel{{ $data->id_pesanan }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{ route('admin.pesanan_kirim') }}" method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body text-center">
                                                                        <div class="mb-3">
                                                                            <label for="resi{{ $data->id_pesanan }}">Nomor Resi JNE</label>
                                                                            <input type="text" name="resi" class="form-control"
                                                                                id="resi{{ $data->id_pesanan }}" placeholder="Nomor Resi" required>
                                                                            <input type="hidden" name="id_pesanan" value="{{ $data->id_pesanan }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit" class="btn btn-de-primary btn-sm">Kirim Resi</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($data->status == 3)
                                                    <span class="badge bg-info">Dalam Pengiriman</span>
                                                @elseif ($data->status == 4)
                                                    <span class="badge bg-success">Pesanan Diterima</span>
                                                @elseif ($data->tipe_pembayaran == 'dp')
                                                    {{-- Logika untuk pesanan dengan sistem DP --}}
                                                    @if ($data->dp_status == 'dp')
                                                        <a href="{{ route('admin.pesanan_tagihan', $data->id_pesanan) }}"
                                                            class="btn btn-sm btn-warning"><i class="ti ti-report-money"></i> Kirim Tagihan</a>
                                                    @elseif ($data->dp_status == 'tagihan')
                                                        <span class="badge bg-warning">Tagihan Dikirim</span>
                                                    @elseif ($data->dp_status == 'upload_lunas')
                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#sisaModal{{ $data->id_pesanan }}">Cek Sisa</button>
                                                        <a href="{{ route('admin.tolak_sisa', $data->id_pesanan) }}" class="btn btn-sm btn-outline-danger">Tolak</a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#modalKirim{{ $data->id_pesanan }}" class="btn btn-sm btn-success">Kirim Produk</a>
                                            
                                                        <!-- Modal Cek Sisa Pembayaran -->
                                                        <div class="modal fade" id="sisaModal{{ $data->id_pesanan }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="sisaLabel{{ $data->id_pesanan }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title">Bukti Sisa Pembayaran</h6>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="/bukti_bayar/{{ $data->bukti_bayar_dp_lunas }}" class="img-fluid mb-2" alt="Bukti">
                                                                        <h6>Sisa Tagihan: {{ rupiah($data->total_dp) }}</h6>
                                                                        <p class="text-muted">Klik gambar untuk zoom jika diperlukan.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif ($data->dp_status == 'sisa tolak')
                                                        <span class="badge bg-danger">Sisa Pembayaran Ditolak</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Menunggu Pembayaran</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $date = date('d-M-Y', strtotime($data->updated_at));
                                                    echo $date;
                                                @endphp
                                            </td>
                                            <div class="modal fade bd-example-modal-sm"
                                                id="exampleModalSmall{{ $data->id_pesanan }}" tabindex="-1" role="dialog"
                                                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.pesanan_kirim') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('post')
                                                            <div class="modal-body text-center">
                                                                <div class="mb-0">
                                                                    <label for="exampleInputEmail1">Nomor Resi JNE</label>
                                                                    <input type="text" name="resi"
                                                                        class="form-control" id="exampleInputEmail1"
                                                                        placeholder="Nomor Resi" required>
                                                                    <input type="text" name="id_pesanan"
                                                                        value="{{ $data->id_pesanan }}" class="form-control"
                                                                        id="exampleInputEmail1" hidden>
                                                                </div>
                                                            </div>
                                                            <!--end modal-body-->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-de-secondary btn-sm"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit"
                                                                    class="btn btn-de-primary btn-sm">Kirim Resi</button>
                                                            </div>
                                                        </form>
                                                        <!--end modal-footer-->
                                                    </div>
                                                    <!--end modal-content-->
                                                </div>
                                                <!--end modal-dialog-->
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/js/zoom.css">
@endsection

@section('js')
    <script src="/js/zoom.js"></script>
@endsection
