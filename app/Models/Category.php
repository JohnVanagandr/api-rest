<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
  use HasFactory, SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'name',
    'description'
  ];

  protected $hidden = [
    'pivot'
  ];

  public  $trasnformer = CategoryResource::class;

  // Una categoria pertenece a muchos productos
  public function products()
  {
    return $this->belongsToMany(Product::class);
  }
}
