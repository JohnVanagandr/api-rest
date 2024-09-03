<?php

namespace App\Models;

use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use HasFactory, SoftDeletes;

  const PRODUCTO_DISPONIBLE = 'disponible';
  const PRODUCTO_NO_DISPONIBLE = 'no disponible';

  public  $trasnformer = ProductResource::class;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'name',
    'description',
    'quantity',
    'status',
    'image',
    'seller_id'
  ];

  protected $hidden = [
    'pivot'
  ];

  public function estaDisponible()
  {
    return $this->status == Product::PRODUCTO_DISPONIBLE;
  }

  // Un producto pertenece a un vendedor
  public function seller()
  {
    return $this->belongsTo(Seller::class);
  }

  // Un producto tiene muchas transacciones
  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  // Un producto pertenece a muchas categorias
  public function categories()
  {
    return $this->belongsToMany(Category::class);
  }
}
