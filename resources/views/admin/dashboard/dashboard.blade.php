@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
            </div>
        </div>
    </div>

@php
    if (!function_exists('rupiah')) {
        function rupiah($angka) {
            return 'Rp ' . number_format($angka, 2, ',', '.');
        }
    }
@endphp

    <div class="row">
        <div class="col-lg-12">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark mb-0 fw-semibold">Pengguna Terdaftar</p>
                            <h3 class="my-1 font-20 fw-bold">{{ $total_customer }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark mb-0 fw-semibold">Total Transaksi</p>
                            <h3 class="my-1 font-20 fw-bold">{{ $total_penjualan }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark mb-0 fw-semibold">Total Pendapatan</p>
                            <h3 class="my-1 font-20 fw-bold">{{ rupiah($total_pendapatan) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-dark mb-0 fw-semibold">Produk Terjual</p>
                            <h3 class="my-1 font-20 fw-bold">{{ $total_produk }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-4">Produk Terjual</h4>
                    <canvas id="myChart" width="100" height="30"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="/metrica/dist/assets/libs/simple-datatables/style.css" rel="stylesheet" type="text/css" />
@endsection

@section('js')
    <script src="/Chart.js/Chart.bundle.js"></script>
<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach ($data_produk as $item)
                    "{{ $item->nama_produk }}",
                @endforeach
            ],
            datasets: [{
                label: 'Jumlah Terjual (Status Lunas)',
                data: [
                    @foreach ($data_produk as $item)
                        {{ $item->total_quantity }},
                    @endforeach
                ],
                backgroundColor: 'rgba(52, 76, 235, 0.8)',
                borderColor: 'rgba(52, 76, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>


    <script src="/metrica/dist/assets/libs/simple-datatables/umd/simple-datatables.js"></script>
    <script src="/metrica/dist/assets/js/pages/datatable.init.js"></script>
@endsection
