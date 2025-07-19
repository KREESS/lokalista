@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Laporan</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Laporan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @php
            function rupiah($angka)
            {
                $hasil_rupiah = 'Rp ' . number_format($angka, 2, ',', '.');
                return $hasil_rupiah;
            }
        @endphp
        {{-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.laporan_cari') }}" method="post" autocomplete="off">
                            @csrf
                            @method('post')
                            <h4 class="header-title mb-4">Rentang Waktu Laporan</h4>
                            <div class="input-daterange input-group mb-3" id="datepicker6" data-date-format="yyyy-mm-dd"
                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input class="form-control"  type="date" value="Tanggal Mulai" id="example-date-input" required />
                                <input class="form-control"  type="date" value="Tanggal Selesai" id="example-date-input" required />
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Cetak Laporan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Transaksi</h4>
                    </div>
                    <!--end card-header-->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table-datatables">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Produk</th>
                                        <th>Quantity</th>
                                        <th>Pengiriman</th>
                                        <th>invoice</th>
                                        <th>Tanggal Order</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                            <td>
                                                @php
                                                    $date = date('d-M-Y', strtotime($data->updated_at));
                                                    echo $date;
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

@endsection

@section('js')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> --}}

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script>
    const namaLaporan = @json($nama_laporan);
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#table-datatables').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    filename: namaLaporan,
                    orientation: 'portrait',
                    pageSize: 'A4',
                    title: '',
                    customize: function (doc) {
                        // 1. Kop surat
                        doc.content.splice(0, 0, {
                            alignment: 'center',
                            margin: [0, 0, 0, 10],
                            stack: [
                                { text: 'KOPERASI UMKM INDRAMAYU', fontSize: 16, bold: true },
                                { text: 'Jl. MT Haryono No. 11/B - Sindang, Indramayu', fontSize: 10 },
                                { text: 'Telp: (021) 1234567 | Email: info@koperasims.id', fontSize: 10 },
                                {
                                    canvas: [{ type: 'line', x1: 0, y1: 5, x2: 515, y2: 5, lineWidth: 1 }],
                                    margin: [0, 5, 0, 5]
                                },
                                { text: 'LAPORAN PENJUALAN', fontSize: 14, bold: true, margin: [0, 10, 0, 10] }
                            ]
                        });

                        // 2. Tanggal hari ini (Indonesia)
                        const now = new Date();
                        const formattedDate = now.toLocaleDateString('id-ID', {
                            day: '2-digit', month: 'long', year: 'numeric'
                        });

                        // 3. Tanda tangan formal
                        doc.content.push({
                            margin: [0, 50, 0, 0],
                            columns: [
                                {
                                    width: '*',
                                    alignment: 'center',
                                    stack: [
                                        { text: `Indramayu, ${formattedDate}`, fontSize: 11, italics: true, margin: [0, 0, 0, 40] },
                                        { text: 'Admin Koperasi', fontSize: 11, bold: true },
                                        { text: '(____________________)', fontSize: 11, margin: [0, 40, 0, 0] }
                                    ]
                                },
                                {
                                    width: '*',
                                    alignment: 'center',
                                    stack: [
                                        { text: '', fontSize: 11, margin: [0, 0, 0, 40] },
                                        { text: 'Ketua Koperasi', fontSize: 11, bold: true },
                                        { text: '(____________________)', fontSize: 11, margin: [0, 40, 0, 0] }
                                    ]
                                }
                            ]
                        });

                        // 4. Rapiin tabel
                        const tableIndex = doc.content.findIndex(item => item.table);
                        if (tableIndex !== -1) {
                            doc.content[tableIndex].layout = {
                                hLineWidth: () => 0.5,
                                vLineWidth: () => 0.5,
                                hLineColor: () => '#aaa',
                                vLineColor: () => '#aaa',
                                paddingLeft: () => 4,
                                paddingRight: () => 4,
                                paddingTop: () => 2,
                                paddingBottom: () => 2,
                            };
                            doc.content[tableIndex].table.widths = ['*', '*', '*', '*', '*', '*'];
                        }
                    }
                },
                'print'
            ]
        });
    });
</script>
@endsection
