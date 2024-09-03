<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'identificador' => $this->id,
      'nombre' => $this->name,
      'correo' => $this->email,
      'esVerificado' => $this->verified,
      'esAdministrador' => $this->admin,
      'fechaCreacion' => $this->created_at,
      'fechaActualizacion' => $this->updated_at,
      'fechaEliminacion' => $this->deleted_at,
    ];
  }

  public static function originalAttribute($index)
  {
    $attributes = [
      'identificador'   => 'id',
      'nombre'          => 'name',
      'correo'          => 'email',
      'esVerificado'    => 'verified',
      'esAdministrador' => 'admin',
      'fechaCreacion'   => 'created_at',
      'fechaActualizacion' => 'updated_at',
      'fechaEliminacion' => 'deleted_at'
    ];

    return isset($attributes[$index]) ? $attributes[$index] : null;
  }
}
