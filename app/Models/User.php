<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens as PassportHasApiTokens;

class User extends Authenticatable
{
  use HasFactory, Notifiable, SoftDeletes;
  // Trait de laravel passport
  use PassportHasApiTokens;
  // Trait de sanctum
  // use HasApiTokens;

  const USUARIO_VERIFICADO = '1';
  const USUARIO_NO_VERIFICADO = '0';

  const USUARIO_ADMINISTRADOR = 'true';
  const USUARIO_REGULAR = 'false';

  public  $trasnformer = UserResource::class;

  protected $table = 'users';
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'verified',
    'verification_token',
    'admin'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
    'verification_token'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  /**
   * Mutadores
   */
  public function setNameAttribute($valor)
  {
    $this->attributes['name'] = strtolower($valor);
  }
  public function setEmailAttribute($valor)
  {
    $this->attributes['email'] = strtolower($valor);
  }

  /**
   * Accesores
   */
  public function getNameAttribute($valor)
  {
    return ucwords($valor);
  }
  /**
   * Validaciones
   */

  public function esVerificado()
  {
    return $this->verified == User::USUARIO_VERIFICADO;
  }

  public function esAdministrador()
  {
    return $this->admin == User::USUARIO_ADMINISTRADOR;
  }

  public static function generarVerificationToken()
  {
    return Str::random(40);
  }
}
