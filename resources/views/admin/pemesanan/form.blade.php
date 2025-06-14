@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pemesanan/form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="form-container">
        <div class="form-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-calendar-plus"></i>
                    {{ isset($pemesanan) ? 'Edit Pemesanan' : 'Tambah Pemesanan' }}
                </h1>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan input:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form
                    action="{{ isset($pemesanan) ? route('admin.pemesanan.update', $pemesanan->id) : route('admin.pemesanan.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($pemesanan))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="supir_id" class="form-label">
                            <i class="fas fa-user"></i>
                            Nama Supir
                        </label>
                        <select name="supir_id" id="supir_id" class="form-select" required>
                            <option value="">Pilih Supir</option>
                            @foreach($supirs as $supir)
                                <option value="{{ $supir->id }}" {{ old('supir_id', $pemesanan->supir_id ?? '') == $supir->id ? 'selected' : '' }}>
                                    {{ $supir->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kendaraan_id" class="form-label">
                            <i class="fas fa-car"></i>
                            Kendaraan
                        </label>
                        <select name="kendaraan_id" id="kendaraan_id" class="form-select" required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach($kendaraans as $k)
                                <option value="{{ $k->id }}" {{ old('kendaraan_id', $pemesanan->kendaraan_id ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nomor_plat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_mulai" class="form-label">
                            <i class="fas fa-calendar-day"></i>
                            Tanggal Mulai
                        </label>
                        <input type="datetime-local" name="tanggal_mulai" class="form-control" required
                            value="{{ old('tanggal_mulai', isset($pemesanan) ? $pemesanan->tanggal_mulai->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_selesai" class="form-label">
                            <i class="fas fa-calendar-check"></i>
                            Tanggal Selesai
                        </label>
                        <input type="datetime-local" name="tanggal_selesai" class="form-control"
                            value="{{ old('tanggal_selesai', isset($pemesanan) ? $pemesanan->tanggal_selesai->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <div class="form-group">
                        <label for="tujuan_penggunaan" class="form-label">
                            <i class="fas fa-bullseye"></i>
                            Tujuan Penggunaan
                        </label>
                        <input type="text" name="tujuan_penggunaan" class="form-control" required
                            value="{{ old('tujuan_penggunaan', $pemesanan->tujuan_penggunaan ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="tujuan_perjalanan" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Tujuan Perjalanan
                        </label>
                        <input type="text" name="tujuan_perjalanan" class="form-control" required
                            value="{{ old('tujuan_perjalanan', $pemesanan->tujuan_perjalanan ?? '') }}">
                    </div>
                    <div class="button-group">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                        <a href="{{ route('admin.pemesanan.index') }}" class="cancel-btn">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection