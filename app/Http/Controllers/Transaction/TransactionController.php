<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $trasnsactions = Transaction::get();

    return $this->showAll($trasnsactions);
  }

  /**
   * Display the specified resource.
   */
  public function show(Transaction $transaction)
  {
    return $this->showOne($transaction);
  }
}
