@extends('layouts.app')

@section('head')
<title>Tambah Produk - {{ config('app.name') }}</title>
@endsection

@section('content')
<div class="row pt-5">
    <div class="col-xl-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary pb-4">Tambahkan Menu</h5>

                <form  id="productForm" class="form" action="{{ route('products.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group pb-4">
                        <label for="inputName">Nama Menu</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputName" required>
                        @error('name')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group pb-4">
                        <label for="inputImg">Gambar</label>
                        <input type="file" name="img" class="form-control @error('img') is-invalid @enderror" id="inputImg" required>
                        @error('img')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group pb-4">
                        <label for="inputPrice">Harga</label>
                        <input type="text" name="price" class="form-control input-rupiah @error('price') is-invalid @enderror" id="inputPrice" required>
                        @error('price')
                        <span class="text-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success float-right">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/rupiah.js') }}"></script>
@endsection
