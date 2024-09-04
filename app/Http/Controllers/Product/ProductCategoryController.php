<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
  public function __construct()
  {
    $this->middleware('client.credentials')->only(['index']); //Solo index
    $this->middleware('auth.api')->except(['index']); // todos menos index
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Product $product)
  {
    $categories = $product->categories;
    return $this->showAll($categories);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Product $product, Category $category)
  {
    // sync, attach, syncWithoutDetaching
    // $product->categories()->sync([$category->id]); //Elimina tadas las categorias y deja solo la categoria que pasamos
    // $product->categories()->attach([$category->id]); //Agrega la misma categoria en cada solicitud
    $product->categories()->syncWithoutDetaching([$category->id]);
    $categories = CategoryResource::collection($product->categories);

    return $this->showAll($product->categories);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product, Category $category)
  {
    if (!$product->categories()->find($category->id)) {
      return $this->errorResponse('La categoria especificada no es una categoria de este producto', 404);
    }

    $product->categories()->detach([$category->id]);

    return $this->showAll($product->categories);
  }
}
