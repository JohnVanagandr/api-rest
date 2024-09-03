<?php

namespace App\Models;

use App\Http\Resources\SellerResource;
use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends User
{
  use HasFactory;

  protected static function boot()
  {
    parent::boot();
    static::addGlobalScope(new SellerScope);
  }

  public  $trasnformer = SellerResource::class;

  // Un vendedor tiene muchos productos
  public function products()
  {
    return $this->hasMany(Product::class);
  }
}
