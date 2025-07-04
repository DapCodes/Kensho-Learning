<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriUser extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'skor',
        'ranking',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
