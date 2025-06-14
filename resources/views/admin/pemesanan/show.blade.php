@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pemesanan/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="booking-detail-container">
        <div class="detail-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-calendar-check"></i>
                    Detail Pemesanan Kendaraan
                </h1>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-user"></i>
                        Supir:
                    </span>
                    <span class="detail-value">{{ $pemesanan->supir->nama }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-car"></i>
                        Kendaraan:
                    </span>
                    <span class="detail-value">{{ $pemesanan->kendaraan->nomor_plat }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-calendar-day"></i>
                        Tanggal Mulai:
                    </span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($pemesanan->tanggal_mulai)->translatedFormat('d F Y H:i') }}
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-calendar-check"></i>
                        Tanggal Selesai:
                    </span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($pemesanan->tanggal_selesai)->translatedFormat('d F Y H:i') }}
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-bullseye"></i>
                        Tujuan Penggunaan:
                    </span>
                    <span class="detail-value">{{ $pemesanan->tujuan_penggunaan }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-map-marker-alt"></i>
                        Tujuan Perjalanan:
                    </span>
                    <span class="detail-value">{{ $pemesanan->tujuan_perjalanan }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-info-circle"></i>
                        Status:
                    </span>
                    <span class="detail-value">
                        <span class="status-badge status-{{ strtolower($pemesanan->status) }}">
                            @switch($pemesanan->status)
                                @case('pending')
                                    <i class="fas fa-clock mr-1"></i>
                                @break
                                @case('disetujui')
                                    <i class="fas fa-check-circle mr-1"></i>
                                @break
                                @case('ditolak')
                                    <i class="fas fa-times-circle mr-1"></i>
                                @break
                                @case('selesai')
                                    <i class="fas fa-flag-checkered mr-1"></i>
                                @break
                            @endswitch
                            {{ ucfirst(str_replace('_', ' ', $pemesanan->status)) }}
                        </span>
                    </span>
                </div>

                <a href="{{ route('admin.pemesanan.index') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection