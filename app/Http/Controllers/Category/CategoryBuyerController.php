<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Resources\BuyerResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryBuyerController extends ApiController
{
  public function __construct()
  {
    parent::__construct();
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Category $category)
  {
    $buyers = $category->products()
      ->whereHas('transactions')
      ->with('transactions.buyer')
      ->get()
      ->pluck('transactions')
      ->collapse()
      ->pluck('buyer')
      ->unique()
      ->values();

    return $this->showAll($buyers);
  }
}
