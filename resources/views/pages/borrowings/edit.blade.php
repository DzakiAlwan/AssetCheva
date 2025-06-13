@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Peminjaman Barang</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/borrowings">Peminjaman Barang</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <form action="/borrowings/{{ $borrowing->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="borrower_name" class="form-label">Nama Peminjam</label>
                    <input type="text" name="borrower_name" id="borrower_name"
                        class="form-control @error('borrower_name') is-invalid @enderror" value="{{ old('borrower_name', $borrowing->borrower_name) }}">
                    @error('borrower_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="product_id" class="form-label">Barang yang Dipinjam</label>
                    <select name="product_id" id="product_id"
                        class="form-control @error('product_id') is-invalid @enderror">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id', $borrowing->product_id) == $product->id)>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity" class="form-label">Jumlah Barang yang Dipinjam</label>
                    <input type="number" name="quantity" id="quantity"
                        class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $borrowing->quantity) }}">
                    @error('quantity')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="borrow_date" class="form-label">Tanggal Meminjam</label>
                    <input type="date" name="borrow_date" id="borrow_date"
                        class="form-control @error('borrow_date') is-invalid @enderror" value="{{ old('borrow_date', $borrowing->borrow_date) }}">
                    @error('borrow_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                    <input type="date" name="return_date" id="return_date"
                        class="form-control @error('return_date') is-invalid @enderror" value="{{ old('return_date', $borrowing->return_date) }}">
                    @error('return_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <a href="/borrowings" class="btn btn-sm btn-outline-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
@endsection
