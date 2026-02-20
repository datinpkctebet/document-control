<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkreditasiPerbaikan;
use App\Models\AkreditasiPerbaikanKegiatan;
use App\Models\MasterElemenPenilaian;

class PerbaikanController extends Controller
{
    /**
     * Store or update perbaikan
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_master_elemen_penilaian' => 'required|exists:tbl_master_elemen_penilaian,id_master_elemen_penilaian',
            'rencana_perbaikan' => 'required|string',
            'indikator_pencapaian' => 'required|string',
            'sasaran' => 'required|string|max:250',
            'waktu_penyelesaian' => 'required|string|max:250',
            'sumber_dana' => 'required|string|max:250',
            'penanggung_jawab' => 'required|string|max:250',
        ], [
            'id_master_elemen_penilaian.required' => 'Elemen penilaian wajib dipilih',
            'rencana_perbaikan.required' => 'Rencana perbaikan wajib diisi',
            'indikator_pencapaian.required' => 'Indikator pencapaian wajib diisi',
            'sasaran.required' => 'Sasaran wajib diisi',
            'waktu_penyelesaian.required' => 'Waktu penyelesaian wajib diisi',
            'sumber_dana.required' => 'Sumber dana wajib diisi',
            'penanggung_jawab.required' => 'Penanggung jawab wajib diisi',
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

            // Cek apakah sudah ada perbaikan untuk elemen ini
            $perbaikan = AkreditasiPerbaikan::where('id_akreditasi_kegiatan', $kegiatanAktifId)
                ->where('id_master_elemen_penilaian', $request->id_master_elemen_penilaian)
                ->first();

            if ($perbaikan) {
                // Update existing
                $perbaikan->update([
                    'rencana_perbaikan' => $request->rencana_perbaikan,
                    'indikator_pencapaian' => $request->indikator_pencapaian,
                    'sasaran' => $request->sasaran,
                    'waktu_penyelesaian' => $request->waktu_penyelesaian,
                    'sumber_dana' => $request->sumber_dana,
                    'penanggung_jawab' => $request->penanggung_jawab,
                    'updated_time' => now(),
                ]);

                $message = 'Rencana perbaikan berhasil diupdate';
            } else {
                // Create new
                $perbaikan = AkreditasiPerbaikan::create([
                    'id_akreditasi_kegiatan' => $kegiatanAktifId,
                    'id_master_elemen_penilaian' => $request->id_master_elemen_penilaian,
                    'rencana_perbaikan' => $request->rencana_perbaikan,
                    'indikator_pencapaian' => $request->indikator_pencapaian,
                    'sasaran' => $request->sasaran,
                    'waktu_penyelesaian' => $request->waktu_penyelesaian,
                    'sumber_dana' => $request->sumber_dana,
                    'penanggung_jawab' => $request->penanggung_jawab,
                    'created_time' => now(),
                    'updated_time' => now(),
                ]);

                $message = 'Rencana perbaikan berhasil disimpan';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $perbaikan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get perbaikan by elemen
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

            $perbaikan = AkreditasiPerbaikan::where('id_akreditasi_kegiatan', $kegiatanAktifId)
                ->where('id_master_elemen_penilaian', $id_elemen)
                ->first();

            return response()->json([
                'success' => true,
                'data' => $perbaikan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kegiatan perbaikan by perbaikan ID
     */
    public function getKegiatan($id_perbaikan)
    {
        try {
            $kegiatan = AkreditasiPerbaikanKegiatan::with(['perbaikan'])
                ->where('id_akreditasi_perbaikan', $id_perbaikan)
                ->orderBy('periode_pelaporan')
                ->orderBy('tahun_pelaporan')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $kegiatan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store kegiatan perbaikan per triwulan
     */
    public function storeKegiatan(Request $request)
    {
        $request->validate([
            'id_akreditasi_perbaikan' => 'required|exists:tbl_akreditasi_perbaikan,id_akreditasi_perbaikan',
            'id_master_elemen_penilaian' => 'required|exists:tbl_master_elemen_penilaian,id_master_elemen_penilaian',
            'tahun_pelaporan' => 'required|string|max:250',
            'periode_pelaporan' => 'required|in:1,2,3,4',
            'kegiatan' => 'required|string',
            'status_kegiatan' => 'required|in:belum,sudah',
            'link_bukti' => 'nullable|string',
        ], [
            'id_akreditasi_perbaikan.required' => 'ID perbaikan wajib diisi',
            'periode_pelaporan.required' => 'Periode pelaporan (triwulan) wajib dipilih',
            'periode_pelaporan.in' => 'Periode harus 1, 2, 3, atau 4',
            'kegiatan.required' => 'Kegiatan wajib diisi',
            'status_kegiatan.required' => 'Status kegiatan wajib dipilih',
            'status_kegiatan.in' => 'Status harus "belum" atau "sudah"',
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

            // Create kegiatan perbaikan
            $kegiatanPerbaikan = AkreditasiPerbaikanKegiatan::create([
                'id_akreditasi_kegiatan' => $kegiatanAktifId,
                'id_akreditasi_perbaikan' => $request->id_akreditasi_perbaikan,
                'id_master_elemen_penilaian' => $request->id_master_elemen_penilaian,
                'tahun_pelaporan' => $request->tahun_pelaporan,
                'periode_pelaporan' => $request->periode_pelaporan,
                'kegiatan' => $request->kegiatan,
                'status_kegiatan' => $request->status_kegiatan,
                'link_bukti' => $request->link_bukti ?? '',
                'created_time' => now(),
                'updated_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kegiatan perbaikan berhasil ditambahkan',
                'data' => $kegiatanPerbaikan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update kegiatan perbaikan
     */
    public function updateKegiatan(Request $request, $id)
    {
        $request->validate([
            'tahun_pelaporan' => 'required|string|max:250',
            'periode_pelaporan' => 'required|in:1,2,3,4',
            'kegiatan' => 'required|string',
            'status_kegiatan' => 'required|in:belum,sudah',
            'link_bukti' => 'nullable|string',
        ]);

        try {
            $kegiatanPerbaikan = AkreditasiPerbaikanKegiatan::findOrFail($id);

            $kegiatanPerbaikan->update([
                'tahun_pelaporan' => $request->tahun_pelaporan,
                'periode_pelaporan' => $request->periode_pelaporan,
                'kegiatan' => $request->kegiatan,
                'status_kegiatan' => $request->status_kegiatan,
                'link_bukti' => $request->link_bukti ?? '',
                'updated_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kegiatan perbaikan berhasil diupdate',
                'data' => $kegiatanPerbaikan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete kegiatan perbaikan
     */
    public function deleteKegiatan($id)
    {
        try {
            $kegiatanPerbaikan = AkreditasiPerbaikanKegiatan::findOrFail($id);
            $kegiatanPerbaikan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kegiatan perbaikan berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}