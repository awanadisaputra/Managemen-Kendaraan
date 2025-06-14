@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/bbm/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('title', 'Riwayat BBM')

@section('content')
    <div class="bbm-history-container">
        <div class="card-header">
            <h1 class="page-title">
                <i class="fas fa-gas-pump"></i>
                Riwayat Pengisian BBM
            </h1>
            <a href="{{ route('admin.bbm.create') }}" class="add-button">
                <i class="fas fa-plus"></i>
                Tambah Riwayat BBM
            </a>
        </div>
        <div class="data-card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><i class="fas fa-car mr-1"></i> Nomor Plat</th>
                                <th><i class="fas fa-calendar-day mr-1"></i> Tanggal</th>
                                <th><i class="fas fa-oil-can mr-1"></i> Jumlah (Liter)</th>
                                <th><i class="fas fa-money-bill-wave mr-1"></i> Biaya</th>
                                <th><i class="fas fa-tachometer-alt mr-1"></i> KM Tercatat</th>
                                <th><i class="fas fa-user-edit mr-1"></i> Dicatat Oleh</th>
                                <th><i class="fas fa-user-plus mr-1"></i> Dibuat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatBbms as $bbm)
                                <tr>
                                    <td>{{ $loop->iteration + ($riwayatBbms->currentPage() - 1) * $riwayatBbms->perPage() }}
                                    </td>
                                    <td>{{ $bbm->kendaraan->nomor_plat ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bbm->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td>{{ $bbm->jumlah }} L</td>
                                    <td>Rp{{ number_format($bbm->biaya, 0, ',', '.') }}</td>
                                    <td>{{ number_format($bbm->km_tercatat) }} km</td>
                                    <td>{{ $bbm->dicatatOleh->nama ?? '-' }}</td>
                                    <td>{{ $bbm->dibuatOleh->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-gas-pump"></i>
                                        </div>
                                        <p>Tidak ada data riwayat BBM</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($riwayatBbms->hasPages())
                    <div class="pagination-container">
                        {{ $riwayatBbms->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection