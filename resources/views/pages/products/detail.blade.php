@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Produk</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                <li class="breadcrumb-item active">Produk</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label class="form-label"><strong>Nama Produk:</strong></label>
                <p>{{ $product->name }}</p>
            </div>

            <div class="form-group">
                <label class="form-label"><strong>Deskripsi:</strong></label>
                <p>{{ $product->description }}</p>
            </div>

            <div class="form-group">
                <label class="form-label"><strong>Kode Produk:</strong></label>
                <p>{{ $product->sku }}</p>
            </div>

            <div class="form-group">
                <label class="form-label"><strong>Stock:</strong></label>
                <p>{{ $product->stock }}</p>
            </div>

            <div class="form-group">
                <label class="form-label"><strong>Kategori:</strong></label>
                <p>{{ $product->category->name }}</p>
            </div>

            <div class="form-group">
                <label class="form-label"><strong>Gambar Produk:</strong></label><br>
                @if ($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" width="200">
                @else
                    <p>Tidak ada gambar tersedia</p>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label"><strong>Tanggal:</strong></label>
                <p>{{ \Carbon\Carbon::parse($product->tanggal)->format('d/m/Y') }}</p>
            </div>

            <div class="form-group">
                <label class="form-label"><strong>Sumber Perolehan:</strong></label>
                <p>{{ $product->source }}</p>
            </div>

            <div class="form-group">
                <label class="form-label"><strong>Status:</strong></label>
                <p>{{ ucfirst($product->status) }}</p>
            </div>
        </div>

        <div class="card-footer">
            <div class="flex">
                <div class="d-flex justify-content-end">
            <a href="/products" class="btn btn-sm btn-outline-secondary mr-2">Kembali</a>
            </div>
        </div>
    </div>
@endsection
