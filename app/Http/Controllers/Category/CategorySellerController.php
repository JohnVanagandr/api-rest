<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategorySellerController extends ApiController
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Category $category)
  {
    $sellers = $category->products()
      ->with('seller')
      ->get()
      ->pluck('seller')
      ->unique()
      ->values();

    return $this->showAll($sellers);
  }
}
