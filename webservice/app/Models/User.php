<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function comentarios()
    {
        return $this->hasMany('App\Models\Comentario');
    }

    public function conteudos()
    {
        return $this->hasMany('App\Models\Conteudo');
    }

    public function curtidas()
    {
      return $this->belongsToMany('App\Models\Conteudo', 'curtidas', 'user_id', 'conteudo_id');
    }

    public function amigos()
    {
      return $this->belongsToMany('App\Models\User', 'amigos', 'user_id', 'amigo_id');
    }

    public function getImagemAttribute($value)
    {
      return asset($value);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
