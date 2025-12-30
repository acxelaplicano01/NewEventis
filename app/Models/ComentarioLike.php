<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentarioLike extends Model
{
    protected $fillable = [
        'comentario_id',
        'user_id',
    ];

    public function comentario()
    {
        return $this->belongsTo(Comentario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
