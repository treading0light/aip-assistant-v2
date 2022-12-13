<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubRecipe extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'sub_recipes';

    public function recipe() {

        return $this->belongsTo(Recipe::class);
    }

    public function ingredients() {
        
        return $this->belongsToMany(Ingredient::class);
    }

}
