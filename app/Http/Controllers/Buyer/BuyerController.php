<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Resources\BuyerResource;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
  public function __construct()
  {
    parent::__construct();
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $compradores = Buyer::has('transactions')->get();

    return $this->showAll($compradores);
  }

  /**
   * Display the specified resource.
   */
  public function show(Buyer $buyer)
  {
    // $comprador = Buyer::has('transactions')->findOrFail($id);
    return $this->showOne($buyer, 200);
  }
}
