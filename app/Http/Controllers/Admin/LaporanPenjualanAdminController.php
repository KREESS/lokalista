<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class LaporanPenjualanAdminController extends Controller
{
    public function index()
{
    $pesanan = Pesanan::join('produk','produk.id_produk','=','pesanan.id_produk')
        ->join('alamat_user','alamat_user.id_user','=','pesanan.id_user')
        ->select('pesanan.*','alamat_user.alamat_lengkap','alamat_user.nama_penerima','alamat_user.no_telp','alamat_user.nama_prov','alamat_user.nama_kota','alamat_user.no_telp','produk.nama_produk','produk.harga_produk','produk.foto_produk','produk.berat')
        ->where('pesanan.status', 3)
        ->orWhere('pesanan.status', 4)
        ->get();

    $nama_laporan = "Lokalista All Reports";

    return view('admin.laporan.laporan', compact(['pesanan', 'nama_laporan']));
}

public function laporan_cari(Request $request)
{
    $pesanan = Pesanan::join('produk','produk.id_produk','=','pesanan.id_produk')
        ->join('alamat_user','alamat_user.id_user','=','pesanan.id_user')
        ->select('pesanan.*','alamat_user.alamat_lengkap','alamat_user.nama_penerima','alamat_user.no_telp','alamat_user.nama_prov','alamat_user.nama_kota','alamat_user.no_telp','produk.nama_produk','produk.harga_produk','produk.foto_produk','produk.berat')
        ->whereBetween('pesanan.updated_at', [$request->date_start, $request->date_end])
        ->Where(function($query) {
            $query->where('pesanan.status', 3)
                  ->orWhere('pesanan.status', 4);
        })
        ->get();

    $tanggal_awal = date('d M Y', strtotime($request->date_start));
    $tanggal_akhir = date('d M Y', strtotime($request->date_end));
    $nama_laporan = "Lokalista {$tanggal_awal} - {$tanggal_akhir}";

    return view('admin.laporan.cari_laporan', compact(['pesanan', 'nama_laporan']));
}

}
