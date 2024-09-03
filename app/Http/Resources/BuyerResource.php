<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyerResource extends JsonResource
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
      'fechaCreacion' => $this->created_at,
      'fechaActualizacion' => $this->updated_at,
      'fechaEliminacion' => $this->deleted_at,
      'links' => [
        [
          'rel' => 'self',
          'href' => route('buyers.show', $this->id),
        ],
        [
          'rel' => 'buyer.categories',
          'href' => route('buyers.categories.index', $this->id),
        ],
        [
          'rel' => 'buyer.products',
          'href' => route('buyers.products.index', $this->id),
        ],
        [
          'rel' => 'buyer.sellers',
          'href' => route('buyers.sellers.index', $this->id),
        ],
        [
          'rel' => 'buyer.transactions',
          'href' => route('buyers.transactions.index', $this->id),
        ],
        [
          'rel' => 'user',
          'href' => route('users.show', $this->id),
        ],
      ],
    ];
  }

  public static function originalAttribute($index)
  {
    $attributes = [
      'identificador' => 'id',
      'nombre' => 'name',
      'correo' => 'email',
      'esVerificado' => 'verified',
      'fechaCreacion' => 'created_at',
      'fechaActualizacion' => 'updated_at',
      'fechaEliminacion' => 'deleted_at'
    ];

    return isset($attributes[$index]) ? $attributes[$index] : null;
  }

  public static function transformedAttribute($index)
  {
    $attributes = [
      'id' => 'identificador',
      'name' => 'nombre',
      'email' => 'correo',
      'verified' => 'esVerificado',
      'created_at' => 'fechaCreacion',
      'updated_at' => 'fechaActualizacion',
      'deleted_at' => 'fechaEliminacion'
    ];

    return isset($attributes[$index]) ? $attributes[$index] : null;
  }
}
