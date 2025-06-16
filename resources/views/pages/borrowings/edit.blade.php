@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Peminjaman Barang</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('borrowings.index') }}">Peminjaman Barang</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <!-- Alert untuk error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($borrowing->status == 'Dikembalikan')
        <div class="alert alert-info">
            <h5><i class="icon fas fa-info-circle"></i> Informasi!</h5>
            Data peminjaman ini sudah dikembalikan dan tidak dapat diubah. Berikut detail peminjaman:
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Peminjam</label>
                    <input type="text" class="form-control bg-light"
                        value="{{ $borrowing->user->name }} ({{ $borrowing->user->phone }})" readonly>
                </div>

                <div class="form-group">
                    <label>Barang yang Dipinjam</label>
                    <input type="text" class="form-control bg-light"
                        value="{{ $borrowing->product->name }} (Stok: {{ $borrowing->product->stock }})" readonly>
                </div>

                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="text" class="form-control bg-light" value="{{ $borrowing->quantity }}" readonly>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Pinjam</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $borrowing->borrow_date->format('d/m/Y') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Kembali</label>
                            <input type="text" class="form-control bg-light"
                                value="{{ $borrowing->return_date->format('d/m/Y') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control bg-light" value="{{ $borrowing->status }}" readonly>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

    @else
        <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="user_id">Peminjam</label>
                        <select name="user_id_display" id="user_id"
                            class="form-control @error('user_id') is-invalid @enderror" disabled>
                            <option value="{{ $borrowing->user_id ?? '' }}" selected>
                                {{ $borrowing->user->name ?? ($borrowing->borrower_name ?? 'N/A') }}
                            </option>
                        </select>
                        <input type="hidden" name="user_id" value="{{ $borrowing->user_id ?? '' }}">
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="product_id">Barang</label>
                        <select name="product_id" id="product_id"
                            class="form-control select2 @error('product_id') is-invalid @enderror" required readonly>
                            <option value="">Pilih Barang</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-stock="{{ $product->stock }}"
                                    {{ old('product_id', $borrowing->product_id) == $product->id ? 'selected' : '' }}>
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
                            class="form-control @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity', $borrowing->quantity) }}" readonly>
                        @error('quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="borrow_date">Tanggal Pinjam</label>
                                <input type="date" name="borrow_date" id="borrow_date"
                                    class="form-control @error('borrow_date') is-invalid @enderror"
                                    value="{{ old('borrow_date', $borrowing->borrow_date->format('Y-m-d')) }}" required>
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
                                    value="{{ old('return_date', $borrowing->return_date->format('Y-m-d')) }}" required>
                                @error('return_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                            required>
                            <option value="Dipinjamkan"
                                {{ old('status', $borrowing->status) == 'Dipinjamkan' ? 'selected' : '' }}>Dipinjamkan</option>
                            <option value="Dikembalikan"
                                {{ old('status', $borrowing->status) == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan
                            </option>
                        </select>
                        <small class="text-muted">Anda hanya dapat mengubah status menjadi Dikembalikan</small>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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
    @endif
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 dengan opsi disabled
            $('.select2').select2({
                disabled: {{ $borrowing->status == 'Dikembalikan' ? 'true' : 'false' }}
            });

            // Update stock info
            $('#product_id').change(function() {
                const selectedProduct = $(this).find(':selected');
                const stock = selectedProduct.data('stock');
                $('#stockInfo').text(`Stok tersedia: ${stock}`);
                $('#quantity').attr('max', stock);
            }).trigger('change');

            // Validasi tanggal kembali
            $('#borrow_date').change(function() {
                const borrowDate = new Date($(this).val());
                if (!isNaN(borrowDate.getTime())) {
                    const minReturnDate = new Date(borrowDate);
                    minReturnDate.setDate(minReturnDate.getDate() + 1);
                    $('#return_date').attr('min', minReturnDate.toISOString().split('T')[0]);
                }
            });

            // Auto close alert setelah 5 detik
            setTimeout(function() {
                $('.alert-danger').fadeOut('slow');
            }, 5000);
        });
    </script>
@endpush
