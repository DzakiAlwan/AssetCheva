@extends('layouts.main ')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Kategori</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Kategori</li>
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
            <a href="/categories/create" class="btn btn-primary">
                Tambah Kategori</a>
        </div>
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->index + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="/categories/edit/{{ $category->id }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#modal-delete-{{ $category->id }}">
                                    Hapus
                                </button>
                            </div>
                        </td>

                    </tr>
                    @include('pages.categories.delete-confirmasi')
                @endforeach
            </tbody>
        </table>
        <div class="div card-footer">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
