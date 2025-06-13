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
        <div class="card-header d-flex justify-content-between">
            <div class="table-responsive text-nowrap">
                <form method="GET" action="/products" class="d-flex mt-2 mb-2">
                    <input type="search" name="search" class="form-control mx-2" placeholder="Cari berdasarkan nama" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
        </div>
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
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Sumber</th>
                    <th>Gambar</th>
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
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->tanggal }}</td>
                        <td>{{ $product->source }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" style="width: 50px; height: 50px;">
                            @else
                                <img src="{{ asset('images/default.png') }}" alt="Default Image" style="width: 50px; height: 50px;">
                            @endif
                        </td> <!-- Display image -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="/products/detail/{{ $product->id }}" class="btn btn-sm btn-warning mr-2">Detail</a>
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
