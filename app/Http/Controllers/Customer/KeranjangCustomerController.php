<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangCustomerController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::join('produk', 'produk.id_produk', '=', 'keranjang.id_produk')
            ->join('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->select('keranjang.*', 'produk.nama_produk', 'produk.harga_produk', 'produk.foto_produk', 'kategori.nama_kategori')
            ->where('keranjang.id_user', Auth::user()->id)
            ->where('keranjang.status', 'belum')
            ->get();
    
        return view('customer.keranjang.keranjang', compact('keranjang'));
    }
    

    public function store(Request $request)
    {
        $id = $request->id_produk;
        $produk = Produk::find($id);
    
        if ($request->quantity > $produk->stok) {
            return back()->with('gagal', 'Maaf Jumlah Pembelian Anda Melebihi Stok yang tersedia');
        }
    
        Keranjang::create([
            'id_user'   => Auth::user()->id,
            'id_produk' => $request->id_produk,
            'quantity'  => $request->quantity,
            'status'    => 'belum' // default: belum dibayar
        ]);
    
        return to_route('customer.keranjang');
    }

    public function checkout($id_keranjang)
{
    $keranjang = Keranjang::find($id_keranjang);

    // Logika simpan ke pesanan, kurangi stok, dll...

    // Update status jadi 'dibayar'
    $keranjang->update([
        'status' => 'dibayar'
    ]);

    return redirect()->route('customer.keranjang')->with('success', 'Berhasil checkout!');
}

    

    public function update(Request $request, $id)
    {
        $id_produk = $request->id_produk;
        $produk = Produk::find($id_produk);
    
        if ($request->quantity > $produk->stok) {
            return back()->with('gagal', 'Maaf Jumlah Pembelian Anda Melebihi Stok yang tersedia');
        }
    
        Keranjang::find($id)->update([
            'quantity' => $request->quantity
        ]);
    
        return redirect()->route('customer.keranjang')->with('success', 'Jumlah barang berhasil diperbarui!');
    }    

    public function delete($id)
    {
        Keranjang::find($id)->delete();
    return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
}

}
