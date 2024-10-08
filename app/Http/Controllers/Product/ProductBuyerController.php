<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Resources\BuyerResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Product $product)
  {
    $buyers = $product->transactions()
      ->with('buyer')
      ->get()
      ->pluck('buyer')
      ->unique('id')
      ->values();
    return $this->showAll($buyers);
  }
}
