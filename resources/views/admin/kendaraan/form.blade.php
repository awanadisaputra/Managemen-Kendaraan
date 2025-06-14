@csrf

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kendaraan/form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush


<div class="form-container">
    <h1 class="form-title">
        <i class="fas fa-car-side"></i>
        {{ isset($kendaraan) ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru' }}
    </h1>

    <form method="POST"
        action="{{ isset($kendaraan) ? route('admin.kendaraan.update', $kendaraan->id) : route('admin.kendaraan.store') }}">
        @csrf
        @if(isset($kendaraan))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nomor_plat" class="form-label">
                <i class="fas fa-id-card"></i>
                Nomor Plat
            </label>
            <input type="text" name="nomor_plat" class="form-control"
                value="{{ old('nomor_plat', $kendaraan->nomor_plat ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="jenis_kendaraan" class="form-label">
                <i class="fas fa-tags"></i>
                Jenis Kendaraan
            </label>
            <select name="jenis_kendaraan" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="angkutan-orang" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan ?? '') == 'angkutan-orang' ? 'selected' : '' }}>
                    Angkutan Orang
                </option>
                <option value="angkutan_barang" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan ?? '') == 'angkutan_barang' ? 'selected' : '' }}>
                    Angkutan Barang
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="status_kepemilikan" class="form-label">
                <i class="fas fa-key"></i>
                Status Kepemilikan
            </label>
            <select name="status_kepemilikan" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="milik_perusahaan" {{ old('status_kepemilikan', $kendaraan->status_kepemilikan ?? '') == 'milik_perusahaan' ? 'selected' : '' }}>
                    Milik Perusahaan
                </option>
                <option value="sewaan" {{ old('status_kepemilikan', $kendaraan->status_kepemilikan ?? '') == 'sewa' ? 'selected' : '' }}>
                    Sewa
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="konsumsi_bbm" class="form-label">
                <i class="fas fa-gas-pump"></i>
                Konsumsi BBM (km/liter)
            </label>
            <input type="number" step="0.1" name="konsumsi_bbm" class="form-control"
                value="{{ old('konsumsi_bbm', $kendaraan->konsumsi_bbm ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="terakhir_service" class="form-label">
                <i class="fas fa-calendar-alt"></i>
                Tanggal Terakhir Servis
            </label>
            <input type="date" name="terakhir_service" class="form-control"
                value="{{ old('terakhir_service', $kendaraan->terakhir_service ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="km_service_berikutnya" class="form-label">
                <i class="fas fa-tachometer-alt"></i>
                KM Servis Berikutnya
            </label>
            <input type="number" name="km_service_berikutnya" class="form-control"
                value="{{ old('km_service_berikutnya', $kendaraan->km_service_berikutnya ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="km_terakhir" class="form-label">
                <i class="fas fa-road"></i>
                KM Terakhir
            </label>
            <input type="number" name="km_terakhir" class="form-control"
                value="{{ old('km_terakhir', $kendaraan->km_terakhir ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="status" class="form-label">
                <i class="fas fa-info-circle"></i>
                Status
            </label>
            <select name="status" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="tersedia" {{ old('status', $kendaraan->status ?? '') == 'tersedia' ? 'selected' : '' }}>
                    Tersedia
                </option>
                <option value="diservice" {{ old('status', $kendaraan->status ?? '') == 'diservis' ? 'selected' : '' }}>
                    Diservis
                </option>
                <option value="dipesan" {{ old('status', $kendaraan->status ?? '') == 'dipesan' ? 'selected' : '' }}>
                    Dipesan
                </option>
            </select>
        </div>
        <div class="button-group">
            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i>
                Simpan
            </button>
            <a href="{{ route('admin.kendaraan.index') }}" class="cancel-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </form>
</div>