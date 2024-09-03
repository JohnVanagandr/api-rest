<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $products = Product::get();
    return $this->showAll($products);
  }


  /**
   * Display the specified resource.
   */
  public function show(Product $product)
  {
    return $this->showOne($product);
  }
}
