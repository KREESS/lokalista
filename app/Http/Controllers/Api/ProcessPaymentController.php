<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;

class ProcessPaymentController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        $amount = (int) $request->amount;

        if ($amount < 1) {
            return response()->json([
                'status' => false,
                'message' => 'Jumlah pembayaran tidak valid',
            ], 400);
        }

        $invoiceNumber = 'INV-' . uniqid();
        $expiryDuration = 300; // 5 menit
        $expiredAt = now()->addSeconds($expiryDuration);

        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'invoice_number' => $invoiceNumber,
            'amount' => $amount,
            'status' => 'CREATED',
        ]);

        // Kirim ke Midtrans (QRIS - Gopay)
        $resp = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withBasicAuth('SB-Mid-server-43UiTe934ne7pVwY728XRSe8', '')
            ->post('https://api.sandbox.midtrans.com/v2/charge', [
                'payment_type' => 'qris',
                'transaction_details' => [
                    'order_id' => $invoiceNumber,
                    'gross_amount' => $amount,
                ],
                'expiry' => [
                    'start_time' => now()->format('Y-m-d H:i:s O'),
                    'unit' => 'second',
                    'duration' => $expiryDuration
                ],
            ]);

        if ($resp->successful()) {
            $actions = $resp->json('actions') ?? [];
            $qrUrl = null;

            foreach ($actions as $action) {
                if ($action['name'] === 'generate-qr-code') {
                    $qrUrl = $action['url'];
                    break;
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Transaksi berhasil dibuat',
                'qr' => $qrUrl,
                'invoice_number' => $invoiceNumber,
                'amount' => $amount,
                'expired_at' => $expiryDuration // atau $expiredAt->toDateTimeString()
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Gagal memproses pembayaran',
            'error' => $resp->json()
        ], 500);
    }
}
