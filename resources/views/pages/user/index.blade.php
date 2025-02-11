@extends('layouts.mainuser ')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard</h1>

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/user  ">Beranda</a></li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="table-responsive text-nowrap">
            <form method="GET" action="/user/index" class="d-flex mt-2 mb-2">
                <input type="search" name="search" class="form-control mx-2" placeholder="Cari berdasarkan nama" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        @php

            use App\Models\Product;

            $products = Product::query();
            $products = $products->paginate(10);
        @endphp
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endsection
