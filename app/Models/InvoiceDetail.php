<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
	protected $table = 'invoicedetail';
    protected $fillable = [
		'id',
		'invoice_id',
        'product_id',
        'quantity',
        'price',
        'total_price',
    ];
	
	public function product()
	{
		return $this->belongsTo(Product::class);
	}
	
	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}
}
