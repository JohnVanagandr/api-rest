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
      'fechaEliminacion' => $this->deleted_at,
      'links' => [
        [
          'rel' => 'self',
          'href' => route('products.show', $this->id),
        ],
        [
          'rel' => 'product.buyers',
          'href' => route('products.buyers.index', $this->id)
        ],
        [
          'rel' => 'product.catefories',
          'href' => route('products.categories.index', $this->id)
        ],
        [
          'rel' => 'product.transactions',
          'href' => route('products.transactions.index', $this->id)
        ],
        [
          'rel' => 'seller',
          'href' => route('sellers.show', $this->seller_id)
        ]
      ],
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

  public static function transformedAttribute($index)
  {
    $attributes = [
      'id' => 'identificador',
      'name' => 'titulo',
      'description' => 'detalles',
      'quantity' => 'disponibles',
      'status' => 'estado',
      'seller_id' => 'vendedor',
      'created_at' => 'fechaCreacion',
      'updated_at' => 'fechaActualizacion',
      'deleted_at' => 'fechaEliminacion'
    ];

    return isset($attributes[$index]) ? $attributes[$index] : null;
  }
}
