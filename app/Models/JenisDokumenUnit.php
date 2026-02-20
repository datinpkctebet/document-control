<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumenUnit extends Model
{
    use HasFactory;

    protected $table = 'tbl_jenis_dokumen_unit';
    protected $primaryKey = 'id_jenis_dokumen_unit';
    public $timestamps = false;

    protected $fillable = [
        'jenis_dokumen',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Dokumen Internal
    public function dokumenInternal()
    {
        return $this->hasMany(DokumenInternal::class, 'id_jenis_dokumen_unit', 'id_jenis_dokumen_unit');
    }
}