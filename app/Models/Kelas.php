<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'jurusan',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
