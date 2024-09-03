<?php

namespace App\Models;

use App\Http\Resources\TransactionResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
  use HasFactory, SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'quantity',
    'buyer_id',
    'product_id'
  ];

  public  $trasnformer = TransactionResource::class;

  // Una transacción pertenece a un comprador
  public function buyer()
  {
    return $this->belongsTo(Buyer::class);
  }

  // Una transacción pertenece a un producto
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
