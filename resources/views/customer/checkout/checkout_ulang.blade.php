@extends('customer.layout.master')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Pembayaran Diterima</h3>

    @foreach ($pesanan as $p)
        <div class="card mb-4">
            <div class="card-body">
                <p>Total Bayar: <strong>Rp{{ number_format($p->harga_total_bayar) }}</strong></p>
                <p>Total Ongkir: Rp{{ number_format($p->total_ongkir) }}</p>
                <p>Status: <strong>{{ ucfirst($p->status) }}</strong></p>
            </div>
        </div>
    @endforeach
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script type="text/javascript">
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            // Ambil tipe pembayaran dari result
            let tipePembayaran = result.payment_type;

            // Redirect ke route sukses, bawa id_pesanan & tipe_pembayaran
            window.location.href = "{{ route('checkout.sukses') }}?id_pesanan={{ $id_pesanan }}&status_pembayaran=success&tipe_pembayaran=" + tipePembayaran;
        },
        onPending: function(result){
            alert('Pembayaran menunggu konfirmasi');
        },
        onError: function(result){
            alert('Pembayaran gagal');
        }
    });
</script>



@endsection

@section('js')
<script>
    const imgInp1 = document.getElementById('imgInp1');
    const output1 = document.getElementById('output1');

    if (imgInp1 && output1) {
        imgInp1.onchange = evt => {
            const [file] = imgInp1.files
            if (file) {
                output1.src = URL.createObjectURL(file)
            }
        };
    }
</script>


@endsection
