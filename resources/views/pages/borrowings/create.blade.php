@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Peminjaman Barang</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Peminjaman Barang</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan!</strong> Silakan periksa form di bawah.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="user_id">Peminjam</label>
                    <select name="user_id" id="user_id" class="form-control select2 @error('user_id') is-invalid @enderror" required>
                        <option value="">Pilih Peminjam</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="product_id">Barang</label>
                    <select name="product_id" id="product_id"
                        class="form-control select2 @error('product_id') is-invalid @enderror" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-stock="{{ $product->stock }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Stok: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                    <small id="stockInfo" class="form-text text-muted"></small>
                    @error('product_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" name="quantity" id="quantity"
                        class="form-control @error('quantity') is-invalid @enderror" min="1"
                        value="{{ old('quantity', 1) }}" required>
                    @error('quantity')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="borrow_date">Tanggal Pinjam</label>
                            <input type="date" name="borrow_date" id="borrow_date"
                                class="form-control @error('borrow_date') is-invalid @enderror" min="{{ date('Y-m-d') }}"
                                value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                            @error('borrow_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="return_date">Tanggal Kembali</label>
                            <input type="date" name="return_date" id="return_date"
                                class="form-control @error('return_date') is-invalid @enderror"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                value="{{ old('return_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                            @error('return_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </div>
        </div>
    </form>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            function updateStockInfo() {
                const productSelect = $('#product_id');
                const quantityInput = $('#quantity');
                const stockInfo = $('#stockInfo');

                if (productSelect.val()) {
                    const stock = parseInt(productSelect.find(':selected').data('stock'));
                    stockInfo.text(`Stok tersedia: ${stock}`);
                    quantityInput.attr('max', stock);
                } else {
                    stockInfo.text('');
                }
            }

            $('#product_id').change(updateStockInfo);
            updateStockInfo();

            $('#borrow_date').change(function() {
                const borrowDate = new Date($(this).val());
                const returnDate = $('#return_date');

                if (borrowDate) {
                    const minReturnDate = new Date(borrowDate);
                    minReturnDate.setDate(minReturnDate.getDate() + 1);

                    returnDate.attr('min', minReturnDate.toISOString().split('T')[0]);

                    if (new Date(returnDate.val()) < minReturnDate) {
                        returnDate.val(minReturnDate.toISOString().split('T')[0]);
                    }
                }
            });
        });
    </script>
@endpush
