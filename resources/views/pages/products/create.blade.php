@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Produk</h1>
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
    <form action="/products/store" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="card">
            {{-- @if ($errors->any()) --}}
            {{-- @dd($errors->all()) --}}
            {{-- @endif --}}
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea type="text" name="description" id="description" cols="30" rows="10"
                        class="form-control @error('description') is-invalid @enderror">
            {{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sku" class="form-label">Kode Produk</label>
                    <input type="text" name="sku" id="sku"
                        class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                    @error('sku')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock"
                        class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}">
                    @error('stock')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="form-control @error('category_id') is-invalid @enderror">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Field Tambahan -->
                <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="source" class="form-label">Sumber Perolehan Barang</label>
                    <input type="text" name="source" id="source" class="form-control @error('source') is-invalid @enderror" value="{{ old('source') }}">
                    @error('source')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status Barang</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="baru" @selected(old('status') == 'baru')>Baru</option>
                        <option value="second" @selected(old('status') == 'second')>Second</option>
                        <option value="rusak" @selected(old('status') == 'rusak')>Rusak</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                <div class="flex">
                    <div class="d-flex justify-content-end">
                        <a href="/products" class="btn btn-sm btn-outline-secondary mr-2"> Batal</a>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
