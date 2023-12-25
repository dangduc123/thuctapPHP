<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
	protected $table = 'product';
	protected $fillable = [
		'id',
		'product_name',
		'price',
		'image',
		'description',
		'product_type',
		'status',
		'ingredient_id',
	];
	
	// public function product() {
		// $products = \App\Models\Product::all();
		// return $products;
	// }
	
	public function ingredient()
	{
		return $this->belongsToMany(Ingredient::class, 'product_ingredient');
	}
	
	public function carts()
	{
		return $this->belongsTo(Cart::class);
	}

	public function invoiceDetails()
	{
		return $this->hasMany(InvoiceDetail::class, 'product_id', 'id');
	}
	
	// public function invoice()
	// {
		// return $this->belongsTo(Invoice::class, 'invoicedetail');
	// }
	
	// public function invoices()
	// {
		// return $this->hasManyThrough(Invoice::class, InvoiceDetail::class, 'product_id', 'id', 'id', 'invoice_id');
	// }
	
	
}
