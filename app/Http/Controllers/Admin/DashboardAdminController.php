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
        // Total customer (selain admin yang login)
        $total_customer = DB::table('users')
            ->where('id', '!=', Auth::id())
            ->count();
    
            $whereStatus = ['3', '4', 'lunas'];

            $total_penjualan = DB::table('pesanan')
                ->whereIn('status', $whereStatus)
                ->count();
            
            $total_pendapatan = DB::table('pesanan')
                ->whereIn('status', $whereStatus)
                ->sum('harga_total_bayar');
            
            $total_produk = DB::table('pesanan')
                ->whereIn('status', $whereStatus)
                ->sum('quantity');
            
            $data_produk = DB::table('pesanan')
                ->join('produk', 'produk.id_produk', '=', 'pesanan.id_produk')
                ->whereIn('pesanan.status', $whereStatus)
                ->select('produk.nama_produk', DB::raw('SUM(pesanan.quantity) as total_quantity'))
                ->groupBy('produk.nama_produk')
                ->orderByDesc('total_quantity')
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