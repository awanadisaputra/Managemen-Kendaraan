@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/bbm/create.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('title', 'Tambah Riwayat BBM')

@section('content')
    <div class="bbm-form-container">
        <div class="form-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-gas-pump"></i>
                    Tambah Riwayat BBM
                </h1>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul class="error-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.bbm.store') }}" method="POST">
                    @csrf

                    <!-- Kendaraan -->
                    <div class="form-group">
                        <label for="kendaraan_id" class="form-label">
                            <i class="fas fa-car"></i> Kendaraan
                        </label>
                        <select name="kendaraan_id" id="kendaraan_id" class="form-control" required>
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" @selected(old('kendaraan_id') == $kendaraan->id)>
                                    {{ $kendaraan->nama }} - {{ $kendaraan->nomor_plat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div class="form-group">
                        <label for="tanggal" class="form-label">
                            <i class="fas fa-calendar-day"></i> Tanggal Pengisian
                        </label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}"
                            required>
                    </div>

                    <!-- Jumlah Liter -->
                    <div class="form-group">
                        <label for="jumlah" class="form-label">
                            <i class="fas fa-oil-can"></i> Jumlah Liter
                        </label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah') }}"
                            step="0.01" min="0" required>
                    </div>

                    <!-- Total Biaya -->
                    <div class="form-group">
                        <label for="biaya" class="form-label">
                            <i class="fas fa-money-bill-wave"></i> Total Biaya
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="biaya" id="biaya" class="form-control" value="{{ old('biaya') }}"
                                step="100" min="0" required>
                        </div>
                    </div>

                    <!-- KM Tercatat -->
                    <div class="form-group">
                        <label for="km_tercatat" class="form-label">
                            <i class="fas fa-tachometer-alt"></i> KM Tercatat
                        </label>
                        <input type="number" name="km_tercatat" id="km_tercatat" class="form-control"
                            value="{{ old('km_tercatat') }}" min="0" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="form-group">
                        <label for="keterangan" class="form-label">
                            <i class="fas fa-clipboard"></i> Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                            class="form-control">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="button-group">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <a href="{{ route('admin.bbm.index') }}" class="btn-cancel">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection