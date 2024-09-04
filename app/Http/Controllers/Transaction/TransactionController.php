<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $transactions = Transaction::all();

    return $this->showAll($transactions);
  }

  /**
   * Display the specified resource.
   */
  public function show(Transaction $transaction)
  {
    return $this->showOne($transaction);
  }
}
