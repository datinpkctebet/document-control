<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\MasterElemenPenilaian;
use App\Models\MasterBab;
use App\Models\MasterStandar;
use App\Models\MasterKriteria;
use App\Models\AkreditasiDokumen;
use App\Models\StandarAkreditasi;
use App\Models\KegiatanAkreditasi;
use App\Models\JenisDokumenStandar;
use App\Models\DokumenInternal;
use App\Models\DokumenEksternal;
use App\Models\JenisDokumenUnit;
use App\Models\Pokja;
use App\Models\Pelayanan;

class DokumenController extends Controller
{
    // ======================================================================
    // Fungsi untuk dokumen internal
    /**
     * Display a listing of the documents
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $filterBab = $request->get('bab');
        $filterStandar = $request->get('standar');
        $filterKriteria = $request->get('kriteria');
        $filterTahun = $request->get('tahun');
        $search = $request->get('search');

        // Get master data for filters
        $listBab = MasterBab::where('delete_at', 0)->orderBy('id_master_bab')->get();
        $listStandar = MasterStandar::where('delete_at', 0)->orderBy('master_standar')->get();
        $listKriteria = MasterKriteria::where('delete_at', 0)->orderBy('master_kriteria')->get();

        // Get all kegiatan akreditasi untuk dropdown tahun
        $listKegiatanAkreditasi = KegiatanAkreditasi::where('delete_at', 0)
            ->orderBy('created_time', 'desc')
            ->get();

        // Get kegiatan akreditasi berdasarkan filter tahun atau default ke yang terakhir
        if ($filterTahun) {
            $kegiatanAktif = KegiatanAkreditasi::where('delete_at', 0)
                ->where('id_akreditasi_kegiatan', $filterTahun)
                ->first();
        } else {
            $kegiatanAktif = KegiatanAkreditasi::where('delete_at', 0)
                ->orderBy('created_time', 'desc')
                ->first();
        }
        
        // Simpan ID kegiatan aktif ke session untuk digunakan di operasi lain
        if ($kegiatanAktif) {
            session(['kegiatan_aktif_id' => $kegiatanAktif->id_akreditasi_kegiatan]);
        }

        // Query elemen penilaian with filters
        $query = MasterElemenPenilaian::with(['bab', 'standar', 'kriteria', 
            'dokumen' => function($q) use ($kegiatanAktif) {
                if ($kegiatanAktif) {
                    $q->where('id_akreditasi_kegiatan', $kegiatanAktif->id_akreditasi_kegiatan);
                }
            },
            'standarAkreditasi' => function($q) use ($kegiatanAktif) {
                if ($kegiatanAktif) {
                    $q->where('id_akreditasi_kegiatan', $kegiatanAktif->id_akreditasi_kegiatan);
                }
            },
            'penilaian' => function($q) use ($kegiatanAktif) {
                if ($kegiatanAktif) {
                    $q->where('id_akreditasi_kegiatan', $kegiatanAktif->id_akreditasi_kegiatan);
                }
            },
            'perbaikan' => function($q) use ($kegiatanAktif) {
                if ($kegiatanAktif) {
                    $q->where('id_akreditasi_kegiatan', $kegiatanAktif->id_akreditasi_kegiatan);
                }
            }
        ])
        ->where('delete_at', 0);

        if ($filterBab) {
            $query->where('id_master_bab', $filterBab);
        }

        if ($filterStandar) {
            $query->where('id_standar', $filterStandar);
        }

        if ($filterKriteria) {
            $query->where('id_kriteria', $filterKriteria);
        }

        if ($search) {
            $query->where('elemen_penilaian', 'like', '%' . $search . '%');
        }

        $elemenPenilaian = $query->orderBy('sort')->get();

        return view('pages.documents.index', compact(
            'elemenPenilaian',
            'listBab',
            'listStandar',
            'listKriteria',
            'listKegiatanAkreditasi',
            'kegiatanAktif'
        ));
    }

    /**
     * Display a listing of the document internal
     */
    public function indexInternal(Request $request)
    {
        // Get filter parameters
        $filterJenisDokumen = $request->get('jenisDokumen');
        $filterKlaster = $request->get('klaster');
        $filterPelayanan = $request->get('pelayanan');
        $filterTahun = $request->get('tahun');
        $search = $request->get('search');

        // Get master data for filters
        $listTahun = DokumenInternal::where('delete_at', 0)->where('tahun_dokumen', '>=', 2024)->where('id_pelayanan', '!=', 0)->select('tahun_dokumen as tahun')->distinct()->orderBy('tahun_dokumen', 'desc')->get();
        $listJenisDokumen = JenisDokumenUnit::where('delete_at', 0)->orderBy('jenis_dokumen')->get();
        $listKlaster = Pokja::where('delete_at', 0)->orderBy('pokja')->get();
        $listPelayanan = Pelayanan::where('delete_at', 0)->where('id_pokja', '>=', 5)->orderBy('jenis_pelayanan')->get();

        // Query dokumen internal with filters
        $query = DokumenInternal::with(['jenisDokumenUnit', 'pokja', 'pelayanan'])
        ->where('delete_at', 0)->where('tahun_dokumen', '>=', 2024)->where('id_pelayanan', '!=', 0); 

        if ($filterJenisDokumen) {
            $query->where('id_jenis_dokumen_unit', $filterJenisDokumen);
        }

        if ($filterKlaster) {
            $query->where('id_pokja', $filterKlaster);
        }

        if ($filterTahun) {
            $query->where('tahun_dokumen', $filterTahun);
        }

        if ($filterPelayanan) {
            $query->where('id_pelayanan', $filterPelayanan);
        }

        if ($search) {
            $query->where('nama_dokumen', 'like', '%' . $search . '%');
        }

        $dokumenInternal = $query->orderBy('id_dokumen_internal_unit', 'desc')->get();

        return view('pages.documents.indexInternal', compact(
            'dokumenInternal',
            'listTahun',
            'listJenisDokumen',
            'listKlaster',
            'listPelayanan'
        ));
    }

    /**
     * Get list of documents for an element (AJAX)
     */
    public function getDokumenInternal($id)
    {
        $dokumen = DokumenInternal::where('id_dokumen_internal_unit', $id)
            ->where('delete_at', 0)
            ->orderBy('created_time', 'desc')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $dokumen
        ]);
    }

    /**
     * Store a newly created document
     */
    public function storeInternal(Request $request)
    {
        $request->validate([
            'id_pokja' => 'required|exists:tbl_pokja,id_pokja',
            'id_pelayanan' => 'required|exists:tbl_unit_pelayanan,id_pelayanan',
            'id_jenis_dokumen_unit' => 'required|exists:tbl_jenis_dokumen_unit,id_jenis_dokumen_unit',
            'no_dokumen' => 'nullable|string',
            'nama_dokumen' => 'required|string|max:250',
            'file_dokumen' => 'required|file|mimes:pdf|max:10240', // 10MB
        ], [
            'id_pokja.required' => 'Klaster wajib dipilih',
            'id_pelayanan.required' => 'Pelayanan wajib dipilih',
            'id_jenis_dokumen_unit.required' => 'Jenis dokumen wajib dipilih',
            'no_dokumen.required' => 'Nomor dokumen wajib diisi',
            'nama_dokumen.required' => 'Nama dokumen wajib diisi',
            'file_dokumen.required' => 'File dokumen wajib diupload',
            'file_dokumen.mimes' => 'File harus berformat: pdf',
            'file_dokumen.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                
                // Create filename with timestamp and hash
                $timestamp = now()->format('d-m-Y-H_i_s');
                $hash = md5($originalName . $timestamp);
                $fileName = slug($originalName) . '-' . $timestamp . '-' . $hash . '.' . $extension;
                
                // Store file
                $file->move(public_path('storage/uploads/internal_unit'), $fileName);
            }

            // Create document record
            $dokumen = DokumenInternal::create([
                'id_pokja' => $request->id_pokja,
                'id_pelayanan' => $request->id_pelayanan,
                'id_jenis_dokumen_unit' => $request->id_jenis_dokumen_unit,
                'tahun_dokumen' => $request->tahun_dokumen,
                'no_dokumen' => $request->no_dokumen,
                'nama_dokumen' => $request->nama_dokumen,
                'file_dokumen' => $fileName,
                'delete_at' => 0,
                'created_time' => now(),
                'updated_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload',
                'data' => $dokumen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified document
     */
    public function updateInternal(Request $request, $id)
    {
        $request->validate([
            'edit_id_pokja' => 'required|exists:tbl_pokja,id_pokja',
            'edit_id_pelayanan' => 'required|exists:tbl_unit_pelayanan,id_pelayanan',
            'edit_id_jenis_dokumen_unit' => 'required|exists:tbl_jenis_dokumen_unit,id_jenis_dokumen_unit',
            'edit_no_dokumen' => 'required|string',
            'edit_nama_dokumen' => 'required|string|max:250',
            'edit_file_dokumen' => 'nullable|file|mimes:pdf|max:10240', // 10MB
        ], [
            'edit_id_pokja.required' => 'Klaster wajib dipilih',
            'edit_id_pelayanan.required' => 'Pelayanan wajib dipilih',
            'edit_id_jenis_dokumen_unit.required' => 'Jenis dokumen wajib dipilih',
            'edit_no_dokumen.required' => 'Nomor dokumen wajib diisi',
            'edit_nama_dokumen.required' => 'Nama dokumen wajib diisi',
            'edit_file_dokumen.mimes' => 'File harus berformat: pdf',
            'edit_file_dokumen.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $dokumen = DokumenInternal::findOrFail($id);

            // Handle file upload if new file provided
            if ($request->hasFile('edit_file_dokumen')) {
                $replace = str_replace(':', '_', $dokumen->file_dokumen);
                $filePath = public_path('storage/uploads/internal_unit/' . $replace);

                // Delete old file
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $file = $request->file('edit_file_dokumen');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                
                // Create filename with timestamp and hash
                $timestamp = now()->format('d-m-Y-H_i_s');
                $hash = md5($originalName . $timestamp);
                $fileName = slug($originalName) . '-' . $timestamp . '-' . $hash . '.' . $extension;
                
                // Store file
                $file->move(public_path('storage/uploads/internal_unit'), $fileName);

                $dokumen->file_dokumen = $fileName;
            }

            // Update document record
            $dokumen->update([
                'id_pokja' => $request->edit_id_pokja,
                'id_pelayanan' => $request->edit_id_pelayanan,
                'id_jenis_dokumen_unit' => $request->edit_id_jenis_dokumen_unit,
                'tahun_dokumen' => $request->edit_tahun_dokumen,
                'no_dokumen' => $request->edit_no_dokumen,
                'nama_dokumen' => $request->edit_nama_dokumen,
                'delete_at' => 0,
                'updated_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupdate',
                'data' => $dokumen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified document
     */
    public function destroyInternal($id)
    {
        try {
            $dokumen = DokumenInternal::findOrFail($id);

            // Soft delete
            $dokumen->update([
                'delete_at' => 1,
                'updated_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ======================================================================
    // Fungsi untuk dokumen eksternal
    /**
     * Display a listing of the document eksternal
     */
    public function indexEksternal(Request $request)
    {
        // Get filter parameters
        $filterJenisDokumen = $request->get('jenisDokumen');
        $filterKlaster = $request->get('klaster');
        $filterPelayanan = $request->get('pelayanan');
        $filterTahun = $request->get('tahun');
        $search = $request->get('search');

        // Get master data for filters
        $listTahun = DokumenEksternal::where('delete_at', 0)->where('tahun_dokumen', '>=', 2024)->where('id_pelayanan', '!=', 0)->select('tahun_dokumen as tahun')->distinct()->orderBy('tahun_dokumen', 'desc')->get();
        $listJenisDokumen = JenisDokumenUnit::where('delete_at', 0)->orderBy('jenis_dokumen')->get();
        $listKlaster = Pokja::where('delete_at', 0)->orderBy('pokja')->get();
        $listPelayanan = Pelayanan::where('delete_at', 0)->where('id_pokja', '>=', 5)->orderBy('jenis_pelayanan')->get();

        // Query dokumen eksternal with filters
        $query = DokumenEksternal::with(['jenisDokumenUnit', 'pokja', 'pelayanan'])
        ->where('delete_at', 0)->where('tahun_dokumen', '>=', 2024)->where('id_pelayanan', '!=', 0); 

        if ($filterJenisDokumen) {
            $query->where('id_jenis_dokumen_unit', $filterJenisDokumen);
        }

        if ($filterKlaster) {
            $query->where('id_pokja', $filterKlaster);
        }

        if ($filterTahun) {
            $query->where('tahun_dokumen', $filterTahun);
        }

        if ($filterPelayanan) {
            $query->where('id_pelayanan', $filterPelayanan);
        }

        if ($search) {
            $query->where('nama_dokumen', 'like', '%' . $search . '%');
        }

        $dokumenEksternal = $query->orderBy('id_dokumen_internal_unit', 'desc')->get();

        return view('pages.documents.indexEksternal', compact(
            'dokumenEksternal',
            'listTahun',
            'listJenisDokumen',
            'listKlaster',
            'listPelayanan'
        ));
    }

    /**
     * Get list of documents for an element (AJAX)
     */
    public function getDokumenEksternal($id)
    {
        $dokumen = DokumenEksternal::where('id_dokumen_internal_unit', $id)
            ->where('delete_at', 0)
            ->orderBy('created_time', 'desc')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $dokumen
        ]);
    }

    /**
     * Store a newly created document
     */
    public function storeEksternal(Request $request)
    {
        $request->validate([
            'id_pokja' => 'required|exists:tbl_pokja,id_pokja',
            'id_pelayanan' => 'required|exists:tbl_unit_pelayanan,id_pelayanan',
            'id_jenis_dokumen_unit' => 'required|exists:tbl_jenis_dokumen_unit,id_jenis_dokumen_unit',
            'no_dokumen' => 'nullable|string',
            'nama_dokumen' => 'required|string|max:250',
            'file_dokumen' => 'required|file|mimes:pdf|max:10240', // 10MB
        ], [
            'id_pokja.required' => 'Klaster wajib dipilih',
            'id_pelayanan.required' => 'Pelayanan wajib dipilih',
            'id_jenis_dokumen_unit.required' => 'Jenis dokumen wajib dipilih',
            'no_dokumen.required' => 'Nomor dokumen wajib diisi',
            'nama_dokumen.required' => 'Nama dokumen wajib diisi',
            'file_dokumen.required' => 'File dokumen wajib diupload',
            'file_dokumen.mimes' => 'File harus berformat: pdf',
            'file_dokumen.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                
                // Create filename with timestamp and hash
                $timestamp = now()->format('d-m-Y-H_i_s');
                $hash = md5($originalName . $timestamp);
                $fileName = slug($originalName) . '-' . $timestamp . '-' . $hash . '.' . $extension;
                
                // Store file
                $file->move(public_path('uploads/internal_unit'), $fileName);
            }

            // Create document record
            $dokumen = DokumenInternal::create([
                'id_pokja' => $request->id_pokja,
                'id_pelayanan' => $request->id_pelayanan,
                'id_jenis_dokumen_unit' => $request->id_jenis_dokumen_unit,
                'tahun_dokumen' => $request->tahun_dokumen,
                'no_dokumen' => $request->no_dokumen,
                'nama_dokumen' => $request->nama_dokumen,
                'file_dokumen' => $fileName,
                'delete_at' => 0,
                'created_time' => now(),
                'updated_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload',
                'data' => $dokumen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified document
     */
    public function updateEksternal(Request $request, $id)
    {
        $request->validate([
            'edit_id_pokja' => 'required|exists:tbl_pokja,id_pokja',
            'edit_id_pelayanan' => 'required|exists:tbl_unit_pelayanan,id_pelayanan',
            'edit_id_jenis_dokumen_unit' => 'required|exists:tbl_jenis_dokumen_unit,id_jenis_dokumen_unit',
            'edit_no_dokumen' => 'required|string',
            'edit_nama_dokumen' => 'required|string|max:250',
            'edit_file_dokumen' => 'nullable|file|mimes:pdf|max:10240', // 10MB
        ], [
            'edit_id_pokja.required' => 'Klaster wajib dipilih',
            'edit_id_pelayanan.required' => 'Pelayanan wajib dipilih',
            'edit_id_jenis_dokumen_unit.required' => 'Jenis dokumen wajib dipilih',
            'edit_no_dokumen.required' => 'Nomor dokumen wajib diisi',
            'edit_nama_dokumen.required' => 'Nama dokumen wajib diisi',
            'edit_file_dokumen.mimes' => 'File harus berformat: pdf',
            'edit_file_dokumen.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $dokumen = DokumenEksternal::findOrFail($id);

            // Handle file upload if new file provided
            if ($request->hasFile('edit_file_dokumen')) {
                $filePath = public_path('uploads/eksternal/' . $replace);
                $filePath = public_path('uploads/internal_unit/' . $replace);

                // Delete old file
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $file = $request->file('edit_file_dokumen');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                
                // Create filename with timestamp and hash
                $timestamp = now()->format('d-m-Y-H_i_s');
                $hash = md5($originalName . $timestamp);
                $fileName = slug($originalName) . '-' . $timestamp . '-' . $hash . '.' . $extension;
                
                // Store file
                $file->move(public_path('uploads/internal_unit'), $fileName);

                $dokumen->file_dokumen = $fileName;
            }

            // Update document record
            $dokumen->update([
                'id_pokja' => $request->edit_id_pokja,
                'id_pelayanan' => $request->edit_id_pelayanan,
                'id_jenis_dokumen_unit' => $request->edit_id_jenis_dokumen_unit,
                'tahun_dokumen' => $request->edit_tahun_dokumen,
                'no_dokumen' => $request->edit_no_dokumen,
                'nama_dokumen' => $request->edit_nama_dokumen,
                'delete_at' => 0,
                'updated_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupdate',
                'data' => $dokumen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified document
     */
    public function destroyEksternal($id)
    {
        try {
            $dokumen = DokumenEksternal::findOrFail($id);

            // Soft delete
            $dokumen->update([
                'delete_at' => 1,
                'updated_time' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get jenis dokumen (AJAX)
     */
    public function getJenisDokumen()
    {
        $jenisDokumen = JenisDokumenUnit::where('delete_at', 0)->get();

        return response()->json([
            'success' => true,
            'data' => $jenisDokumen
        ]);
    }

    /**
    * Get klaster (AJAX)
    */
    public function getKlaster()
    {
        $klaster = Pokja::where('delete_at', 0)->get();

        return response()->json([
            'success' => true,
            'data' => $klaster
        ]);
    }

    /**
    * Get pelayanan (AJAX)
    */
    public function getPelayanan()
    {
        $pelayanan = Pelayanan::where('delete_at', 0)->where('id_pokja', '>=', 5)->orderBy('jenis_pelayanan')->get();

        return response()->json([
            'success' => true,
            'data' => $pelayanan
        ]);
    }

    /**
    * Get tahun (AJAX)
    */
    public function getTahunDokumen()
    {
        $tahunDokumen = [
            ['tahun_dokumen' => 2023],
            ['tahun_dokumen' => 2024],
            ['tahun_dokumen' => 2025],
            ['tahun_dokumen' => 2026],
            ['tahun_dokumen' => 2027],
            ['tahun_dokumen' => 2028],
            ['tahun_dokumen' => 2029],
            ['tahun_dokumen' => 2030],
            ['tahun_dokumen' => 2031],
            ['tahun_dokumen' => 2032],
            ['tahun_dokumen' => 2033],
            ['tahun_dokumen' => 2034],
            ['tahun_dokumen' => 2035],
        ];

        return response()->json([
            'success' => true,
            'data' => $tahunDokumen
        ]);
    }
}

// Helper function to create slug
if (!function_exists('slug')) {
    function slug($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9-]/', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }
}