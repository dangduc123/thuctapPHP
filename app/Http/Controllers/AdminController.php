<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin; 
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{
    public function index()
    {
		$user = Auth::guard('user')->user();
		if (!$user || !$user->roles->contains('name', 'admin')) {
			return redirect()->route('admin.login')->with('error', 'Bạn không quyền truy cập vào trang này khi chưa có quyền!');
		}
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 
        return view('admin.index', compact('revenue', 'currentTime'));
    }
	
	public function showAdminForm()
	{
		return view('admin.admin_list');
	}
	
	
	public function edit($id)
    {
		$user = Auth::guard('admin')->user();
		if (!$user || $user->user_type != 'admin') {
			return redirect()->route('admin.admin_list')->with('error', 'Bạn không có quyền phân quyền người dùng!');
		}
        $admin = Admin::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
		$user = Auth::guard('admin')->user();
		if (!$user || $user->user_type != 'admin') {
			return redirect()->route('admin.admin_list')->with('error', 'Bạn không có quyền phân quyền người dùng!');
		}
        $admin = Admin::findOrFail($id);

        // Validate the request...
		if (!empty($request->ingredient_name)) {
			$admin->user_type = $request->input('user_type');
		}
		if (!empty($request->ingredient_name)) {
			$admin->email = $request->input('email');
		}

        $admin->save();

        return redirect()->route('admin.admin_list', ['id' => $id])->with('success', 'Admin updated successfully!');
    }
	
	public function delete($id)
	{
		$user = Auth::guard('admin')->user();
		if (!$user || $user->user_type != 'admin') {
			return redirect()->route('admin.admin_list')->with('error', 'Bạn không có quyền xóa người dùng!');
		}
		$admin = Admin::findOrFail($id);

		// Xóa admin
		$admin->delete();

		return redirect()->route('admin.admin_list')->with('success', 'Admin đã được xóa thành công!');
	}
	
	
	
}
