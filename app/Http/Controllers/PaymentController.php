<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\CoreApi;
use App\Models\Alamat;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Jika pakai Http client Laravel
use Illuminate\Support\Facades\DB;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function proses(Request $request)
    {
        $idUser = Auth::id();
        $produkIds = $request->id_produk;
        $quantities = $request->quantity;
        $pesananBaru = [];

        foreach ($produkIds as $i => $idProduk) {
            $pesananBaru[] = [
                'id_produk' => $idProduk,
                'id_user' => $idUser,
                'quantity' => $quantities[$i],
                'harga_total_bayar' => $request->total_bayar,
                'ongkir' => $request->ongkir ?? 0, // <= solusi aman
                'total_ongkir' => $request->ongkir,
                'bukti_bayar' => null,
                'total_dp' => null,
                'bukti_bayar_dp' => null,
                'bukti_bayar_dp_lunas' => null,
                'dp_status' => null,
                'status' => 'pending',
                'tipe_pembayaran' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }        

        // Simpan ke database
        DB::table('pesanan')->insert($pesananBaru);

        // Ambil ID pesanan yang baru saja dibuat
        $pesananIds = DB::table('pesanan')
            ->where('id_user', $idUser)
            ->latest()
            ->take(count($produkIds))
            ->pluck('id_pesanan');

        $id_pesanan = $pesananIds->first(); // ambil ID pesanan pertama sebagai contoh

        // Ambil data keranjang dan pesanan terakhir
        $keranjang = DB::table('keranjang')->where('id_user', $idUser)->get();
        $ongkir = $request->ongkir;
        $berat_total = $keranjang->sum('berat');
        $pengiriman = $request->pengiriman ?? 'Belum dipilih';

        $pesanan = DB::table('pesanan')
            ->where('id_user', $idUser)
            ->latest()
            ->take(count($produkIds))
            ->get();

        // MIDTRANS CONFIG
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat transaksi Midtrans (ambil salah satu pesanan sebagai acuan)
        $firstPesanan = $pesanan->first();
        $orderId = 'ORDER-' . time();
        $grossAmount = $firstPesanan->harga_total_bayar;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'credit_card',
                'bca_va',
                'bni_va',
                'bri_va',
                'qris',
                'gopay',
                'shopeepay',
                'permata_va',
                'echannel',
                'indomaret',
                'alfamart',
            ],
        ];

        $response = Snap::createTransaction($params);
        $snapToken = $response->token;

        // Kirim data ke view, termasuk id_pesanan
        return view('customer.checkout.checkout_ulang', compact(
            'keranjang',
            'ongkir',
            'berat_total',
            'pengiriman',
            'pesanan',
            'snapToken',
            'id_pesanan'
        ));
    }

    public function updateStatusPembayaran(Request $request)
    {
        $idPesanan = $request->id_pesanan;
        $statusPembayaran = $request->status_pembayaran;
        $tipePembayaran = $request->tipe_pembayaran; // ditangkap dari query param

        if (!$idPesanan) {
            return redirect()->route('checkout.failed')->with('error', 'ID Pesanan tidak ditemukan');
        }

        // Update status dan tipe pembayaran jika sukses
        if ($statusPembayaran === 'success') {
            DB::table('pesanan')
                ->where('id_pesanan', $idPesanan)
                ->update([
                    'status' => 'lunas',
                    'tipe_pembayaran' => $tipePembayaran,
                    'updated_at' => now(),
                ]);
        }

        return view('customer.checkout.after_checkout');
    }
}
