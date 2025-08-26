<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'active_role_id',
        'nombre',
        'apellido',
        'descripcion',
        'IdNacionalidad',
        'IdTipoPerfil',
        'pagina',
        'profile_photo_path',
        'password',
    ];

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'created_by');
    }

    public function countEventos()
    {
        return $this->eventos()->count();
    }

    public function countPublicaciones()
    {
        return $this->publicaciones()->count();
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'IdUsuario');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'idUsuario');
    }
    
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'IdUsuario');
    }
    
    /**
     * Los usuarios que este usuario sigue.
     */
    public function siguiendo()
    {
        return $this->belongsToMany(User::class, 'seguidor', 'user_id', 'seguido_id');
    }

    /**
     * Los usuarios que siguen a este usuario.
     */
    public function seguidores()
    {
        return $this->belongsToMany(User::class, 'seguidor', 'seguido_id', 'user_id');
    }

    public function seguir($userId)
    {
        $this->siguiendo()->attach($userId);
    }

    public function dejarDeSeguir($userId)
    {
        $this->siguiendo()->detach($userId);
    }

    public function nacionalidad()
    {
        return $this->belongsTo(Nacionalidad::class, 'IdNacionalidad');
    }

    public function conferencistas()
    {
        return $this->hasMany(Conferencista::class, 'IdUser');
    }
    public function tipoPerfil()
    {
        return $this->belongsTo(TipoPerfil::class, 'IdTipoPerfil');
    }

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class, 'IdUser');
    }
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'IdUser');
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function getActiveRoleAttribute()
    {
        return \Spatie\Permission\Models\Role::find($this->active_role_id);
    }
}
