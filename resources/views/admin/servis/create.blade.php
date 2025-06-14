@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/servis/create.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('title', 'Tambah Riwayat Servis')

@section('content')
    <div class="service-form-container">
        <div class="form-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-tools"></i>
                    Tambah Riwayat Servis
                </h1>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.servis.store') }}" method="POST">
                    @php $servis = null; @endphp
                    @csrf

                    <div class="form-group">
                        <label for="kendaraan_id" class="form-label">
                            <i class="fas fa-car"></i>
                            Kendaraan
                        </label>
                        <select name="kendaraan_id" id="kendaraan_id" class="form-select" required>
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" @if(old('kendaraan_id', $servis->kendaraan_id ?? '') == $kendaraan->id) selected @endif>
                                    {{ $kendaraan->nomor_plat }} - {{ $kendaraan->merk }}
                                </option>
                            @endforeach
                        </select>
                        @error('kendaraan_id')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_service" class="form-label">
                            <i class="fas fa-calendar-day"></i>
                            Tanggal Servis
                        </label>
                        <input type="date" name="tanggal_service" id="tanggal_service" class="form-control"
                            value="{{ old('tanggal_service', $servis->tanggal_service ?? '') }}" required>
                        @error('tanggal_service')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="biaya" class="form-label">
                            <i class="fas fa-money-bill-wave"></i>
                            Biaya
                        </label>
                        <input type="number" name="biaya" id="biaya" class="form-control"
                            value="{{ old('biaya', $servis->biaya ?? '') }}" required>
                        @error('biaya')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="catatan" class="form-label">
                            <i class="fas fa-clipboard"></i>
                            Catatan
                        </label>
                        <textarea name="catatan" id="catatan" class="form-control"
                            rows="3">{{ old('catatan', $servis->catatan ?? '') }}</textarea>
                        @error('catatan')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="km_servis_berikutnya" class="form-label">
                            <i class="fas fa-tachometer-alt"></i>
                            KM Servis Berikutnya
                        </label>
                        <input type="number" name="km_servis_berikutnya" id="km_servis_berikutnya" class="form-control"
                            value="{{ old('km_servis_berikutnya', $servis->km_servis_berikutnya ?? '') }}" required>
                        @error('km_servis_berikutnya')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="button-group">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                        <a href="{{ route('admin.servis.index') }}" class="cancel-btn">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection