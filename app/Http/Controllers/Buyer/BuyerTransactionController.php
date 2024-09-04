<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerTransactionController extends ApiController
{
  public function __construct()
  {
    parent::__construct();
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Buyer $buyer)
  {
    $transactions = $buyer->transactions;

    return $this->showAll($transactions);
  }
}
