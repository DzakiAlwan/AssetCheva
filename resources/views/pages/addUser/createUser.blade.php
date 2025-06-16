@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Pengguna</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <!-- Alert untuk error validasi -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><i class="icon fas fa-ban"></i> Gagal Menyimpan!</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Alert untuk error database -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Form fields tetap sama -->
                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="role">Role <span class="text-danger">*</span></label>
                    <select name="role" id="role"
                            class="form-control @error('role') is-invalid @enderror" required>
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
                    <label for="nip">NIP/NIM</label>
                    <input type="text" name="nip" id="nip"
                           class="form-control @error('nip') is-invalid @enderror"
                           value="{{ old('nip') }}"
                           maxlength="20"
                           pattern="[0-9]*"
                           inputmode="numeric">
                    <small class="text-muted">Wajib diisi untuk role Dosen/Mahasiswa (maksimal 20 angka)</small>
                    @error('nip')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}">
                    @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const nipInput = document.getElementById('nip');

        // Handle NIP requirement based on role
        function handleRoleChange() {
            if(roleSelect.value === 'Dosen' || roleSelect.value === 'Mahasiswa') {
                nipInput.setAttribute('required', '');
                nipInput.closest('.form-group').querySelector('label').innerHTML =
                    'NIP/NIM <span class="text-danger">*</span>';
            } else {
                nipInput.removeAttribute('required');
                nipInput.closest('.form-group').querySelector('label').innerHTML = 'NIP/NIM';
            }
        }

        // Initial check
        handleRoleChange();

        // Event listener for role change
        roleSelect.addEventListener('change', handleRoleChange);

        // Auto close alert after 5 seconds
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
@endpush
