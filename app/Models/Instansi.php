<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'tbl_instansi';
    protected $primaryKey = 'id_instansi';
    public $timestamps = false;

    protected $fillable = [
        'instansi',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_instansi', 'id_instansi');
    }
}