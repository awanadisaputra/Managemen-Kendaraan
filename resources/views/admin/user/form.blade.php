@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/user/form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="form-container">
        <div class="form-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-user-edit"></i>
                    {{ isset($user) ? 'Edit User' : 'Tambah User Baru' }}
                </h1>
            </div>
            <div class="card-body">
                <form action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama" class="form-label">
                            <i class="fas fa-user"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" name="nama" class="form-control" required
                            value="{{ old('nama', $user->nama ?? '') }}" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Alamat Email
                        </label>
                        <input type="email" name="email" class="form-control" required
                            value="{{ old('email', $user->email ?? '') }}" placeholder="contoh@email.com">
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}
                            placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password' }}">
                        @if(isset($user))
                            <p class="password-note">
                                <i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengubah password
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i>
                            Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Ketik ulang password">
                    </div>

                    <div class="form-group">
                        <label for="peran" class="form-label">
                            <i class="fas fa-user-tag"></i>
                            Peran Pengguna
                        </label>
                        <select name="peran" class="form-select" required>
                            <option value="">Pilih Peran</option>
                            @foreach(['admin', 'manager', 'supervisor', 'supir'] as $role)
                                <option value="{{ $role }}" {{ old('peran', $user->peran ?? '') == $role ? 'selected' : '' }}
                                    class="role-option-{{ $role }}">
                                    <i
                                        class="fas fa-{{ $role === 'admin' ? 'user-shield' : ($role === 'supir' ? 'user' : 'user-tie') }}"></i>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="atasan_id" class="form-label">
                            <i class="fas fa-user-friends"></i>
                            Atasan
                        </label>
                        <select name="atasan_id" class="form-select">
                            <option value="">Tidak Ada Atasan</option>
                            @foreach($atasanOptions as $atasan)
                                <option value="{{ $atasan->id }}" {{ old('atasan_id', $user->atasan_id ?? '') == $atasan->id ? 'selected' : '' }}>
                                    {{ $atasan->nama }} ({{ ucfirst($atasan->peran) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                        <a href="{{ route('admin.user.index') }}" class="cancel-btn">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection