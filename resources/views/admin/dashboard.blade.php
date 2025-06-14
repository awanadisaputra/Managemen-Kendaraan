@extends('admin.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-grid">
            <!-- Card Total Kendaraan -->
            <div class="dashboard-card">
                <h5 class="card-title">Total Kendaraan</h5>
                <p class="card-value card-vehicles">{{ $totalKendaraan ?? 0 }}</p>
            </div>

            <!-- Card Total Pemesanan -->
            <div class="dashboard-card">
                <h5 class="card-title">Total Pemesanan</h5>
                <p class="card-value card-bookings">{{ $totalPemesanan ?? 0 }}</p>
            </div>

            <!-- Card Pemesanan Aktif -->
            <div class="dashboard-card">
                <h5 class="card-title">Pemesanan Aktif</h5>
                <p class="card-value card-active">{{ $pemesananAktif ?? 0 }}</p>
            </div>
        </div>

        <!-- Grafik Pemakaian -->
        <div class="chart-container">
            <div class="chart-header">
                <h5 class="chart-title">Grafik Pemakaian Kendaraan Tahun {{ $tahun }}</h5>
                <form method="GET" action="{{ route('admin.dashboard') }}" class="year-selector">
                    <label for="tahun">Pilih Tahun:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()">
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
            </div>
            <canvas id="grafikPemakaian" height="100"></canvas>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('grafikPemakaian').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Jumlah Pemakaian',
                        data: @json($dataPemakaian),
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
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
                            ticks: {
                                precision: 0,
                                stepSize: 1
                            },
                            grid: {
                                drawBorder: false,
                                color: "rgba(0, 0, 0, 0.05)"
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection