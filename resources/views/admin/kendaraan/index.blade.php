@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kendaraan/index.css') }}">
@endpush

@section('content')
    <div class="kendaraan-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-truck"></i>
                Daftar Kendaraan
            </h1>
            <a href="{{ route('admin.kendaraan.create') }}" class="add-button">
                <i class="fas fa-plus"></i>
                Tambah Kendaraan
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><i class="fas fa-car mr-1"></i> Nomor Plat</th>
                            <th><i class="fas fa-tags mr-1"></i> Jenis</th>
                            <th><i class="fas fa-info-circle mr-1"></i> Status</th>
                            <th><i class="fas fa-key mr-1"></i> Kepemilikan</th>
                            <th><i class="fas fa-tachometer-alt mr-1"></i> KM Terakhir</th>
                            <th><i class="fas fa-cog mr-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kendaraans as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-medium">{{ $k->nomor_plat }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        @if($k->jenis_kendaraan === 'mobil')
                                            <i class="fas fa-car text-blue-500"></i>
                                        @elseif($k->jenis_kendaraan === 'motor')
                                            <i class="fas fa-motorcycle text-orange-500"></i>
                                        @elseif($k->jenis_kendaraan === 'truk')
                                            <i class="fas fa-truck text-gray-500"></i>
                                        @endif
                                        {{ ucfirst(str_replace('_', ' ', $k->jenis_kendaraan)) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $k->status }}">
                                        @if($k->status === 'tersedia')
                                            <i class="fas fa-check-circle mr-1"></i>
                                        @elseif($k->status === 'digunakan')
                                            <i class="fas fa-road mr-1"></i>
                                        @elseif($k->status === 'perbaikan')
                                            <i class="fas fa-tools mr-1"></i>
                                        @endif
                                        {{ ucfirst($k->status) }}
                                    </span>
                                </td>
                                <td>{{ ucfirst(str_replace('_', ' ', $k->status_kepemilikan)) }}</td>
                                <td>{{ number_format($k->km_terakhir) }} km</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.kendaraan.show', $k->id) }}" class="action-btn btn-detail"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.kendaraan.edit', $k->id) }}" class="action-btn btn-edit"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.kendaraan.destroy', $k->id) }}" method="POST"
                                            class="action-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(event)" class="action-btn btn-delete"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-car-crash"></i>
                                    </div>
                                    <p>Belum ada data kendaraan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function confirmDelete(event) {
                    event.preventDefault();
                    const form = event.target.closest('form');

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: "Apakah Anda yakin ingin menghapus kendaraan ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'rounded-lg shadow-xl',
                            confirmButton: 'px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white',
                            cancelButton: 'px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-gray-800'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            </script>
        @endpush
    @endpush
@endsection