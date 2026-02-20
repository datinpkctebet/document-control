<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanAkreditasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_kegiatan_akreditasi';
    protected $primaryKey = 'id_akreditasi_kegiatan';
    public $timestamps = false;

    protected $fillable = [
        'versi',
        'nama_kegiatan',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    public function dokumen()
    {
        return $this->hasMany(AkreditasiDokumen::class, 'id_akreditasi_kegiatan', 'id_akreditasi_kegiatan');
    }
}