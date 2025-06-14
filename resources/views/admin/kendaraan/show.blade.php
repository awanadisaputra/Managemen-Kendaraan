@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kendaraan/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="detail-container">
        <div class="detail-header">
            <h1 class="detail-title">
                <i class="fas fa-car-side"></i>
                Detail Kendaraan
            </h1>
        </div>

        <div class="detail-card">
            <div class="detail-row">
                <span class="detail-label">
                    <i class="fas fa-id-card"></i>
                    Nomor Plat:
                </span>
                <span class="detail-value">{{ $kendaraan->nomor_plat }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">
                    <i class="fas fa-tags"></i>
                    Jenis Kendaraan:
                </span>
                <span class="detail-value">
                    @if($kendaraan->jenis_kendaraan === 'angkutan-orang')
                        <i class="fas fa-users mr-1"></i>
                    @else
                        <i class="fas fa-boxes mr-1"></i>
                    @endif
                    {{ ucfirst(str_replace('_', ' ', $kendaraan->jenis_kendaraan)) }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">
                    <i class="fas fa-key"></i>
                    Status Kepemilikan:
                </span>
                <span class="detail-value">{{ ucfirst(str_replace('_', ' ', $kendaraan->status_kepemilikan)) }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">
                    <i class="fas fa-gas-pump"></i>
                    Konsumsi BBM:
                </span>
                <span class="detail-value">{{ $kendaraan->konsumsi_bbm }} km/liter</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">
                    <i class="fas fa-calendar-alt"></i>
                    Terakhir Service:
                </span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($kendaraan->terakhir_service)->format('d F Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">
                    <i class="fas fa-tachometer-alt"></i>
                    KM Service Berikutnya:
                </span>
                <span class="detail-value">{{ number_format($kendaraan->km_service_berikutnya) }} km</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">
                    <i class="fas fa-road"></i>
                    KM Terakhir:
                </span>
                <span class="detail-value">{{ number_format($kendaraan->km_terakhir) }} km</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">
                    <i class="fas fa-info-circle"></i>
                    Status:
                </span>
                <span class="detail-value">
                    <span class="status-badge status-{{ $kendaraan->status }}">
                        @if($kendaraan->status === 'tersedia')
                            <i class="fas fa-check-circle mr-1"></i>
                        @elseif($kendaraan->status === 'diservice')
                            <i class="fas fa-tools mr-1"></i>
                        @elseif($kendaraan->status === 'dipesan')
                            <i class="fas fa-calendar-check mr-1"></i>
                        @endif
                        {{ ucfirst($kendaraan->status) }}
                    </span>
                </span>
            </div>
        </div>

        <a href="{{ route('admin.kendaraan.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar
        </a>
    </div>
@endsection