<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    use HasFactory;

    protected $table = 'tbl_unit_pelayanan';
    protected $primaryKey = 'id_unit_pelayanan';
    public $timestamps = false;

    protected $fillable = [
        'id_pokja',
        'jenis_pelayanan',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'modified_time' => 'datetime',
    ];

    // Relationship dengan Dokumen Internal
    public function dokumenInternal()
    {
        return $this->hasMany(DokumenInternal::class, 'id_pelayanan', 'id_pelayanan');
    }
}