<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
	protected $table = 'ingredient';
	protected $fillable = [
		'id',
		'ingredient_name',
		'quantity',
		'unit',
		'status',
		'price',
	];

    // public function products()
    // {
        // return $this->hasMany(Product::class);
    // }
	
	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_ingredient');
	}
}
