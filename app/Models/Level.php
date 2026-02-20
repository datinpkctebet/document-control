<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'tbl_level';
    protected $primaryKey = 'id_level';
    public $timestamps = false;

    protected $fillable = [
        'level',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Users
    public function users()
    {
        return $this->hasMany(User::class, 'id_level', 'id_level');
    }
}