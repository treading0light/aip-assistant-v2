<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\UserController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user/login', [UserController::class, 'login']
);

Route::post('/user/register', [UserController::class, 'register']);

Route::post('/recipe/create', [RecipeController::class, 'create'])->name('recipe.create');

// Route::post('/image/create/', [RecipeController::class, 'createImage'])->name('image.create');

Route::get('/recipe/{id?}', [RecipeController::class, 'getRecipe'])->name('recipe.getRecipe');

Route::get('/recipe/populate', [RecipeController::class, 'populate'])->name('recipe.populate');

Route::get('/ingredients', [IngredientController::class, 'getIngredients']
)->name('ingredient.getIngredients');

Route::post('/ingredients/create', [IngredientController::class, 'create']
)->name('ingredient.create');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
