<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $produk = Produk::join('kategori','kategori.id_kategori','=','produk.id_kategori')
            ->select('produk.*','kategori.nama_kategori')
            ->orderBy('produk.created_at', 'desc')
            ->limit(4)
            ->get();
    
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
    
        return view('home', compact('produk', 'kategori'));
    }
    

    public function produk()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
    
        $produk = Produk::join('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->select('produk.*', 'kategori.nama_kategori')
            ->orderBy('produk.created_at', 'desc')
            ->get();
    
        return view('produk', compact('produk', 'kategori')); // ⬅️ arahkan ke produk.blade.php
    }
    

    public function detail_produk($id)
    {
        $produk = Produk::join('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->select('produk.*', 'kategori.nama_kategori')
            ->find($id);

        $komentar = Komentar::join('produk', 'produk.id_produk', '=', 'komentar.id_produk')
            ->join('users', 'users.id', '=', 'komentar.id_user')
            ->select('komentar.*', 'users.name', 'users.foto_profile')
            ->where('komentar.id_produk', $id)
            ->limit(3)
            ->get();

        return view('produk_detail', compact('produk', 'komentar'));
    }

    public function search_kategori($id)
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
    
        $produk = Produk::join('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->select('produk.*', 'kategori.nama_kategori')
            ->where('produk.id_kategori', $id)
            ->orderBy('produk.created_at', 'desc')
            ->get();
    
        return view('produk', compact('produk', 'kategori')); // ✅ kembalikan ke produk.blade.php
    }    
}
