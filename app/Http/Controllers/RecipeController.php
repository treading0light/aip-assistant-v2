<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Recipe;
use App\Models\Step;
use App\Models\Ingredient;
use App\Models\Category;

class RecipeController extends Controller
{
    public function create(Request $request) {
        // validate the request

        // create the recipe and ingredient relationship

        // include pivot table

        try {
            $attributes = $request->validate([
                'title' => ['required', 'max:25', 'unique:recipes'],
                'description' => ['nullable', 'max:255'],
                'directions' => ['required'],
            ]);

            

            // dd($request);

            $recipe = Recipe::create($attributes);

            if ($request->hasFile('image')) {
                $this->createImage($request->file('image'), $recipe);
            };

            $ingredients = $request['ingredients'];

            // return $ingredients;

            foreach ($ingredients as $i) {

                $ing = json_decode($i);
                $ingredient = Ingredient::find($ing->id);

                // define relationship of each ingredient by adding them to their pivot table
                $recipe->ingredients()->attach($ingredient, ['qty' => $ing->qty, 'unit' => $ing->unit]);
            };

            $message = 'success: ' . $recipe->id;

            return json_encode($message);

        } catch (Throwable $e) {

            $message = $e->getMessage();

            return json_encode($message);
        }
    }

    public function createImage($file, $recipe) {

            
        $imageName = time() . '.' . $recipe->name . $file->extension();

        $path = $file->move(public_path('images'), $imageName);

        $recipe->image = '/images/' . $imageName;

        $recipe->save();

    }

    public function getRecipe(Request $request, $id=null) {

        if (!$id) {
            $recipe = Recipe::all();
        } else {
            $recipe = Recipe::find($id);
        }

        // $recipe = Recipe::find($request->id);
        

        // $jsonRecipe = $recipe->toJson();

        // dd($jsonRecipe);

        return response()->json($recipe);
    }

    public function populate() {

        $recipe = new Recipe;

        $ingredientArray = [
            '1 lb' => 'ground beef',
            '1' => 'onion',
            '1 piece' => 'lettuce'
        ];

        

        $recipe->name = 'hamburger';

        $recipe->directions = 'smash it up and cook it.';

        $recipe->save();

        foreach ($ingredientArray as $qty => $ingredient) {
            $newIngredient = Ingredient::create([

                'name' => $ingredient
            ]);

            $recipe->ingredients()->attach($newIngredient, ['qty' => $qty]);
        };

        print_r($recipe);

    }
}
