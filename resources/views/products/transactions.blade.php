@extends('layouts.app')

@section('head')
<title>Transaksi - {{ config('app.name') }}</title>
@endsection

@section('content')
<div class="row pt-5">
    <div class="col-xl-7">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-md-4 pb-3 pt-3">
                <a href="#add-product" class="card product btn-light" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-img="{{ asset('storage/'.$product->img) }}" data-price="{{ $product->price }}">
                    <img class="card-img-top" src="{{ asset('storage/'.$product->img) }}" alt="{{ $product->name }}">
                    <div class="card-body text-center">
                        <p class="card-text mb-2">{{ $product->name }}</p>
                        <p data-price="{{ $product->price }}" class="card-text text-primary">{{ $product->rupiah }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-xl-5 pb-3 pt-3">
        <div class="card">
            <div class="card-header text-center pt-3">
                <img class="mx-auto" src="{{ asset('img/user/man.png') }}" alt="Pesanan" width="30px" height="30px">
                <span style="font-size:25px; vertical-align: middle;">Pesanan</span>
            </div>
            <div class="card-body">
                <table id="cart" class="table table-borderless table-responsive-lg">
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button id="reset" type="button" class="btn btn-outline-danger btn-lg btn-block mb-1">Clear Cart</button>
                <div class="row pt-2 pb-2">
                    <div class="col-6 pr-2">
                        <button id="save" data-link="{{ route('transactions.save') }}" type="button" class="btn btn-success btn-lg btn-block">Save Bill</button>
                    </div>
                    <div class="col-6 pl-2">
                        <button id="print" data-link="{{ route('savePrint') }}" type="button" class="btn btn-success btn-lg btn-block">Print Bill</button>
                    </div>
                </div>
                <button id="charge" type="button" class="btn btn-primary btn-lg btn-block mt-1">Charge <span id="total">Rp. 0</span></button>
            </div>
        </div>
    </div>
</div>

<form id="saveForm" action="" method="post" style="display:none;">
    @csrf
    <input id="saveCart" type="hidden" name="cart" value="" required>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-8">
                <table id="chargeTable" class="table table-responsive-lg table-striped">
                    <thead class="thead-light">
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4 ">
                <div class="text-center">
                    <span style="font-size:120%;">Uang Pembeli (Rp)</span>
                    <form method="post">
                        <div class="form-group">
                            <input id="pay" type="text" class="input-rupiah" name="pay">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-white btn-block" data-dismiss="modal">Tutup</button>
                                </div>
                                <div class="col-md-6">
                                    <button id="submit" type="button" class="btn btn-primary btn-block">Pay!</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="text-danger">
                    Kembalian: <span class="text-danger" id="rest">0</span>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/rupiah.js') }}"></script>
<script type="text/javascript">
    function convertRupiah(angka) {
      var number_string = angka.toString(),
        split  = number_string.split(","),
        sisa   = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return "Rp. " + rupiah;
    }

    $(document).ready(function() {
        @if (empty($cart))
        var cart = [];
        @else
        var cart = {!! $cart !!};
        @endif
        var total = $('#total');

        if (cart.length != 0) {

            for (var i = 0; i < cart.length; i++) {
                $('#cart tbody').append("<tr><th scope='row'><img src=" + cart[i][2] + " width='80px' height='80px' style='object-fit: cover;'></th><td style='vertical-align: middle;'>" + cart[i][3] + "</td><td id='p" + cart[i][0] + "q' style='vertical-align: middle;'>x1</td><td id='p" + cart[i][0] + "p' class='text-primary' style='vertical-align: middle;'>" + convertRupiah(cart[i][4]) + "</td></tr>");
            }

            total.text(convertRupiah({!! $total !!}));
        }

        $('.product').click(function(event) {
            var id = $(this).attr('data-id');
            var img = $(this).attr('data-img');
            var name = $(this).attr('data-name');
            var price = $(this).attr('data-price');

            if (cart.length == 0) {
                cart.push([id, 1, img, name, price]);
                $('#cart tbody').append("<tr><th scope='row'><img src=" + img + " width='80px' height='80px' style='object-fit: cover;'></th><td style='vertical-align: middle;'>" + name + "</td><td id='p" + id + "q' style='vertical-align: middle;'>x1</td><td id='p" + id + "p' class='text-primary' style='vertical-align: middle;'>" + convertRupiah(price) + "</td></tr>");
            } else {
                if ((n = $.inArray(id, $.map(cart, function(v) { return v[0]; }))) > -1) {
                    cart[n][4] = price * ++cart[n][1];
                    $('#p' + id + 'q').text('x' + cart[n][1]);
                    $('#p' + id + 'p').text(convertRupiah(cart[n][4]));
                }
                else {
                    cart.push([id, 1, img, name, price]);
                    $('#cart tbody').append("<tr><th scope='row'><img src=" + img + " width='80px' height='80px' style='object-fit: cover;'></th><td style='vertical-align: middle;'>" + name + "</td><td id='p" + id + "q' style='vertical-align: middle;'>x1</td><td id='p" + id + "p' class='text-primary' style='vertical-align: middle;'>" + convertRupiah(price) + "</td></tr>");
                }
            }

            var getTotal = total.text().replace(/\D/g, '');
            getTotal = parseInt(getTotal) + parseInt(price);
            total.text(convertRupiah(getTotal));
        });

        $('#reset').click(function(event) {
            cart = [];
            total.text(convertRupiah(0));
            $("#cart tr").remove();
        });

        $('#save').click(function(event) {
            $('#saveCart').val(JSON.stringify(cart));
            $('#saveForm').attr('action', $(this).attr('data-link'));
            $('#saveForm').submit();
        });

        $('#print').on('click',function(){
            $('#saveCart').val(JSON.stringify(cart));
            $('#saveForm').attr('action', $(this).attr('data-link'));
            $('#saveForm').submit();
        });

        $('#charge').click(function(event) {
            $("#chargeTable tr").remove();
            $('#chargeTable thead').append("<tr><th scope='col'>#</th><th scope='col'>Nama</th><th scope='col'>Foto</th><th scope='col'>Harga</th></tr>");
            for (var i = 0; i < cart.length; i++) {
                $('#chargeTable tbody').append("<tr><th scope='row' style='vertical-align: middle;'>" + cart[i][0] + "</th><td style='vertical-align: middle;'>" + cart[i][3] + "</td><td><img src=" + cart[i][2] + " width='60px' height='60px' style='object-fit: cover;'></td><td style='vertical-align: middle;'>" + convertRupiah(cart[i][4]) + "</td></tr>");
            };
            $('#exampleModal').modal('show');
        });

        $('#pay').keyup(function(event) {
            $('#rest').text(parseInt(clearRupiah($('#pay').value)) - total);
        });
    });
</script>
@endsection
