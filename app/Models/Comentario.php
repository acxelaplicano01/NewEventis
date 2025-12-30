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
        'parent_id',
        'likes_count',
    ];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'IdPublicacion');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'IdUsuario');
    }

    public function parent()
    {
        return $this->belongsTo(Comentario::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comentario::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(ComentarioLike::class, 'comentario_id');
    }

    public function isLikedByUser($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
