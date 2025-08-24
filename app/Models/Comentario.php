<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $fillable = [
        'contenido',
        'foto',
        'idPublicacion',
        'idUsuario',
    ];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'IdPublicacion');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'IdUsuario');
    }
}
