@extends('layouts.main ')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Peminjam</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Peminjam</li>
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
            <form method="GET" action="/user/index" class="d-flex mt-2 mb-2">
                <input type="search" name="search" class="form-control mx-2" placeholder="Cari berdasarkan nama" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
        </div>
        <div class="card-header d-flex justify-content-end">
            <a href="/peminjam/create" class="btn btn-primary">
                Tambah Peminjam</a>
        </div>
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal Meminjam</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tbody>
                    @foreach ($peminjams as $key => $peminjam)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $peminjam->name }}</td>
                            <td>{{ $peminjam->product->name }}</td>
                            <td>{{ $peminjam->jumlah }}</td>
                            <td>{{ date('d-m-Y', strtotime($peminjam->created_at)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($peminjam->pengembalian)) }}</td>
                            <td>
                                <a href="/peminjam/edit/{{ $peminjam->id }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#modal-delete-{{ $peminjam->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @include('pages.peminjam.delete-confirmasi')
                    @endforeach

                    @if ($peminjams->isEmpty())
                        <tr>
                            <td colspan="7">Tidak ada data peminjaman.</td>
                        </tr>
                    @endif
                </tbody>

            </tbody>
        </table>

    </div>
    <div class="card-footer">
        {{ $peminjams->links('pagination::bootstrap-5') }}
    </div>
@endsection
