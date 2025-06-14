@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pemesanan/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="pemesanan-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-calendar-check mr-2"></i>
                Daftar Pemesanan Kendaraan
            </h1>
            <a href="{{ route('admin.pemesanan.create') }}" class="add-button">
                <i class="fas fa-plus"></i>
                Tambah Pemesanan
            </a>
        </div>
        <div class="data-card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-car mr-1"></i> Nomor Plat</th>
                            <th><i class="fas fa-user mr-1"></i> Nama Supir</th>
                            <th><i class="fas fa-calendar-alt mr-1"></i> Tanggal Mulai</th>
                            <th><i class="fas fa-info-circle mr-1"></i> Status</th>
                            <th><i class="fas fa-cog mr-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemesanan as $item)
                            <tr>
                                <td>{{ $item->kendaraan->nomor_plat ?? '-' }}</td>
                                <td>{{ $item->supir->nama ?? '-' }}</td>
                                <td>{{ $item->tanggal_mulai->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($item->status) }}">
                                        @if($item->status === 'pending')
                                            <i class="fas fa-clock mr-1"></i>
                                        @elseif($item->status === 'disetujui')
                                            <i class="fas fa-check-circle mr-1"></i>
                                        @elseif($item->status === 'ditolak')
                                            <i class="fas fa-times-circle mr-1"></i>
                                        @endif
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.pemesanan.show', $item->id) }}" class="action-btn btn-view"
                                            title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pemesanan.edit', $item->id) }}" class="action-btn btn-edit"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <p>Belum ada pemesanan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection