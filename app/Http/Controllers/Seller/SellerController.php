<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends ApiController
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
    $vendedores = Seller::has('products')->get();
    return $this->showAll($vendedores);
  }

  /**
   * Display the specified resource.
   */
  public function show(Seller $seller)
  {
    // $comprador = Seller::has('products')->findOrFail($id);
    return $this->showOne($seller, 200);
  }
}
