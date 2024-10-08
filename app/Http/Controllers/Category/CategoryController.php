<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{

  public function __construct()
  {
    $this->middleware('auth:api')->except(['index', 'show']);
    $this->middleware('client.credentials')->only(['index', 'show']);
    $this->middleware('transform.input:' . CategoryResource::class)->only(['store', 'update']);
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $categories = Category::get();
    return $this->showAll($categories);
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $rules = [
      'name' => 'required',
      'description' => 'required'
    ];

    $this->validate($request, $rules);

    $category = Category::create($request->all());
    return $this->showOne($category, 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Category $category)
  {
    return $this->showOne($category);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Category $category)
  {
    $category->fill($request->only([
      'name',
      'description'
    ]));

    if ($category->isClean()) {
      return $this->errorResponse('Debe especificar al menos un valor diferente para actualizar', 422);
    }
    $category->save();
    return $this->showOne($category);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Category $category)
  {
    $category->delete();
    return $this->showOne($category);
  }
}
