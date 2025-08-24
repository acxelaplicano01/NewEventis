<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    use HasFactory;
    protected $table = 'likes';

    protected $fillable = [
        'meGusta',
        'noMegusta',
        'idPublicacion',
        'idUsuario',
    ];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'idPublicacion');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
