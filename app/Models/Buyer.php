<?php

namespace App\Models;

use App\Http\Resources\BuyerResource;
use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
  use HasFactory;

  public  $trasnformer = BuyerResource::class;

  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope(new BuyerScope);
  }

  // Un comprador tiene muchas transacciones
  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }
}
