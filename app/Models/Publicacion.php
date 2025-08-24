<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Publicacion extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'publicaciones';
    protected $fillable = ['descripcion','foto', 'IdUsuario', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'IdUsuario');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'idPublicacion');
    }
    
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idPublicacion');
    }

}
