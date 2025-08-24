<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscripcion extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $fillable = ['IdEvento', 'IdUser', 'IdRecibo', 'Status'];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'IdEvento');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'IdUser');
    }
    public function recibo()
    {
        return $this->belongsTo(Recibopago::class, 'IdRecibo');
    }

}
