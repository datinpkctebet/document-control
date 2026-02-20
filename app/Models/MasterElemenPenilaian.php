<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterElemenPenilaian extends Model
{
    use HasFactory;

    protected $table = 'tbl_master_elemen_penilaian';
    protected $primaryKey = 'id_master_elemen_penilaian';
    public $timestamps = false;

    protected $fillable = [
        'id_master_bab',
        'id_standar',
        'id_kriteria',
        'elemen_penilaian',
        'r_penilaian',
        'd_penilaian',
        'sort',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Bab
    public function bab()
    {
        return $this->belongsTo(MasterBab::class, 'id_master_bab', 'id_master_bab');
    }

    // Relationship dengan Standar
    public function standar()
    {
        return $this->belongsTo(MasterStandar::class, 'id_standar', 'id_master_standar');
    }

    // Relationship dengan Kriteria
    public function kriteria()
    {
        return $this->belongsTo(MasterKriteria::class, 'id_kriteria', 'id_master_kriteria');
    }

    // Relationship dengan Dokumen
    public function dokumen()
    {
        return $this->hasMany(AkreditasiDokumen::class, 'id_master_elemen_penilaian', 'id_master_elemen_penilaian');
    }

    // Relationship dengan Standar Akreditasi
    public function standarAkreditasi()
    {
        return $this->hasMany(StandarAkreditasi::class, 'id_elemen_penilaian', 'id_master_elemen_penilaian');
    }

    // Relationship dengan Penilaian
    public function penilaian()
    {
        return $this->hasMany(AkreditasiPenilaian::class, 'id_master_elemen_penilaian', 'id_master_elemen_penilaian');
    }

    // Relationship dengan Perbaikan
    public function perbaikan()
    {
        return $this->hasMany(AkreditasiPerbaikan::class, 'id_master_elemen_penilaian', 'id_master_elemen_penilaian');
    }
}