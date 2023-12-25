<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RevenueController extends Controller
{
    public function index()
    {
        $revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 

        return view('revenue.index', compact('revenue', 'currentTime'));
    }
	
}
