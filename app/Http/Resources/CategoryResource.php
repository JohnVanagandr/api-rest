<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
      'fechaCreacion' => $this->created_at,
      'fechaActualizacion' => $this->updated_at,
      'fechaEliminacion' => $this->deleted_at,
      'links' => [
        [
          'rel' => 'self',
          'href' => route('categories.show', $this->id),
        ],
        [
          'rel' => 'category.buyers',
          'href' => route('categories.buyers.index', $this->id)
        ],
        [
          'rel' => 'category.products',
          'href' => route('categories.products.index', $this->id)
        ],
        [
          'rel' => 'category.sellers',
          'href' => route('categories.sellers.index', $this->id)
        ],
        [
          'rel' => 'category.transactions',
          'href' => route('categories.transactions.index', $this->id)
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
      'created_at' => 'fechaCreacion',
      'updated_at' => 'fechaActualizacion',
      'deleted_at' => 'fechaEliminacion'
    ];

    return isset($attributes[$index]) ? $attributes[$index] : null;
  }
}
