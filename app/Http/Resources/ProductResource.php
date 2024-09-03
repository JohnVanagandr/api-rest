<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
      'titulo' => $this->name,
      'detalles' => $this->description,
      'disponibles' => $this->quantity,
      'estado' => $this->status,
      'image' => url("img/{$this->image}"),
      'vendedor' => $this->seller_id,
      'fechaCreacion' => $this->created_at,
      'fechaActualizacion' => $this->updated_at,
      'fechaEliminacion' => $this->deleted_at
    ];
  }

  public static function originalAttribute($index)
  {
    $attributes = [
      'identificador' => 'id',
      'titulo' => 'name',
      'detalles' => 'description',
      'disponibles' => 'quantity',
      'estado' => 'status',
      'vendedor' => 'seller_id',
      'fechaCreacion' => 'created_at',
      'fechaActualizacion' => 'updated_at',
      'fechaEliminacion' => 'deleted_at'
    ];

    return isset($attributes[$index]) ? $attributes[$index] : null;
  }
}
