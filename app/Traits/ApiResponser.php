<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponser
{

  private function successResponse($data, $code)
  {
    return new JsonResponse($data, $code);
  }

  protected function errorResponse($messaje, $code)
  {
    return new JsonResponse(['error' => $messaje, 'code' => $code], $code);
  }

  protected function showAll(Collection $collection, $code = 200)
  {
    if ($collection->isEmpty()) {
      return $this->successResponse(['data' => $collection], $code);
    }
    $transformer = $collection->first()->trasnformer;
    $collection = $this->filterData($collection, $transformer);
    $collection = $this->shorData($collection, $transformer);
    $collection = $this->paginate($collection);
    $collection = $this->transformCollectionData($collection, $transformer);

    return $collection;
    // return $this->successResponse(['data' => $collection], $code);
  }

  protected function showOne(Model $instance, $code = 200)
  {
    $transformer = $instance->trasnformer;
    $instance = $this->transformData($instance, $transformer);
    return new JsonResponse(['data', $instance], $code);
  }

  protected function showMessage($message, $code = 200)
  {
    return new JsonResponse($message, $code);
  }

  protected function transformData($data, $transformer)
  {
    return new $transformer($data);
  }
  protected function transformCollectionData($data, $transformer)
  {
    return $transformer::collection($data);
  }


  protected function filterData(Collection $collection, $transformer)
  {
    foreach (request()->query() as $query => $value) {
      $attribute = $transformer::originalAttribute($query);

      if (isset($attribute, $value)) {
        $collection = $collection->where($attribute, $value);
      }
    }

    return $collection;
  }

  protected function shorData(Collection $collection, $transformer)
  {
    if (request()->has('short_by')) {
      $attribute = $transformer::originalAttribute(request()->short_by);
      $collection = $collection->sortBy->{$attribute};
    }
    return $collection;
  }

  protected function paginate(Collection $collection)
  {
    $page = LengthAwarePaginator::resolveCurrentPage();

    $perPage = 15;
    if (request()->has('per_page')) {
      $perPage = (int) request()->per_page;
    }

    $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

    $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
      'path' => LengthAwarePaginator::resolveCurrentPath(),
    ]);

    $paginated->appends(request()->all());

    return $paginated;
  }
}
