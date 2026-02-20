<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiPerbaikanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'tbl_akreditasi_perbaikan_kegiatan';
    protected $primaryKey = 'id_akreditasi_perbaikan_kegiatan';
    public $timestamps = false;

    protected $fillable = [
        'id_akreditasi_kegiatan',
        'id_akreditasi_perbaikan',
        'id_master_elemen_penilaian',
        'tahun_pelaporan',
        'kegiatan',
        'status_kegiatan',
        'periode_pelaporan',
        'link_bukti',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Perbaikan (Many to One)
    public function perbaikan()
    {
        return $this->belongsTo(AkreditasiPerbaikan::class, 'id_akreditasi_perbaikan', 'id_akreditasi_perbaikan');
    }

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