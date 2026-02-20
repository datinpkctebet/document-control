<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkreditasiPenilaian;
use App\Models\MasterElemenPenilaian;

class PenilaianController extends Controller
{
    /**
     * Store or update penilaian
     */
    public function store(Request $request)
    {
        // Validasi
        $rules = [
            'id_master_elemen_penilaian' => 'required|exists:tbl_master_elemen_penilaian,id_master_elemen_penilaian',
            'nilai' => 'required|in:0,5,10',
            'fakta_analisis' => 'required|string',
        ];

        // Jika nilai 0 atau 5, rekomendasi wajib diisi
        if (in_array($request->nilai, ['0', '5'])) {
            $rules['rekomendasi'] = 'required|string';
        } else {
            $rules['rekomendasi'] = 'nullable|string';
        }

        $request->validate($rules, [
            'id_master_elemen_penilaian.required' => 'Elemen penilaian wajib dipilih',
            'nilai.required' => 'Nilai wajib dipilih',
            'nilai.in' => 'Nilai harus 0, 5, atau 10',
            'fakta_analisis.required' => 'Fakta & analisis wajib diisi',
            'rekomendasi.required' => 'Rekomendasi wajib diisi untuk nilai 0 atau 5',
        ]);

        try {
            // Ambil kegiatan aktif dari session
            $kegiatanAktifId = session('kegiatan_aktif_id');
            
            if (!$kegiatanAktifId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada kegiatan akreditasi yang aktif'
                ], 400);
            }

            // Cek apakah sudah ada penilaian untuk elemen ini
            $penilaian = AkreditasiPenilaian::where('id_akreditasi_kegiatan', $kegiatanAktifId)
                ->where('id_master_elemen_penilaian', $request->id_master_elemen_penilaian)
                ->first();

            if ($penilaian) {
                // Update existing
                $penilaian->update([
                    'nilai' => $request->nilai,
                    'fakta_analisis' => $request->fakta_analisis,
                    'rekomendasi' => $request->rekomendasi ?? '',
                    'updated_time' => now(),
                ]);

                $message = 'Penilaian berhasil diupdate';
            } else {
                // Create new
                $penilaian = AkreditasiPenilaian::create([
                    'id_akreditasi_kegiatan' => $kegiatanAktifId,
                    'id_master_elemen_penilaian' => $request->id_master_elemen_penilaian,
                    'nilai' => $request->nilai,
                    'fakta_analisis' => $request->fakta_analisis,
                    'rekomendasi' => $request->rekomendasi ?? '',
                    'created_time' => now(),
                    'updated_time' => now(),
                ]);

                $message = 'Penilaian berhasil disimpan';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $penilaian
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get penilaian by elemen
     */
    public function get($id_elemen)
    {
        try {
            // Ambil kegiatan aktif dari session
            $kegiatanAktifId = session('kegiatan_aktif_id');
            
            if (!$kegiatanAktifId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada kegiatan akreditasi yang aktif'
                ], 400);
            }

            $penilaian = AkreditasiPenilaian::where('id_akreditasi_kegiatan', $kegiatanAktifId)
                ->where('id_master_elemen_penilaian', $id_elemen)
                ->first();

            return response()->json([
                'success' => true,
                'data' => $penilaian
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}