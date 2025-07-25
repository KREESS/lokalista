@extends('admin.layout.master')

@section('content')
<div class="container-fluid">

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Laporan Penjualan</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

<!-- Form Rentang Tanggal -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.laporan_cari') }}" method="post" autocomplete="off">
                    @csrf
                    <h4 class="header-title mb-4">Filter Laporan Penjualan</h4>

                    <div class="mb-3">
                        <input type="text" name="nama_produk" class="form-control" placeholder="Cari Nama Produk...">
                    </div>

                    <div class="input-daterange input-group mb-3" id="datepicker6"
                         data-date-format="yyyy-mm-dd"
                         data-date-autoclose="true"
                         data-provide="datepicker"
                         data-date-container='#datepicker6'>
                        <input class="form-control" type="date" name="date_start" required />
                        <input class="form-control" type="date" name="date_end" required />
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Cetak Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Tabel Data Laporan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Laporan Transaksi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table-datatables">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Pengiriman</th>
                                    <th>Terakhir Diupdate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPendapatan = 0; @endphp
                                @foreach ($pesanan as $data)
                                    @php
                                        $subtotal = $data->quantity * $data->harga_produk;
                                        $totalPendapatan += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>#PP00{{ $data->id_pesanan }}</td>
                                        <td>
                                            <img src="/produk/{{ $data->foto_produk }}" alt="{{ $data->nama_produk }}" class="thumb-sm rounded-circle me-2">
                                            {{ Str::title($data->nama_produk) }}
                                        </td>
                                        <td>Rp{{ number_format($data->harga_produk, 0, ',', '.') }}</td>
                                        <td>{{ $data->quantity }} / Pcs</td>
                                        <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                                        <td>{{ $data->nama_kota }} [{{ $data->nama_prov }}]</td>
                                        <td>{{ \Carbon\Carbon::parse($data->updated_at)->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total Pendapatan:</th>
                                    <th colspan="4" class="text-start text-primary">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script>
    const namaLaporan = @json($nama_laporan ?? 'Lokalista All Reports');
    const totalPendapatan = {{ $totalPendapatan ?? 0 }};
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
                // 1. Kop Surat
                doc.content.splice(0, 0, {
                    alignment: 'center',
                    margin: [0, 0, 0, 10],
                    stack: [
                        { text: 'DINAS KOPERASI, USAHA KECIL DAN MENENGAH,', fontSize: 16, bold: true },
                        { text: 'PERDAGANGAN DAN PERINDUSTRIAN', fontSize: 16, bold: true},
                        { text: 'Jl. MT Haryono No. 11/B - Sindang, Indramayu', fontSize: 10 },
                        { text: 'Telp: (021) 1234567 | Email: info@koperasims.id', fontSize: 10 },
                        {
                            canvas: [{ type: 'line', x1: 0, y1: 5, x2: 515, y2: 5, lineWidth: 1 }],
                            margin: [0, 5, 0, 5]
                        },
                        { text: 'LAPORAN PENJUALAN', fontSize: 14, bold: true, margin: [0, 10, 0, 10] }
                    ]
                });

                // 2. Temukan tabel utama
                const tableIndex = doc.content.findIndex(item => item.table);
                if (tableIndex !== -1) {
                    const table = doc.content[tableIndex].table;

                    // 3. Tambahkan kolom nomor ke header
                    table.body[0].unshift({ text: 'No', bold: true });

                    // 4. Tambahkan nomor ke setiap baris data (mulai dari index 1 karena index 0 adalah header)
                    for (let i = 1; i < table.body.length; i++) {
                        table.body[i].unshift(i.toString());
                        // Hapus kolom Invoice (kolom ke-7, indeks ke-7 karena sudah ditambahkan kolom nomor)
                        table.body[i].splice(7, 1);
                    }

                    // 5. Hapus juga header "Invoice"
                    table.body[0].splice(7, 1);

                    // 6. Atur ulang lebar kolom (sekarang 8 kolom)
                    doc.content[tableIndex].table.widths = ['3%', '*', '*', '*', '*', '*', '*', '*'];

                    // 7. Layout tabel
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

                    // 8. Tambah Total Pendapatan di bawah tabel
                    doc.content.splice(tableIndex + 1, 0, {
                        margin: [0, 20, 0, 0],
                        table: {
                            widths: ['*', '*'],
                            body: [
                                [
                                    { text: 'Total Pendapatan:', alignment: 'right', bold: true },
                                    { text: 'Rp ' + totalPendapatan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'), alignment: 'left', bold: true }
                                ]
                            ]
                        },
                        layout: 'noBorders'
                    });
                }

                // 9. Tambahkan tanda tangal
                // Tanggal otomatis
                const now = new Date();
                const formattedDate = now.toLocaleDateString('id-ID', {
                    day: '2-digit', month: 'long', year: 'numeric'
                });

                doc.content.push({
                    margin: [0, 50, 0, 0],
                    columns: [
                        {
                            width: '*',
                            alignment: 'left',
                            margin: [30, 0, 0, 0], // geser sedikit ke tengah
                            stack: [
                                { text: 'Mengetahui,', fontSize: 11 },
                                { text: 'Plt. Kepala Dinas Koperasi, UKM, Perdagangan', fontSize: 11 },
                                { text: 'dan Perindustrian Kabupaten Indramayu,', fontSize: 11, margin: [0, 0, 0, 60] },
                                { text: 'ESMEGA, ST., MT', fontSize: 11, bold: true }
                            ]
                        },
                        {
                            width: '*',
                            alignment: 'left',
                            margin: [90, 0, 0, 0], // geser ke kiri agar agak ke tengah
                            stack: [
                                { text: `Indramayu, ${formattedDate}`, fontSize: 11 },
                                { text: 'Admin Lokalista,', fontSize: 11, margin: [0, 0, 0, 70] },
                                { text: '(............................)', fontSize: 11, bold: true }
                            ]
                        }
                    ]
                });
                }
                },
                'print'
            ]
        });
    });
</script>
@endsection
