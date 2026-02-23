<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenEksternal extends Model
{
    use HasFactory;

    protected $table = 'tbl_dokumen_external';
    protected $primaryKey = 'id_dokumen_external';
    public $timestamps = false;

    protected $fillable = [
        'id_jenis_dokumen',
        'id_pokja',
        'nama_dokumen',
        'no_dokumen',
        'tahun_dokumen',
        'tentang_dokumen',
        'file_dokumen',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_created' => 'datetime',
    ];

    // Relationship dengan Jenis Dokumen
    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'id_jenis_dokumen', 'id_jenis_dokumen');
    }

    // Relationship dengan Pokja
    public function pokja()
    {
        return $this->belongsTo(Pokja::class, 'id_pokja', 'id_pokja');
    }
}
