<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_users';
    protected $primaryKey = 'id_users';
    public $timestamps = false;

    protected $fillable = [
        'id_instansi',
        'id_unit',
        'username',
        'password',
        'nama_lengkap',
        'no_telepon',
        'id_level',
        'id_pokja',
        'menu_roles',
        'kategori_instansi',
        'tipe_aplikasi',
        'delete_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'updated_time' => 'datetime',
    ];

    // Override default password field
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Override default username field
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    // Relationship dengan Level
    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }

    // Relationship dengan Instansi
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi', 'id_instansi');
    }

    // Check if user is superadmin
    public function isSuperadmin()
    {
        return $this->id_level == 1;
    }

    // Check if user is petugas
    public function isPetugas()
    {
        return $this->id_level == 2;
    }
    
    // Check if user is surveyor
    public function isSurveyor()
    {
        return $this->id_level == 3;
    }
}