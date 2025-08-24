<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suscripcion extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $fillable = ['IdConferencia', 'IdUser', 'created_by', 'deleted_by'];

    public function conferencia()
    {
        return $this->belongsTo(Conferencia::class, 'IdConferencia');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'IdUser');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'IdSuscripcion');
    }

}
