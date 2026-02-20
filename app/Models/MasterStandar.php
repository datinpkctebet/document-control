<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStandar extends Model
{
    use HasFactory;

    protected $table = 'tbl_master_standar';
    protected $primaryKey = 'id_master_standar';
    public $timestamps = false;

    protected $fillable = [
        'id_master_bab',
        'master_standar',
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

    // Relationship dengan Elemen Penilaian
    public function elemenPenilaian()
    {
        return $this->hasMany(MasterElemenPenilaian::class, 'id_standar', 'id_master_standar');
    }
}