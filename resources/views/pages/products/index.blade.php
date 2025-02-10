@extends('layouts.main ')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Barang</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Barang</li>
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
        <div class="card-header d-flex justify-content-end">
            <a href="/products/create" class="btn btn-primary">
                Tambah Barang</a>
        </div>
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Kode</th>
                    <th>Stock</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description ?? '-' }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="/products/edit/{{ $product->id }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#modal-delete-{{ $product->id }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @include('pages.products.delete-confirmasi')
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="card-footer">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endsection
