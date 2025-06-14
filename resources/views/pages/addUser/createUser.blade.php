@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Pengguna</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Pengguna</li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">Pilih Role</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Dosen" {{ old('role') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="Mahasiswa" {{ old('role') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nip" class="form-label">NIP/NIM</label>
                    <input type="text" name="nip" id="nip"
                        class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}">
                    @error('nip')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Validasi role dan NIP/NIM
            const roleSelect = document.getElementById('role');
            const nipInput = document.getElementById('nip');

            roleSelect.addEventListener('change', function() {
                if(this.value === 'Dosen' || this.value === 'Mahasiswa') {
                    nipInput.setAttribute('required', '');
                } else {
                    nipInput.removeAttribute('required');
                }
            });
        });
    </script>
@endpush
