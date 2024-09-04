<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Seller $seller)
  {
    $categories = $seller->products()
      ->with('categories')
      ->get()
      ->pluck('categories')
      ->collapse()
      ->unique('id')
      ->values();
    return $this->showAll($categories);
  }
}
