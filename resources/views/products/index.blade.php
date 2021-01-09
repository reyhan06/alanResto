@extends('layouts.app')

@section('head')
<title>Produk - {{ config('app.name') }}</title>
@endsection

@section('content')
<div class="pt-3">
    <p class="text-secondary">Tambahkan menu makanan yang ada di resto</p>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <a href="{{ route('products.create') }}" class="btn btn-info text-white shadow-sm mb-3">+ Tambah Menu</a>

                <table class="table table-responsive-xl table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row" style="vertical-align: middle;">{{ $product->id }}</th>
                                <td style="vertical-align: middle;">{{ $product->name }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$product->img) }}" alt="{{ $product->name }}" width="60px" height="60px" class="img-responsive" style="object-fit: cover;">
                                </td>
                                <td style="vertical-align: middle;">{{ $product->rupiah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
