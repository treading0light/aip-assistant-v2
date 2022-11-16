<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function getIngredients() {
        $ingredients = Ingredient::all();

        $json = json_encode($ingredients);

        return $json;
    }

    public function create(Request $request) {

        try {
            $attributes = $request->validate([
                'name' => ['required', 'max:25', 'unique:ingredients',],
                'description' => ['nullable', 'max:255',]
            ]);

            $ingredient = Ingredient::create($attributes);

            return $ingredient->toJson();


        } catch (exception $e) {
            $message = $e->getMessage();
            return $mesage;
        }
    }
}
