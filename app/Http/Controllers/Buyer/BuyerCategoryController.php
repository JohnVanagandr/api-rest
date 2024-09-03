<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{
  /**
   * Display a listing of the resource.
   */
  public function index(Buyer $buyer)
  {
    $categories = $buyer->transactions()->with('product.categories') // Relación que tenemos productos categorias
      ->get() // Buscamos todos las relaciones
      ->pluck('product.categories') // Filtramos por la notación de punto, nos muestra los vendedores que estan al interior de cada producto
      ->collapse() // Nos une todas las listas que nos esta entregando la consulta
      ->unique('id') // para evitar usuarios repetidos, nos muestra colecciones unicas
      ->values(); // para eliminar campos vacios, como el metodo unique conserva los valores o campos vacios

    return $this->showAll($categories);
  }
}
