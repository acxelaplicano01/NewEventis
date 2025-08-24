<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conferencista extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['titulo', 'foto', 'descripcion', 'IdUser','firma','sello'];

    public function user()
    {
        return $this->belongsTo(User::class, 'IdUser');
    }
    public function conferencias()
    {
        return $this->hasMany(Conferencia::class, 'idConferencista');
    }
}