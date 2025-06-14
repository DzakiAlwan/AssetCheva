@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Data Pengguna</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Data Pengguna</li>
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
                <form id="filterForm" method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center mt-2 mb-2">
                    <!-- Search Input -->
                    <input type="search" name="search" id="searchInput" class="form-control mx-2"
                           placeholder="Cari (nama/email/NIP)" value="{{ request('search') }}">

                    <!-- Role Dropdown -->
                    <select name="role" id="roleSelect" class="form-control mx-2">
                        <option value="">Semua Role</option>
                        <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Dosen" {{ request('role') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="Mahasiswa" {{ request('role') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>

                    <button type="submit" class="btn btn-primary mx-2" style="display: none;">Filter</button>
                    <a href="/users" class="btn btn-secondary">Reset</a>
                </form>
            </div>
        </div>

        <div class="card-header d-flex justify-content-end">
            <a href="/users/create" class="btn btn-primary">Tambah Pengguna</a>
        </div>

        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>NIP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->nip ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#modal-delete-{{ $user->id }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Modal Delete -->
<div class="modal fade" id="modal-delete-{{ $user->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const roleSelect = document.getElementById('roleSelect');
            const filterForm = document.getElementById('filterForm');

            // Debounce function untuk delay pencarian
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this, args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        func.apply(context, args);
                    }, wait);
                };
            }

            // Fungsi untuk submit form
            function submitForm() {
                filterForm.submit();
            }

            // Event listeners dengan debounce
            searchInput.addEventListener('input', debounce(submitForm, 500));
            roleSelect.addEventListener('change', submitForm);
        });
    </script>
    @endpush
@endsection
