@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Peminjaman Barang</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Peminjaman Barang</li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <form action="/borrowings/store" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="borrower_name" class="form-label">Nama Peminjam</label>
                    <input type="text" name="borrower_name" id="borrower_name"
                        class="form-control @error('borrower_name') is-invalid @enderror" value="{{ old('borrower_name') }}">
                    @error('borrower_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="product_id" class="form-label">Barang yang Dipinjam</label>
                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">
                                {{ $product->name }} (Stok: {{ $product->stock }})
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
                        class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                    @error('quantity')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="borrow_date" class="form-label">Tanggal Meminjam</label>
                    <input type="date" name="borrow_date" id="borrow_date"
                        class="form-control @error('borrow_date') is-invalid @enderror" value="{{ old('borrow_date') }}">
                    @error('borrow_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                    <input type="date" name="return_date" id="return_date"
                        class="form-control @error('return_date') is-invalid @enderror" value="{{ old('return_date') }}">
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const stockDisplay = document.getElementById('stock_display');

            // Event listener saat produk dipilih
            productSelect.addEventListener('change', function () {
                const selectedProduct = productSelect.selectedOptions[0];
                const availableStock = parseInt(selectedProduct.getAttribute('data-stock'));

                // Tampilkan stok yang tersedia di input
                stockDisplay.textContent = `Stok tersedia: ${availableStock}`;

                // Reset quantity jika melebihi stok
                quantityInput.setAttribute('max', availableStock);
                if (parseInt(quantityInput.value) > availableStock) {
                    quantityInput.value = availableStock;
                }
            });

            // Validasi jumlah yang dipinjam saat form disubmit
            document.querySelector('form').addEventListener('submit', function (e) {
                const selectedProduct = productSelect.selectedOptions[0];
                const availableStock = parseInt(selectedProduct.getAttribute('data-stock'));
                const quantity = parseInt(quantityInput.value);

                if (quantity > availableStock) {
                    e.preventDefault();
                    alert('Jumlah barang yang dipinjam melebihi stok yang tersedia.');
                }
            });
        });
    </script>
@endpush
