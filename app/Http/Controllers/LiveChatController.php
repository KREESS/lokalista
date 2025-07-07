<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveChat;
use Illuminate\Support\Facades\Auth;

class LiveChatController extends Controller
{
    // Untuk ambil semua chat milik user login (AJAX)
    public function fetch()
    {
        $userId = Auth::id();

        // Cek apakah user sudah punya chat sebelumnya
        $hasChat = LiveChat::where('user_id', $userId)->exists();

        // Jika belum ada, tambahkan pesan welcome
        if (!$hasChat) {
            LiveChat::create([
                'user_id' => $userId,
                'message' => 'Halo 👋 Selamat datang di layanan live chat kami. Ada yang bisa kami bantu?',
                'is_from_admin' => true,
            ]);
        }

        // Ambil semua chat terbaru
        $chats = LiveChat::where('user_id', $userId)->get();

        return response()->json($chats);
    }

    // Untuk kirim pesan user (AJAX)
    public function send(Request $request)
    {
        LiveChat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_from_admin' => false
        ]);

        return response()->json(['status' => 'success']);
    }

    // Jika kamu masih ingin simpan tampilan index chat (opsional)
    public function index()
    {
        $chats = LiveChat::where('user_id', Auth::id())->get();
        return view('chat.index', compact('chats'));
    }

    // Admin membalas chat (opsional)
    public function adminReply(Request $request, $userId)
    {
        LiveChat::create([
            'user_id' => $userId,
            'message' => $request->message,
            'is_from_admin' => true
        ]);

        return back();
    }
}
