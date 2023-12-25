<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
	protected $table = 'invoice';
    protected $fillable = [
		'id',
        'date',
        'user_id',
    ];
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
	
	public function invoiceDetails()
	{
		return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
	}
	
	// public function product()
	// {
		// return $this->belongsTo(Product::class, 'invoicedetail');
	// }
	
	// public function products()
	// {
		// return $this->hasManyThrough(Product::class, InvoiceDetail::class, 'invoice_id', 'id', 'id', 'product_id');
	// }
}
