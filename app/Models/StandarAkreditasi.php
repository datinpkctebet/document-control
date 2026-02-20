<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarAkreditasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_standar_akreditasi';
    protected $primaryKey = 'id_standar_akreditasi';
    public $timestamps = false;

    protected $fillable = [
        'id_akreditasi_kegiatan',
        'id_elemen_penilaian',
        'nilai',
        'fakta_analisis',
        'rekomendasi',
        'tindakan_perbaikan',
        'waktu',
        'pic',
        'indikator_pencapaian',
        'sasaran',
        'sumber_dana',
        'status_petugas',
        'dokumen_perbaikan',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Elemen Penilaian
    public function elemenPenilaian()
    {
        return $this->belongsTo(MasterElemenPenilaian::class, 'id_elemen_penilaian', 'id_master_elemen_penilaian');
    }

    // Relationship dengan Kegiatan Akreditasi
    public function kegiatanAkreditasi()
    {
        return $this->belongsTo(KegiatanAkreditasi::class, 'id_akreditasi_kegiatan', 'id_akreditasi_kegiatan');
    }
}