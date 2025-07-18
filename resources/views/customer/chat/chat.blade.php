@extends('customer.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col align-self-center">
                            <h4 class="page-title pb-md-0">Chat</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Chat</li>
                            </ol>
                        </div>
                        <!--end col-->
                        <div class="col-auto align-self-center">
                            <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                                <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                                <span class="" id="Select_date">
                                    @php
                                        echo date('d M');
                                    @endphp
                                </span>
                                <i data-feather="calendar" class="align-self-center icon-xs ms-1"></i>
                            </a>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end page-title-box-->
            </div>
            <!--end col-->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="chat-box-left">
                    <ul class="nav nav-tabs mb-3 nav-justified" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active"id="general_chat_tab" data-bs-toggle="tab" href="#general_chat"
                                role="tab">General</a>
                        </li>
                    </ul>
                    <!--end chat-search-->

                    <div class="chat-body-left" data-simplebar>
                        <div class="tab-content chat-list" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="general_chat">
                                <a href="" class="media new-message">
                                    <div class="media-left">
                                        <img src="/dapuranita/admin.jpg" alt="user" class="rounded-circle thumb-md">
                                        <span class="round-10 bg-success"></span>
                                    </div><!-- media-left -->
                                    <div class="media-body">
                                        <div class="d-inline-block">
                                            <h6>Layanan Chat Admin</h6>
                                            <p>Jam Kerja 08.00 - 16.00 WIB</p>
                                        </div>
                                    </div><!-- end media-body -->
                                </a>
                                <!--end media-->
                            </div>
                        </div>
                        <!--end tab-content-->
                    </div>
                </div>
                <!--end chat-box-left -->

                <div class="chat-box-right">
                    <div class="chat-header">
                        <a href="" class="media">
                            <div class="media-left">
                                <img src="/dapuranita/admin.jpg" alt="user" class="rounded-circle thumb-sm">
                            </div><!-- media-left -->
                            <div class="media-body">
                                <div>
                                    <h6 class="m-0">Admin Dapur Anita</h6>
                                </div>
                            </div><!-- end media-body -->
                        </a>
                        <!--end media-->
                        <!-- end chat-features -->
                    </div><!-- end chat-header -->
                    <div class="chat-body" data-simplebar>
                        <div class="chat-detail">
                            @foreach ($chat as $chat)
                                <div class="media">
                                    @if ($chat->from_id == Auth::user()->id)

                                    @else
                                        <div class="media-img">
                                            <img src="/dapuranita/admin.jpg" alt="user" class="rounded-circle thumb-sm">
                                        </div>
                                    @endif
                                    <div class="media-body {{ $chat->from_id == Auth::user()->id ? 'reverse' : '' }}">
                                        <div class="chat-msg">
                                            <p>{{ $chat->pesan }}</p>
                                        </div>
                                        @if ($chat->from_id == Auth::user()->id)
                                            <div class=""></div>
                                        @else
                                            <div class="chat-time">{{ $chat->created_at }}</div>
                                        @endif
                                    </div>
                                    <!--end media-body-->
                                </div>
                            @endforeach
                            <!--end media-->

                        </div> <!-- end chat-detail -->
                    </div><!-- end chat-body -->
                    <div class="chat-footer">
                        <form action="{{ route('customer.post_chat') }}" method="post">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-12 col-md-9">
                                    <span class="chat-admin">
                                        @if (!empty(Auth::user()->foto_profile))
                                            <img src="/foto_profile/{{ Auth::user()->foto_profile }}" alt="profile-user"
                                                class="rounded-circle thumb-sm" />
                                        @else
                                            <img src="/dapuranita/default.jpg" alt="profile-user"
                                                class="rounded-circle thumb-sm" />
                                        @endif
                                    </span>
                                    <input type="text" name="pesan" class="form-control" placeholder="Type something here..." required>
                                </div><!-- col-8 -->
                                <div class="col-3 text-end">
                                    <div class="d-none d-sm-inline-block chat-features">
                                        <button type="submit" class="btn btn-outline-primary"><i class="ti ti-send"></i>
                                            Kirim Pesan</button>
                                    </div>
                                </div><!-- end col -->
                            </div>
                        </form><!-- end row -->
                    </div><!-- end chat-footer -->
                </div>
                <!--end chat-box-right -->
            </div> <!-- end col -->
        </div>
    </div>
@endsection
