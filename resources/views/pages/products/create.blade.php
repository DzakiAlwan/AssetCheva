@extends('layouts.main ')

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
    <form action="/products/store" method="POST">
        @csrf
        @method('POST')
        <div class="card">
            {{-- @if ($errors->any())
        @dd($errors->all())
    @endif --}}
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
                        class="from-control  @error('category_id') is-invalid @enderror">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <div class="flex">
                    <div class="d-flex justify-content-end">
                        <a href="/products" class="btn btn-sm btn-outline-secondary mr-2"> Batal</a>
                        <button type="sumbit" class="bt btn-sm btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
