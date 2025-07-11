<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\Models\Keranjang;
use App\Models\Rekening;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutCustomerController extends Controller
{
    public function get_ongkir($id_kota, $berat)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=399&destination=" . $id_kota . "&weight=" . $berat . "&courier=jne",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: f201c33f7b1021a48e2a76125bfa5e15"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        \Log::error('cURL Error RajaOngkir: ' . $err);
        return []; // atau null, sesuai kebutuhan
    } else {
        $response = json_decode($response, true);

        if (
            isset($response['rajaongkir']['status']['code']) &&
            $response['rajaongkir']['status']['code'] == 200 &&
            isset($response['rajaongkir']['results'])
        ) {
            return $response['rajaongkir']['results'];
        } else {
            // Log dan debug jika response tidak sesuai harapan
            \Log::error('Unexpected RajaOngkir response', ['response' => $response]);

            // Debug langsung jika sedang tahap pengembangan
            // dd($response); 

            return []; // atau null
        }
    }
}

    // public function get_ongkir($id_kota, $berat)
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => "origin=399&destination=" . $id_kota . "&weight=" . $berat . "&courier=jne",
    //         CURLOPT_HTTPHEADER => array(
    //             "content-type: application/x-www-form-urlencoded",
    //             "key: f201c33f7b1021a48e2a76125bfa5e15"
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         echo "cURL Error #:" . $err;
    //     } else {
    //         $response = json_decode($response, true);
    //         $provinsi = $response['rajaongkir']['results'];
    //         return $provinsi;
    //     }
    // }

    public function index($id_keranjang)
{
    $userId = Auth::id();

    // Cek alamat user
    $pengiriman = Alamat::where('id_user', $userId)->first();
    if (!$pengiriman) {
        return redirect()->route('alamat.create')->with('error', 'Harap lengkapi alamat pengiriman terlebih dahulu.');
    }

    // Ambil hanya keranjang yang sesuai id & user
    $keranjang = Keranjang::join('produk', 'produk.id_produk', '=', 'keranjang.id_produk')
        ->select('keranjang.*', 'produk.nama_produk', 'produk.harga_produk', 'produk.foto_produk', 'produk.berat')
        ->where('keranjang.id_user', $userId)
        ->where('keranjang.id_keranjang', $id_keranjang)
        ->get();

    // Jika tidak ditemukan
    if ($keranjang->isEmpty()) {
        return redirect()->route('customer.keranjang')->with('gagal', 'Produk tidak ditemukan di keranjang Anda.');
    }

    $berat_total = $keranjang->sum(fn($item) => $item->berat * $item->quantity);
    $id_kota = $pengiriman->id_kota;
    $ongkir = $this->get_ongkir($id_kota, $berat_total);

    return view('customer.checkout.checkout', compact('keranjang', 'ongkir', 'berat_total', 'pengiriman'));
}

public function proses(Request $request)
{
    $produk_ids = $request->input('id_produk', []);
    $quantities = $request->input('quantity', []);
    $keranjang_ids = $request->input('id_keranjang', []);

    foreach ($produk_ids as $index => $id_produk) {
        $quantity = $quantities[$index];
        $keranjang_id = $keranjang_ids[$index];

        // Kurangi stok, buat pesanan, dll
        // Kemudian tandai keranjang sebagai "dibayar"
        Keranjang::where('id_keranjang', $keranjang_id)->update(['status' => 'dibayar']);
    }

    return redirect()->route('customer.keranjang')->with('success', 'Checkout berhasil!');
}


    // CONTROLLER AWAL DIBAWAH

    // public function index($id)
    // {
    //     // Cek apakah ada alamat pengguna
    //     $cek_alamat = Alamat::where('id_user', Auth::user()->id)->first();
    //     if ($cek_alamat == NULL) {
    //         return to_route('alamat.create');
    //     }

    //     // Mengambil data keranjang untuk user yang sedang login
    //     $keranjang = Keranjang::join('produk', 'produk.id_produk', '=', 'keranjang.id_produk')
    //         ->select('keranjang.*', 'produk.nama_produk', 'produk.harga_produk', 'produk.foto_produk', 'produk.berat')
    //         ->where('keranjang.id_user', Auth::user()->id)
    //         ->get();  // Menggunakan get() untuk mengambil semua data keranjang

    //     // Mendapatkan data rekening
    //     $rekening = Rekening::orderBy('jenis_rekening', 'asc')->get();

    //     // Menghitung total berat semua produk di keranjang
    //     $berat_total = $keranjang->sum(function ($item) {
    //         return $item->berat * $item->quantity;  // Mengalikan berat dengan jumlah
    //     });

    //     // Mengambil data kota dari alamat pengiriman
    //     $pengiriman = Alamat::where('id_user', Auth::user()->id)->first();
    //     $id_kota = $pengiriman->id_kota;

    //     // Mendapatkan ongkir berdasarkan berat total dan kota
    //     $ongkir = $this->get_ongkir($id_kota, $berat_total);

    //     return view('customer.checkout.checkout', compact('keranjang', 'ongkir', 'berat_total', 'pengiriman', 'rekening'));
    // }
}
