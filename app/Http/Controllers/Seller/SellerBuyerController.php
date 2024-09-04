<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Resources\BuyerResource;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerBuyerController extends ApiController
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
    $buyers = $seller->products()
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
