<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Product;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    // public function showInvoiceForm()
    // {
        // return view('admin.invoice');
    // }
	
	// public function invoice() {
        // // Truy vấn để lấy thông tin từ bảng sản phẩm
        // $invoices = DB::table('invoice')->get();

        // return $invoices;
    // }
	
	public function index(Request $request)
	{
		$perPage = 5; // Số bản ghi hiển thị trên mỗi trang
		$search = $request->input('search');

		$invoices = DB::table('invoice')
			->join('invoicedetail', 'invoice.id', '=', 'invoicedetail.invoice_id')
			->join('user', 'invoice.user_id', '=', 'user.id')
			->join('product', 'invoicedetail.product_id', '=', 'product.id')
			->select(
				'invoice.id as id',
				'invoice.date as date',
				'invoice.created_at as created_at',
				'invoice.updated_at as updated_at',
				'user.user_name as user_name',
				'product.product_name as product_name',
				'invoicedetail.price as price',
				'invoicedetail.quantity as quantity',
				'invoicedetail.total_price as total_price'
			);

		if ($search) {
			$invoices = $invoices->where('invoice.id', 'like', "%$search%")
				->orWhere('product.product_name', 'like', "%$search%")
				->orWhere('user.user_name', 'like', "%$search%");
		}

		$invoices = $invoices->paginate($perPage);
		
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 
		$users = User::orderBy('updated_at', 'desc')->paginate(5);
		return view('admin.invoice', compact('invoices', 'revenue', 'currentTime'));
	}
	
	public function edit($id)
	{
		$invoice = DB::table('invoice')->where('id', $id)->first();
		$user = DB::table('user')->where('id', $invoice->user_id)->first();
		$invoicedetail = DB::table('invoicedetail')->where('invoice_id', $id)->first();
		$product = DB::table('product')->where('id', $invoicedetail->product_id)->first();
		return view('admin.edit_invoice', compact('invoice', 'user', 'product', 'invoicedetail'));
	}
	
	
	public function update(Request $request, $id)
	{
		$request->validate([
			'date' => 'required|date',
			'user_name' => 'required|string',
			'product_name' => 'required|string',
			'price' => 'required|numeric',
			'quantity' => 'required|numeric',
			'total_price' => 'required|numeric',
		]);

		$invoice = Invoice::findOrFail($id);
		$user = User::findOrFail($invoice->user_id);
		$invoicedetail = Invoicedetail::where('invoice_id', $id)->first();
		$product = Product::findOrFail($invoicedetail->product_id);

		// Cập nhật thông tin hóa đơn
		$invoice->update(['date' => $request->input('date')]);

		// Cập nhật thông tin người dùng
		$user->update(['user_name' => $request->input('user_name')]);

		// Cập nhật thông tin sản phẩm
		$product->update(['product_name' => $request->input('product_name')]);

		// Cập nhật thông tin chi tiết hóa đơn
		$invoicedetail->update([
			'price' => $request->input('price'),
			'quantity' => $request->input('quantity'),
			'total_price' => $request->input('total_price'),
		]);

		return redirect()->route('invoice')->with('success', 'Invoice updated successfully');
	}
	
	
	public function delete($id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'delete'))) {
			return redirect()->route('invoice')->with('error', 'Bạn không có quyền xóa đơn hàng!');
		}
		// Xóa các bản ghi liên quan trong bảng 'invoicedetail'
		DB::table('invoicedetail')->where('invoice_id', $id)->delete();

		// Sau đó xóa bản ghi trong bảng 'invoice'
		DB::table('invoice')->where('id', $id)->delete();

		return redirect()->route('invoice')->with('success', 'Đơn hàng đã được xóa thành công!');
	}
	
	
}
