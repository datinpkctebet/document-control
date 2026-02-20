<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenInternal extends Model
{
    use HasFactory;

    protected $table = 'tbl_dokumen_internal_unit';
    protected $primaryKey = 'id_dokumen_internal_unit';
    public $timestamps = false;

    protected $fillable = [
        'id_jenis_dokumen_unit',
        'id_pokja',
        'id_pelayanan',
        'nama_dokumen',
        'no_dokumen',
        'file_dokumen',
        'tahun_dokumen',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Jenis Dokumen Unit
    public function jenisDokumenUnit()
    {
        return $this->belongsTo(JenisDokumenUnit::class, 'id_jenis_dokumen_unit', 'id_jenis_dokumen_unit');
    }

    // Relationship dengan Pokja
    public function pokja()
    {
        return $this->belongsTo(Pokja::class, 'id_pokja', 'id_pokja');
    }

    // Relationship dengan Pelayanan
    public function pelayanan()
    {
        return $this->belongsTo(Pelayanan::class, 'id_pelayanan', 'id_pelayanan');
    }
}
