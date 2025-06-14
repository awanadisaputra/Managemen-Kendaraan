@extends('sm.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sm/servis.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('title', 'Riwayat Servis Kendaraan')

@section('content')
    <div class="service-history-container">
        <div class="service-history-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-tools"></i>
                    Riwayat Servis Kendaraan
                </h1>
            </div>
            <div class="card-body">
                @if($riwayatServis->count())
                    <div class="table-wrapper">
                        <table class="service-history-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th><i class="fas fa-car-alt mr-1"></i> Nomor Plat</th>
                                    <th><i class="fas fa-calendar-day mr-1"></i> Tanggal Servis</th>
                                    <th><i class="fas fa-money-bill-wave mr-1"></i> Biaya</th>
                                    <th><i class="fas fa-clipboard mr-1"></i> Catatan</th>
                                    <th><i class="fas fa-user mr-1"></i> Dibuat Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatServis as $index => $servis)
                                    <tr>
                                        <td>{{ $loop->iteration + ($riwayatServis->currentPage() - 1) * $riwayatServis->perPage() }}
                                        </td>
                                        <td>
                                            <span class="plate-number">{{ $servis->kendaraan->nomor_plat ?? '-' }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($servis->tanggal_service)->format('d M Y') }}</td>
                                        <td class="cost">Rp{{ number_format($servis->biaya, 0, ',', '.') }}</td>
                                        <td class="notes">{{ $servis->catatan ?? '-' }}</td>
                                        <td>{{ $servis->dibuatOleh->nama ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($riwayatServis->hasPages())
                        <div class="pagination-wrapper">
                            {{ $riwayatServis->onEachSide(1)->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-tools"></i>
                        <p>Belum ada data riwayat servis kendaraan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection