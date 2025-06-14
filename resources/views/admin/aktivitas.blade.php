@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/aktivitas.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('title', 'Riwayat Aktivitas')

@section('content')
    <div class="activity-history-container">
        <div class="card-header">
            <h1 class="page-title">
                <i class="fas fa-history"></i>
                Riwayat Aktivitas Admin
            </h1>
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
                                <th><i class="fas fa-clock mr-1"></i> Waktu</th>
                                <th><i class="fas fa-user mr-1"></i> Nama User</th>
                                <th><i class="fas fa-bolt mr-1"></i> Aksi</th>
                                <th><i class="fas fa-info-circle mr-1"></i> Deskripsi</th>
                                <th><i class="fas fa-network-wired mr-1"></i> Alamat IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatAktivitas as $index => $aktivitas)
                                <tr>
                                    <td>{{ $riwayatAktivitas->firstItem() + $index }}</td>
                                    <td>{{ date('d M Y, H:i', strtotime($aktivitas->created_at)) }}</td>
                                    <td>{{ $aktivitas->user->nama ?? '-' }}</td>
                                    <td>
                                        <span class="activity-badge activity-{{ strtolower($aktivitas->jenis_aktivitas) }}">
                                            {{ ucfirst($aktivitas->jenis_aktivitas) }}
                                        </span>
                                    </td>
                                    <td>{{ $aktivitas->deskripsi }}</td>
                                    <td>{{ $aktivitas->alamat_ip }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-history"></i>
                                        </div>
                                        <p>Tidak ada data aktivitas</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($riwayatAktivitas->hasPages())
                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Menampilkan {{ $riwayatAktivitas->firstItem() }} - {{ $riwayatAktivitas->lastItem() }} dari
                            {{ $riwayatAktivitas->total() }} aktivitas
                        </div>
                        <div class="pagination-links">
                            {{ $riwayatAktivitas->onEachSide(1)->links('admin.pagination') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection