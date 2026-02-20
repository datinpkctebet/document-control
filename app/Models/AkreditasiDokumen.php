<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiDokumen extends Model
{
    use HasFactory;

    protected $table = 'tbl_akreditasi_dokumen';
    protected $primaryKey = 'id_akreditasi_dokumen';
    public $timestamps = false;

    protected $fillable = [
        'id_akreditasi_kegiatan',
        'id_master_elemen_penilaian',
        'id_jenis_dokumen',
        'nama_dokumen',
        'keterangan_dokumen',
        'file_dokumen',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Elemen Penilaian
    public function elemenPenilaian()
    {
        return $this->belongsTo(MasterElemenPenilaian::class, 'id_master_elemen_penilaian', 'id_master_elemen_penilaian');
    }

    // Relationship dengan Kegiatan Akreditasi
    public function kegiatanAkreditasi()
    {
        return $this->belongsTo(KegiatanAkreditasi::class, 'id_akreditasi_kegiatan', 'id_akreditasi_kegiatan');
    }

    // Relationship dengan Jenis Dokumen
    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumenStandar::class, 'id_jenis_dokumen', 'id_jenis_dokumen');
    }
}