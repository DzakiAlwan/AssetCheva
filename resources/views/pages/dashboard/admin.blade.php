@extends('layouts.main ')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard</h1>

        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $productCount }}</h3>

                    <p>Produk/Barang</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="/products" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $categoryCount }}</h3>

                    <p>Kategori</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="/categories" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $peminjamCount }}</h3>

                    <p>Peminjam</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="/peminjam" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
