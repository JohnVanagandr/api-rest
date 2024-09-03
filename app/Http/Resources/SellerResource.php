<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
      'esAdministrador' => $this->admin,
      'fechaCreacion' => $this->created_at,
      'fechaActualizacion' => $this->updated_at,
      'fechaEliminacion' => $this->deleted_at,
      'links' => [
        [
          'rel' => 'self',
          'href' => route('sellers.show', $this->id),
        ],
        [
          'rel' => 'seller.buyers',
          'href' => route('sellers.buyers.index', $this->id),
        ],
        [
          'rel' => 'seller.categories',
          'href' => route('sellers.categories.index', $this->id),
        ],
        [
          'rel' => 'seller.products',
          'href' => route('sellers.products.index', $this->id),
        ],
        [
          'rel' => 'seller.transactions',
          'href' => route('sellers.transactions.index', $this->id),
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
      'esAdministrador' => 'admin',
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
      'admin' => 'esAdministrador',
      'created_at' => 'fechaCreacion',
      'updated_at' => 'fechaActualizacion',
      'deleted_at' => 'fechaEliminacion'
    ];

    return isset($attributes[$index]) ? $attributes[$index] : null;
  }
}
