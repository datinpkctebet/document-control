<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterElemenPenilaian;
use App\Models\AkreditasiDokumen;
use App\Models\KegiatanAkreditasi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get filter tahun dari request atau default ke yang terakhir
        $filterTahun = $request->get('tahun');
        
        // Get all kegiatan akreditasi untuk dropdown
        $listKegiatanAkreditasi = KegiatanAkreditasi::where('delete_at', 0)
            ->orderBy('created_time', 'desc')
            ->get();
        
        // Get kegiatan akreditasi berdasarkan filter atau default ke terakhir
        if ($filterTahun) {
            $kegiatanAktif = KegiatanAkreditasi::where('delete_at', 0)
                ->where('id_akreditasi_kegiatan', $filterTahun)
                ->first();
        } else {
            $kegiatanAktif = KegiatanAkreditasi::where('delete_at', 0)
                ->orderBy('created_time', 'desc')
                ->first();
        }
        
        // Simpan ke session
        if ($kegiatanAktif) {
            session(['kegiatan_aktif_id' => $kegiatanAktif->id_akreditasi_kegiatan]);
        }

        // Count statistics berdasarkan kegiatan akreditasi
        $totalElemenPenilaian = MasterElemenPenilaian::where('delete_at', 0)->count();
        
        // Count dokumen berdasarkan kegiatan aktif
        $totalDokumenQuery = AkreditasiDokumen::where('delete_at', 0);
        if ($kegiatanAktif) {
            $totalDokumenQuery->where('id_akreditasi_kegiatan', $kegiatanAktif->id_akreditasi_kegiatan);
        }
        $totalDokumen = $totalDokumenQuery->count();
        
        $totalUsers = User::where('delete_at', 0)->count();

        return view('pages.dashboard', compact(
            'user',
            'totalElemenPenilaian',
            'totalDokumen',
            'totalUsers',
            'listKegiatanAkreditasi',
            'kegiatanAktif'
        ));
    }
}