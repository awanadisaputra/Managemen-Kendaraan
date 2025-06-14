<?php

namespace App\Exports;

use App\Models\PersetujuanPemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPemesananExport implements FromCollection, WithHeadings
{
    protected $tingkatPersetujuan;

    public function __construct($tingkatPersetujuan)
    {
        $this->tingkatPersetujuan = $tingkatPersetujuan;
    }

    /**
     * Ambil data untuk di-export
     */
    public function collection()
    {
        return PersetujuanPemesanan::with([
            'pemesanan.user',
            'pemesanan.kendaraan',
            'pemesanan.supir'
        ])
            ->when(!is_null($this->tingkatPersetujuan), function ($query) {
                $query->where('tingkat_persetujuan', $this->tingkatPersetujuan);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'ID' => $item->id,
                    'Nama Pemesan' => $item->pemesanan->user->nama ?? '-',
                    'Nama Supir' => $item->pemesanan->supir->nama ?? '-', // ✅ pakai relasi
                    'No Plat' => $item->pemesanan->kendaraan->nomor_plat ?? '-',
                    'Status' => ucfirst($item->status),
                    'Tanggal Mulai' => optional($item->pemesanan->tanggal_mulai)->format('d-m-Y H:i'),
                    'Tanggal Persetujuan' => optional($item->tanggal_persetujuan)->format('d-m-Y H:i'),
                ];
            });
    }


    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pemesan',
            'Nama Supir',
            'No Plat',
            'Status',
            'Tanggal Mulai',
            'Tanggal Persetujuan',
        ];
    }
}
