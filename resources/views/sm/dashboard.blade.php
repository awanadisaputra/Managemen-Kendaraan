@extends('sm.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sm/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
    <div class="sm-dashboard">
        <div class="dashboard-header">
            <div class="header-content">
                <h1 class="dashboard-title">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </h1>
                <div class="header-actions">
                    <a href="{{ route('laporan') }}" class="export-button">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-icon">
                    <i class="fas fa-clock text-warning"></i>
                </div>
                <div>
                    <h3 class="stat-title">Pemesanan Menunggu</h3>
                    <p class="stat-value">{{ $pemesananMenunggu }}</p>
                </div>
            </div>
            <div class="stat-card approved">
                <div class="stat-icon">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <div>
                    <h3 class="stat-title">Pemesanan Disetujui</h3>
                    <p class="stat-value">{{ $pemesananDisetujui }}</p>
                </div>
            </div>
            <div class="stat-card rejected">
                <div class="stat-icon">
                    <i class="fas fa-times-circle text-danger"></i>
                </div>
                <div>
                    <h3 class="stat-title">Pemesanan Ditolak</h3>
                    <p class="stat-value">{{ $pemesananDitolak }}</p>
                </div>
            </div>
        </div>

        <div class="recent-orders">
            <h3>Pemesanan Terakhir (Menunggu / Disetujui)</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pemesan</th>
                        <th>Kendaraan</th>
                        <th>Status</th>
                        <th>Tanggal Mulai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentPemesanan as $persetujuan)
                        <tr>
                            <td>{{ $persetujuan->id }}</td>
                            <td>{{ $persetujuan->pemesanan->user->nama ?? '-' }}</td>
                            <td>{{ $persetujuan->pemesanan->kendaraan->nomor_plat ?? '-' }}</td>
                            <td>{{ ucfirst($persetujuan->status) }}</td>
                            <td>{{ \Carbon\Carbon::parse($persetujuan->pemesanan->tanggal_mulai)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="chart-container" style="margin-top: 40px;">
            <h3>Grafik Pemesanan Bulanan</h3>
            <canvas id="pemesananChart" height="100"></canvas>
        </div>

        <div class="action-container">
            <a href="{{ route('sm.persetujuan.index') }}" class="action-button">
                <i class="fas fa-list-check"></i> Lihat Daftar Persetujuan
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('pemesananChart').getContext('2d');

            const chartData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Disetujui',
                        data: @json($dataDisetujui),
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Ditolak',
                        data: @json($dataDitolak),
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }
                ]

            };

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    elements: {
                        point: {
                            radius: 4,
                            hoverRadius: 6
                        }
                    }
                }
            });
        });
    </script>
@endpush