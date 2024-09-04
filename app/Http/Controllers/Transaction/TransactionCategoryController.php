<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{
  public function __construct()
  {
    $this->middleware('client.credentials')->only(['index']);
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Transaction $transaction)
  {
    $categories = $transaction->product->categories()->get();
    return $this->showAll($categories);
  }
}
