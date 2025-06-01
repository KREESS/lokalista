<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
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

        return view('customer.dashboard.dashboard', compact(['produk','kategori']));
    }

    public function search_kategori($id)
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        $produk = Produk::join('kategori','kategori.id_kategori','=','produk.id_kategori')
        ->select('produk.*','kategori.nama_kategori')
        ->where('produk.id_kategori', $id)
        ->orderBy('produk.created_at', 'desc')
        ->get();

        return view('customer.dashboard.dashboard', compact(['produk','kategori']));
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
