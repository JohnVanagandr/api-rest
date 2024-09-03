<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Resources\SellerResource;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{
  /**
   * Display a listing of the resource.
   */
  public function index(Buyer $buyer)
  {
    $sellers = $buyer->transactions()->with('product.seller') // Relación que tenemos productos vendedores
      ->get() // Buscamos todos las relaciones
      ->pluck('product.seller') // Filtramos por la notación de punto, nos muestra los vendedores que estan al interior de cada producto
      ->unique('id') // para evitar usuarios repetidos, nos muestra colecciones unicas
      ->values(); // para eliminar campos vacios, como el metodo unique conserva los valores o campos vacios

    return $this->showAll($sellers);
  }
}
