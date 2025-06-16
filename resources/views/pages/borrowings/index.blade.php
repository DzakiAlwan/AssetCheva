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
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="table-responsive text-nowrap">
                <form method="GET" action="/borrowings" class="d-flex mt-2 mb-2">
                    <input type="search" name="search" class="form-control mx-2" placeholder="Cari berdasarkan nama" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
        </div>
        <div class="card-header d-flex justify-content-end">
            <a href="/borrowings/create" class="btn btn-primary">Tambah Peminjaman</a>
        </div>
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Barang yang Dipinjam</th>
                    <th>Jumlah</th>
                    <th>Tanggal Meminjam</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowings as $borrowing)
                    <tr>
                        <td>{{ ($borrowings->currentPage() - 1) * $borrowings->perPage() + $loop->index + 1 }}</td>
                        <td>{{ $borrowing->user->name ?? $borrowing->borrower_name ?? 'N/A' }}</td>
                        <td>{{ $borrowing->product->name }}</td>
                        <td>{{ $borrowing->quantity }}</td>
                        <td>{{ $borrowing->borrow_date }}</td>
                        <td>{{ $borrowing->return_date }}</td>
                        <td>
                            @if($borrowing->status == 'Dipinjamkan')
                                <span class="badge badge-warning">Dipinjamkan</span>
                            @elseif($borrowing->status == 'Dikembalikan')
                                <span class="badge badge-success">Dikembalikan</span>
                            @elseif($borrowing->status == 'Hilang')
                                <span class="badge badge-danger">Hilang</span>
                            @elseif($borrowing->status == 'Rusak')
                                <span class="badge badge-danger">Rusak</span>
                            @else
                                <span class="badge badge-secondary">{{ $borrowing->status }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('borrowings.edit', $borrowing->id) }}" class="btn btn-sm btn-warning mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#modal-delete-{{ $borrowing->id }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @include('pages.borrowings.delete-confirmasi')
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $borrowings->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
