<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardCustomerController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        $produk = Produk::join('kategori','kategori.id_kategori','=','produk.id_kategori')
            ->select('produk.*','kategori.nama_kategori')
            ->orderBy('produk.created_at', 'desc')
            ->get();

        // Produk terlaris
        $produk_terlaris = DB::table('pesanan')
        ->join('produk', 'produk.id_produk', '=', 'pesanan.id_produk')
        ->select('produk.id_produk', 'produk.nama_produk', 'produk.foto_produk', DB::raw('SUM(pesanan.quantity) as jumlah_terjual'))
        ->where('pesanan.status', 4)
        ->groupBy('produk.id_produk', 'produk.nama_produk', 'produk.foto_produk')
        ->orderByDesc('jumlah_terjual')
        ->limit(10)
        ->get();

        return view('customer.dashboard.dashboard', compact('produk','kategori','produk_terlaris'));
    }
    public function search_kategori($id)
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
    
        $produk = Produk::join('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->select('produk.*', 'kategori.nama_kategori')
            ->where('produk.id_kategori', $id)
            ->orderBy('produk.created_at', 'desc')
            ->get();
    
        $produk_terlaris = DB::table('pesanan')
            ->join('produk', 'produk.id_produk', '=', 'pesanan.id_produk')
            ->select('produk.id_produk', 'produk.nama_produk', 'produk.foto_produk', DB::raw('SUM(pesanan.quantity) as jumlah_terjual'))
            ->where('pesanan.status', 4)
            ->groupBy('produk.id_produk', 'produk.nama_produk', 'produk.foto_produk')
            ->orderByDesc('jumlah_terjual')
            ->limit(10)
            ->get();
    
        return view('customer.dashboard.dashboard', compact('produk', 'kategori', 'produk_terlaris'));
    }

    public function detail_produk($id)
    {
        $produk = Produk::join('kategori','kategori.id_kategori','=','produk.id_kategori')
        ->select('produk.*','kategori.nama_kategori')
        ->find($id);

        $komentar = Komentar::join('produk','produk.id_produk','=','komentar.id_produk')
        ->join('users','users.id','=','komentar.id_user')
        ->select('komentar.*','users.name','users.foto_profile')
        ->limit(3)
        ->get();

        return view('customer.dashboard.dashboard', compact(['produk','komentar']));
    }
    
}

