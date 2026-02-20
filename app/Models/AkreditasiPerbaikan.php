<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkreditasiPerbaikan extends Model
{
    use HasFactory;

    protected $table = 'tbl_akreditasi_perbaikan';
    protected $primaryKey = 'id_akreditasi_perbaikan';
    public $timestamps = false;

    protected $fillable = [
        'id_akreditasi_kegiatan',
        'id_master_elemen_penilaian',
        'rencana_perbaikan',
        'indikator_pencapaian',
        'sasaran',
        'waktu_penyelesaian',
        'sumber_dana',
        'penanggung_jawab',
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

    // Relationship dengan Kegiatan Perbaikan (One to Many)
    public function kegiatanPerbaikan()
    {
        return $this->hasMany(AkreditasiPerbaikanKegiatan::class, 'id_akreditasi_perbaikan', 'id_akreditasi_perbaikan');
    }
}