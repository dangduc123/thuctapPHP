<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Ingredient;
use App\Models\User;

class IngredientController extends Controller
{
    // public function showIngredientForm()
    // {
		// return view('admin.ingredient');
		// // $user = Auth::guard('admin')->user();
		// // if (!$user || $user->user_type != 'admin') {
			// // return redirect()->route('admin.ingredient')->with('error', 'Bạn không có quyền vào phần này!');
		// // }
        
    // }

    // public function ingredient() {
        // // Truy vấn để lấy thông tin từ bảng sản phẩm
        // $ingredients = DB::table('ingredient')->get();

        // return $ingredients;
    // }
	
	public function index(Request $request)
    {
		$perPage = 5;
        $ingredients = Ingredient::select('id', 'ingredient_name', 'quantity', 'unit', 'status', 'price', 'created_at', 'updated_at');

        // Kiểm tra và thêm điều kiện tìm kiếm
        if ($request->has('search')) {
            $search = $request->input('search');
            $ingredients->where('id', 'LIKE', "%$search%")
                ->orWhere('ingredient_name', 'LIKE', "%$search%");
        }

        $ingredients = $ingredients->paginate($perPage);
		
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 
		$users = User::orderBy('updated_at', 'desc')->paginate(5);
        return view('admin.ingredient', compact('ingredients', 'revenue', 'currentTime'));
    }
	
	public function createForm()
    {
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'add'))) {
			return redirect()->route('admin.ingredient')->with('error', 'Bạn không có quyền thêm nguyên liệu!');
		}
		
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 
        return view('admin.add_ingredient', compact('revenue', 'currentTime'));
    }
	
	public function store(Request $request)
    {
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'add'))) {
			return redirect()->route('admin.ingredient')->with('error', 'Bạn không có quyền thêm nguyên liệu!');
		}
        $ingredient = new Ingredient;

        $ingredient->ingredient_name = $request->ingredient_name;
        $ingredient->quantity = $request->quantity;
        $ingredient->unit = $request->unit;
        $ingredient->status = $request->status;
        $ingredient->price = $request->price;

        $ingredient->save();

        return redirect()->route('admin.ingredient')->with('success', 'Nguyên liệu đã được thêm thành công!');
    }
	
	public function edit($id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'edit'))) {
			return redirect()->route('admin.ingredient')->with('error', 'Bạn không có quyền sửa nguyên liệu!');
		}

		$ingredient = Ingredient::find($id);
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 

		return view('admin.edit_ingredient', compact('ingredient', 'revenue', 'currentTime'));
	}

	public function update_ingredient(Request $request, $id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'edit'))) {
			return redirect()->route('admin.ingredient')->with('error', 'Bạn không có quyền sửa nguyên liệu!');
		}

		$ingredient = Ingredient::findOrFail($id);

		if (!empty($request->ingredient_name)) {
			$ingredient->ingredient_name = $request->ingredient_name;
		}
		if (!empty($request->quantity)) {
			$ingredient->quantity = $request->quantity;
		}

		if (!empty($request->unit)) {
			$ingredient->unit = $request->unit;
		}

		if (!empty($request->status)) {
			$ingredient->status = $request->status;
		}

		if (!empty($request->price)) {
			$ingredient->price = $request->price;
		}

		$ingredient->save();

		return redirect()->route('admin.ingredient')->with('success', 'Nguyên liệu đã cập nhật thành công');
	}
	
	public function delete($id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'delete'))) {
			return redirect()->route('admin.ingredient')->with('error', 'Bạn không có quyền xóa nguyên liệu!');
		}

		$ingredient = Ingredient::findOrFail($id);

		// Xóa nguyên liệu
		$ingredient->delete();

		return redirect()->route('admin.ingredient')->with('success', 'Nguyên liệu đã được xóa thành công!');
	}


	
	
}
