<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nacionalidad extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['nombreNacionalidad'];
    public function users()
    {
        return $this->hasMany(User::class, 'IdNacionalidad');
    }


    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });
    }

    protected $table = 'nacionalidads'; 
}
