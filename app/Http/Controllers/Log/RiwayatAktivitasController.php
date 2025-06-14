<?php

namespace App\Http\Controllers\Log;

use Illuminate\Http\Request;
use App\Models\RiwayatAktivitas;
use App\Http\Controllers\Controller;

class RiwayatAktivitasController extends Controller
{
    public function index()
    {
        $riwayatAktivitas = RiwayatAktivitas::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.aktivitas', compact('riwayatAktivitas'));
    }
}
