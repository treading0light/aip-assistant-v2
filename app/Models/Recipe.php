<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function steps() {

        return $this->hasMany(Step::class);

    }

    public function ingredients() {
        
        return $this->belongsToMany(Ingredient::class)
        ->withPivot(['qty', 'unit', 'sub_recipe']);
    }

    public function category() {

        return $this->belongsTo(Category::class);
        
    }
}
