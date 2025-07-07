@extends('admin.layout.master')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col align-self-center">
                        <h4 class="page-title">Live Chat</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chat</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <span class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-calendar2-week me-1"></i>{{ date('d M') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chat box --}}
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white d-flex align-items-center">
                    <img src="{{ $nama_user->foto_profile ? '/foto_profile/' . $nama_user->foto_profile : '/lokalista/default.jpg' }}"
                        alt="User" class="rounded-circle me-3" width="40" height="40">
                    <h6 class="mb-0">{{ Str::title($nama_user->name) }}</h6>
                </div>

                <div class="card-body p-3" style="height: 500px; overflow-y: auto;" data-simplebar>
                    <div class="chat-detail">
                        @foreach ($pesan as $p)
                            @php
                                $isAdmin = $p->is_from_admin;
                                $foto = $isAdmin
                                    ? (Auth::user()->foto_profile ? '/foto_profile/' . Auth::user()->foto_profile : '/lokalista/default.jpg')
                                    : ($nama_user->foto_profile ? '/foto_profile/' . $nama_user->foto_profile : '/lokalista/default.jpg');
                            @endphp

                            <div class="d-flex mb-3 {{ $isAdmin ? 'justify-content-end text-end' : '' }}">
                                @if (!$isAdmin)
                                    <img src="{{ $foto }}" class="rounded-circle me-2" width="32" height="32">
                                @endif

                                <div>
                                    <div class="px-3 py-2 rounded-3 shadow-sm 
                                        {{ $isAdmin ? 'bg-warning text-white' : 'bg-light border' }}" 
                                        style="max-width: 400px;">
                                        {{ $p->message }}
                                    </div>
                                    <small class="text-muted d-block mt-1">{{ $p->created_at->format('H:i - d M Y') }}</small>
                                </div>

                                @if ($isAdmin)
                                    <img src="{{ $foto }}" class="rounded-circle ms-2" width="32" height="32">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <form action="{{ route('admin.livechat.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $id }}">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Ketik pesan..." required>
                            <button type="submit" class="btn btn-warning d-flex align-items-center justify-content-center px-3">
                                <i class="bi bi-send-fill fs-5"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatBody = document.querySelector('.chat-body');
        chatBody.scrollTop = chatBody.scrollHeight;
    });
</script>

@endsection
