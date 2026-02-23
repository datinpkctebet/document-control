<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DokumenInternal;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Count dokumen internal with specific conditions
        $totalDokumenQuery = DokumenInternal::where('delete_at', 0)->where('tahun_dokumen', '>=', 2024)->where('id_pelayanan', '!=', 0);
        $totalDokumen = $totalDokumenQuery->count();
        
        $totalUsers = User::where('delete_at', 0)->count();

        return view('pages.dashboard', compact(
            'user',
            'totalDokumen',
            'totalUsers',
        ));
    }
}