<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBab extends Model
{
    use HasFactory;

    protected $table = 'tbl_master_bab';
    protected $primaryKey = 'id_master_bab';
    public $timestamps = false;

    protected $fillable = [
        'master_bab',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Elemen Penilaian
    public function elemenPenilaian()
    {
        return $this->hasMany(MasterElemenPenilaian::class, 'id_master_bab', 'id_master_bab');
    }
}