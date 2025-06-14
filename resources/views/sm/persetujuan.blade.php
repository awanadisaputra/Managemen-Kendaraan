@extends('sm.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sm/persetujuan.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('title', 'Daftar Persetujuan')

@section('content')
    <div class="approval-container">
        <div class="approval-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-clipboard-check"></i>
                    Daftar Persetujuan Pemesanan Kendaraan
                </h1>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($persetujuans->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Tidak ada pemesanan yang menunggu persetujuan</p>
                    </div>
                @else
                    <div class="table-wrapper">
                        <table class="approval-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th><i class="fas fa-user mr-1"></i> Pemesan</th>
                                    <th><i class="fas fa-car mr-1"></i> Kendaraan</th>
                                    <th><i class="fas fa-calendar-day mr-1"></i> Tanggal</th>
                                    <th><i class="fas fa-map-marker-alt mr-1"></i> Tujuan</th>
                                    <th><i class="fas fa-layer-group mr-1"></i> Tingkat</th>
                                    <th><i class="fas fa-check mr-1"></i> Setujui</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($persetujuans as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->pemesanan->user->nama }}</td>
                                        <td>{{ $item->pemesanan->kendaraan->nomor_plat }}</td>
                                        <td>
                                            <div class="date-range">
                                                <span>{{ $item->pemesanan->tanggal_mulai->format('d M Y') }}</span>
                                                <i class="fas fa-arrow-right"></i>
                                                <span>{{ $item->pemesanan->tanggal_selesai->format('d M Y') }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $item->pemesanan->tujuan_perjalanan }}</td>
                                        <td>
                                            <span class="approval-level level-{{ strtolower($item->tingkat_persetujuan) }}">
                                                {{ $item->tingkat_persetujuan }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <form action="{{ route('sm.persetujuan.disetujui', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="button" class="btn-approve"
                                                        onclick="confirmAction(this.form, 'Setujui pemesanan ini?', true)">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('sm.persetujuan.ditolak', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="button" class="btn-reject"
                                                        onclick="confirmAction(this.form, 'Tolak pemesanan ini?', false)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        // Custom confirmation dialog
        function showConfirm(options) {
            const overlay = document.createElement('div');
            overlay.className = 'confirm-overlay';

            const dialog = document.createElement('div');
            dialog.className = 'confirm-dialog';

            dialog.innerHTML = `
                                            <div class="confirm-header">
                                                <h3 class="confirm-title">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    ${options.title || 'Konfirmasi'}
                                                </h3>
                                            </div>
                                            <div class="confirm-body">
                                                ${options.message || 'Apakah Anda yakin ingin melanjutkan?'}
                                            </div>
                                            <div class="confirm-footer">
                                                <button class="confirm-btn confirm-btn-cancel">Batal</button>
                                                <button class="confirm-btn ${options.approve ? 'confirm-btn-approve' : 'confirm-btn-reject'}">
                                                    ${options.confirmText || 'Ya'}
                                                </button>
                                            </div>
                                        `;

            overlay.appendChild(dialog);
            document.body.appendChild(overlay);

            // Trigger reflow to enable animations
            void overlay.offsetWidth;
            overlay.classList.add('active');

            return new Promise((resolve) => {
                const cancelBtn = dialog.querySelector('.confirm-btn-cancel');
                const confirmBtn = dialog.querySelector(`.confirm-btn-${options.approve ? 'approve' : 'reject'}`);

                cancelBtn.addEventListener('click', () => {
                    overlay.classList.remove('active');
                    setTimeout(() => overlay.remove(), 300);
                    resolve(false);
                });

                confirmBtn.addEventListener('click', () => {
                    overlay.classList.remove('active');
                    setTimeout(() => overlay.remove(), 300);
                    resolve(true);
                });
            });
        }

        // Replace default confirm dialogs
        window.confirm = async function (message) {
            return await showConfirm({
                title: 'Konfirmasi',
                message: message,
                confirmText: 'Ya',
                approve: true
            });
        };

        // Custom confirm for approval
        function confirmApprove(message) {
            return showConfirm({
                title: 'Konfirmasi Persetujuan',
                message: message,
                confirmText: 'Setujui',
                approve: true
            });
        }

        // Custom confirm for rejection
        function confirmReject(message) {
            return showConfirm({
                title: 'Konfirmasi Penolakan',
                message: message,
                confirmText: 'Tolak',
                approve: false
            });
        }

        // Helper function for form confirmation
        async function confirmAction(form, message, isApprove) {
            const confirmed = isApprove
                ? await confirmApprove(message)
                : await confirmReject(message);

            if (confirmed) {
                form.submit();
            }
        }
    </script>
@endsection