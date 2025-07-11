@extends('customer.layout.master')

@section('content')
    <div class="container">
        <h4 class="mb-4">Hasil Pencarian: <em>{{ $keyword }}</em></h4>

        @if($produk->count() > 0)
            <div class="row">
                @foreach($produk as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="/produk/{{ $item->foto_produk }}" class="card-img-top" alt="{{ $item->nama_produk }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nama_produk }}</h5>
                                <p class="card-text">
                                    {{ Str::limit(strip_tags($item->deskripsi_produk), 80) }}
                                </p>                                
                                <p class="card-text"><strong>Rp{{ number_format($item->harga_produk) }}</strong></p>
                                <a style="background-color: #ff7700; border:none;" href="{{ route('customer.produk.detail', $item->id_produk) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <p>Tidak ada produk yang ditemukan untuk pencarian: <strong>{{ $keyword }}</strong>.</p>
        @endif

    </div> <!-- end container -->

@endsection
