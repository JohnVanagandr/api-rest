<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductTransactionController extends ApiController
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
    $transactions = $product->transactions;
    return $this->showAll($transactions);
  }
}
