<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
      'cantidad' => $this->quantity,
      'comprador' => $this->buyer_id,
      'producto' => $this->product_id,
      'fechaCreacion' => $this->created_at,
      'fechaActualizacion' => $this->updated_at,
      'fechaEliminacion' => $this->deleted_at,
      'links' => [
        [
          'rel' => 'self',
          'href' => route('transactions.show', $this->id),
        ],
        [
          'rel' => 'transaction.catefories',
          'href' => route('transactions.categories.index', $this->id)
        ],
        [
          'rel' => 'transaction.seller',
          'href' => route('transactions.sellers.index', $this->id)
        ],
        [
          'rel' => 'buyer',
          'href' => route('buyers.show', $this->buyer_id)
        ],
        [
          'rel' => 'product',
          'href' => route('products.show', $this->product_id)
        ]
      ],
    ];
  }

  public static function originalAttribute($index)
  {
    $attributes = [
      'identificador' => 'id',
      'cantidad' => 'quantity',
      'comprador' => 'buyer_id',
      'producto' => 'product_id',
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
      'quantity' => 'cantidad',
      'buyer_id' => 'comprador',
      'product_id' => 'producto',
      'created_at' => 'fechaCreacion',
      'updated_at' => 'fechaActualizacion',
      'deleted_at' => 'fechaEliminacion'
    ];

    return isset($attributes[$index]) ? $attributes[$index] : null;
  }
}
