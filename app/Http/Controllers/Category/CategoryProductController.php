<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProductController extends ApiController
{

  public function __construct()
  {
    $this->middleware('client.credentials')->only(['index']);
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Category $category)
  {
    $products = $category->products;
    return $this->showAll($products);
  }
}
