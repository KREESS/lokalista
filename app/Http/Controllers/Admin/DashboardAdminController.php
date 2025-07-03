<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardAdminController extends Controller
{
    public function index()
    {
        $total_customer = DB::table('users')
            ->where('id', '!=', Auth::id())
            ->count();

        $total_penjualan = DB::table('pesanan')
            ->where('status', 'lunas')
            ->count();

        $total_pendapatan = DB::table('pesanan')
            ->where('status', 'lunas')
            ->sum('harga_total_bayar');

        $total_produk = DB::table('pesanan')
            ->where('status', 'lunas')
            ->sum('quantity');

        $data_produk = DB::table('pesanan')
            ->join('produk', 'produk.id_produk', '=', 'pesanan.id_produk')
            ->where('pesanan.status', 'lunas')
            ->select('produk.nama_produk', DB::raw('SUM(pesanan.quantity) as total_quantity'))
            ->groupBy('produk.nama_produk')
            ->get();

        return view('admin.dashboard.dashboard', compact(
            'total_customer',
            'total_penjualan',
            'total_pendapatan',
            'total_produk',
            'data_produk'
        ));
    }
}
