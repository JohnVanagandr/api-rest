<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Resources\SellerResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionSellerController extends ApiController
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Transaction $transaction)
  {
    $seller = $transaction->product->seller;
    return $this->showOne($seller);
  }
}
