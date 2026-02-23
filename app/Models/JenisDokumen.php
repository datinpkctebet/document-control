<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'tbl_jenis_dokumen';
    protected $primaryKey = 'id_jenis_dokumen';
    public $timestamps = false;

    protected $fillable = [
        'jenis_dokumen',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Dokumen Eksternal
    public function dokumenEksternal()
    {
        return $this->hasMany(DokumenEksternal::class, 'id_jenis_dokumen', 'id_jenis_dokumen');
    }
}