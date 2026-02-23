<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DokumenInternal;
use App\Models\DokumenEksternal;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Count dokumen internal with specific conditions
        $totalDokumenQuery = DokumenInternal::where('delete_at', 0)->where('tahun_dokumen', '>=', 2024)->where('id_pelayanan', '!=', 0);
        $totalDokumenInternal = $totalDokumenQuery->count();
        
        // Count dokumen eksternal with specific conditions
        $totalDokumenEksternalQuery = DokumenEksternal::where('delete_at', 0);
        $totalDokumenEksternal = $totalDokumenEksternalQuery->count();
        
        $totalUsers = User::where('delete_at', 0)->count();

        return view('pages.dashboard', compact(
            'user',
            'totalDokumenInternal',
            'totalDokumenEksternal',
            'totalUsers',
        ));
    }
}