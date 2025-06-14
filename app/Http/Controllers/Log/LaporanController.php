<?php

namespace App\Http\Controllers\Log;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPemesananExport;

class LaporanController extends Controller
{
    public function exportLaporan()
    {
        $user = auth()->user();

        // Tentukan tingkat persetujuan sesuai peran
        $tingkatPersetujuan = null;
        if ($user->peran == 'supervisor') {
            $tingkatPersetujuan = 1;
        } elseif ($user->peran == 'manager') {
            $tingkatPersetujuan = 2;
        } elseif ($user->peran == 'admin') {
            $tingkatPersetujuan = 1 | 2;
        }

        $fileName = 'laporan_pemesanan_' . $user->peran . '_' . date('Ymd_His') . '.xlsx';

        return Excel::download(new LaporanPemesananExport($tingkatPersetujuan), $fileName);
    }
}
