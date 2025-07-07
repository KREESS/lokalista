<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\LiveChat;


class ChatAdminController extends Controller
{

    public function livechat_index()
    {
        // Ambil semua user yang pernah kirim pesan ke admin (tanpa is_from_admin)
        $users = LiveChat::where('is_from_admin', false)
            ->with('user')
            ->select('user_id', DB::raw('MAX(created_at) as last_message_time'))
            ->groupBy('user_id')
            ->orderByDesc('last_message_time')
            ->get();

        return view('admin.chat.chat', compact('users'));
    }

    public function livechatDetail($id)
    {
        $nama_user = User::findOrFail($id);

        $pesan = LiveChat::where('user_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.chat.chat_detail', compact('pesan', 'nama_user', 'id'));
    }



    public function livechat_send(Request $request)
    {
        LiveChat::create([
            'user_id' => $request->user_id,
            'message' => $request->message,
            'is_from_admin' => true,
        ]);

        return back();
    }
}
