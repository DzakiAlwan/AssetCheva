@extends('layouts.main ')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Produk</h1>
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
    <form action="/peminjam/{{ $peminjam->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label">Nama Peminjam</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $peminjam->name) }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="product_id" class="form-label">Nama Barang</label>
                    <select name="product_id" id="product_id"
                        class="form-control @error('product_id') is-invalid @enderror">
                        <option value="" disabled>Pilih Barang</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ $peminjam->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah"
                        class="form-control @error('jumlah') is-invalid @enderror"
                        value="{{ old('jumlah', $peminjam->jumlah) }}">
                    @error('jumlah')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="created_at" class="form-label">Tanggal Peminjaman</label>
                    <input type="date" name="created_at" id="created_at"
                        class="form-control @error('created_at') is-invalid @enderror"
                        value="{{ old('created_at', $peminjam->created_at->format('Y-m-d')) }}">
                    @error('created_at')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pengembalian" class="form-label">Tanggal Pengembalian</label>
                    <input type="date" name="pengembalian" id="pengembalian"
                        class="form-control @error('pengembalian') is-invalid @enderror"
                        value="{{ old('pengembalian', $peminjam->pengembalian) }}">
                    @error('pengembalian')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <a href="/peminjam" class="btn btn-sm btn-outline-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
@endsection
