@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/servis/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('title', 'Riwayat Servis Kendaraan')

@section('content')
    <div class="service-history-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-tools"></i>
                Riwayat Servis Kendaraan
            </h1>
            <a href="{{ route('admin.servis.create') }}" class="add-button">
                <i class="fas fa-plus"></i>
                Tambah Riwayat Servis
            </a>
        </div>
        <div class="data-card">
            <div class="card-body">
                @if(session('success'))
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
                                <th><i class="fas fa-calendar-day mr-1"></i> Tanggal Servis</th>
                                <th><i class="fas fa-money-bill-wave mr-1"></i> Biaya</th>
                                <th><i class="fas fa-clipboard mr-1"></i> Catatan</th>
                                <th><i class="fas fa-tachometer-alt mr-1"></i> KM Servis Berikutnya</th>
                                <th><i class="fas fa-user mr-1"></i> Dibuat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatServis as $index => $servis)
                                <tr>
                                    <td>{{ $riwayatServis->firstItem() + $index }}</td>
                                    <td>{{ $servis->kendaraan->nomor_plat ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($servis->tanggal_service)->translatedFormat('d-m-Y') }}</td>
                                    <td>Rp{{ number_format($servis->biaya, 0, ',', '.') }}</td>
                                    <td>{{ $servis->catatan ?? '-' }}</td>
                                    <td>{{ number_format($servis->km_servis_berikutnya) }}</td>
                                    <td>{{ $servis->dibuatOleh->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <i class="fas fa-car-mechanic empty-icon"></i>
                                        <p>Belum ada data riwayat servis</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($riwayatServis->hasPages())
                    <div class="pagination-container">
                        {{ $riwayatServis->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection