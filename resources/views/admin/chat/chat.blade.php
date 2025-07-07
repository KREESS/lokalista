@extends('admin.layout.master')

@section('content')
    <h4 class="mb-3">Live Chat dari Pengunjung</h4>
    <div class="row">
        @foreach ($users as $chat)
            <div class="col-md-4">
                <a href="{{ route('admin.livechat.detail', $chat->user_id) }}">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <img src="{{ $chat->user->foto_profile ? '/foto_profile/' . $chat->user->foto_profile : '/lokalista/default.jpg' }}"
                                 class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">{{ $chat->user->name }}</h6>
                                <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse($chat->last_message_time)->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
