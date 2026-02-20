<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKriteria extends Model
{
    use HasFactory;

    protected $table = 'tbl_master_kriteria';
    protected $primaryKey = 'id_master_kriteria';
    public $timestamps = false;

    protected $fillable = [
        'id_master_standar',
        'master_kriteria',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Standar
    public function standar()
    {
        return $this->belongsTo(MasterStandar::class, 'id_master_standar', 'id_master_standar');
    }

    // Relationship dengan Elemen Penilaian
    public function elemenPenilaian()
    {
        return $this->hasMany(MasterElemenPenilaian::class, 'id_kriteria', 'id_master_kriteria');
    }
}