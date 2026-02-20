<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiPenilaian extends Model
{
    use HasFactory;

    protected $table = 'tbl_akreditasi_penilaian';
    protected $primaryKey = 'id_akreditasi_penilaian';
    public $timestamps = false;

    protected $fillable = [
        'id_akreditasi_kegiatan',
        'id_master_elemen_penilaian',
        'nilai',
        'fakta_analisis',
        'rekomendasi',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Kegiatan Akreditasi
    public function kegiatanAkreditasi()
    {
        return $this->belongsTo(KegiatanAkreditasi::class, 'id_akreditasi_kegiatan', 'id_akreditasi_kegiatan');
    }

    // Relationship dengan Elemen Penilaian
    public function elemenPenilaian()
    {
        return $this->belongsTo(MasterElemenPenilaian::class, 'id_master_elemen_penilaian', 'id_master_elemen_penilaian');
    }
}