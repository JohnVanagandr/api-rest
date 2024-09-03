<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {

    // Establecemos la verificación de las claves foraneas en 0
    // Eliminamos todos los campos de las tablas relacionadas en la lista
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    User::truncate();
    Category::truncate();
    Product::truncate();
    Transaction::truncate();
    DB::table('category_product')->truncate();

    // Evitamos la ejecución de los eventos al modelo
    User::flushEventListeners();
    Category::flushEventListeners();
    Product::flushEventListeners();
    Transaction::flushEventListeners();

    $cantidadUsuarios = 1000;
    $cantidadCategorias = 60;
    $cantidadProductos = 3000;
    $cantidadTransacciones = 300;

    User::factory($cantidadUsuarios)->create();
    Category::factory($cantidadCategorias)->create();

    Product::factory($cantidadProductos)->create()->each(
      function ($producto) {
        $categorias = Category::all()->random(mt_rand(1, 5))->pluck('id');

        $producto->categories()->attach($categorias);
      }
    );

    Transaction::factory($cantidadTransacciones)->create();
  }
}
