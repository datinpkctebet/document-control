<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokja extends Model
{
    use HasFactory;

    protected $table = 'tbl_pokja';
    protected $primaryKey = 'id_pokja';
    public $timestamps = false;

    protected $fillable = [
        'pokja',
        'delete_at',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Relationship dengan Dokumen Internal
    public function dokumenInternal()
    {
        return $this->hasMany(DokumenInternal::class, 'id_pokja', 'id_pokja');
    }
}