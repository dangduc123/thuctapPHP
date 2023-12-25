<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ProductController {
    // public function showProductForm()
    // {
        // return view('admin.product');
    // }

    // public function product() {
        // // Truy vấn để lấy thông tin từ bảng sản phẩm
        // $products = DB::table('product')->get();

        // return $products;
    // }
	
	public function index(Request $request)
	{
		$perPage = 5;
		$products = Product::leftJoin('product_ingredient', 'product.id', '=', 'product_ingredient.product_id')
			->leftJoin('ingredient', 'product_ingredient.ingredient_id', '=', 'ingredient.id')
			->select('product.id', 'product.product_name', 'product.price', 'product.image', 'product.description', 'product.product_type', 'product.status', 'product.created_at', 'product.updated_at', \DB::raw('GROUP_CONCAT(ingredient.ingredient_name SEPARATOR \', \') as ingredients'))
			->groupBy('product.id', 'product.product_name', 'product.price', 'product.image', 'product.description', 'product.product_type', 'product.status', 'product.created_at', 'product.updated_at');

		// Kiểm tra và thêm điều kiện tìm kiếm
		if ($request->has('search')) {
			$search = $request->input('search');
			$products->where('product.id', 'like', '%' . $search . '%')
				->orWhere('product.product_name', 'like', '%' . $search . '%');
		}
		
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 

		// $products = $products->get();
		
		$products = $products->paginate($perPage);
		$users = User::orderBy('updated_at', 'desc')->paginate(5);
		return view('admin.product', compact('products', 'revenue', 'currentTime'));
	}
	
	
	public function createForm()
    {
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'add'))) {
			return redirect()->route('product')->with('error', 'Bạn không có quyền thêm sản phẩm!');
		}
        $ingredient = Ingredient::all();
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 
        return view('admin.create', compact('ingredient', 'revenue', 'currentTime'));
    }

    public function store(Request $request)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'add'))) {
			return redirect()->route('product')->with('error', 'Bạn không có quyền thêm sản phẩm!');
		}
		$request->validate([
			'product_name' => 'required|string|max:255',
			'price' => 'required|numeric',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'description' => 'nullable|string',
			'product_type' => 'required|string|max:255',
			'status' => 'required|in:active,inactive',
			'ingredient_id' => 'nullable|array',
			'ingredient_id.*' => 'exists:ingredient,id',
		]);

		$productData = $request->except('_token', 'image', 'ingredient_id');
		
		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageName = time() . '.' . $image->getClientOriginalExtension();
			$image->move(public_path('backend/img/'), $imageName);
			$productData['image'] = 'backend/img/' . $imageName;
		}
		
		$product = Product::create($productData);

		$ingredient_ids = $request->input('ingredient_id');
		foreach ($ingredient_ids as $ingredient_id) {
			DB::table('product_ingredient')->insert([
				'product_id' => $product->id,
				'ingredient_id' => $ingredient_id,
			]);
		}

		return redirect()->route('product')->with('success', 'Sản phẩm đã được thêm thành công!');
	}

	
	
	
	// public function edit_product($id)
    // {
		// $user = Auth::guard('admin')->user();
		// if (!$user || $user->user_type != 'admin') {
			// return redirect()->route('admin.product')->with('error', 'Bạn không có quyền sửa sản phẩm!');
		// }
        // $product = Product::findOrFail($id);
        // $ingredients = Ingredient::all();

        // return view('admin.edit_product', compact('product', 'ingredients'));
    // }

    // public function update_product(Request $request, $id)
    // {
		// $user = Auth::guard('admin')->user();
		// if (!$user || $user->user_type != 'admin') {
			// return redirect()->route('admin.product')->with('error', 'Bạn không có quyền sửa sản phẩm!');
		// }
        // $request->validate([
            // 'product_name' => 'required|string',
            // 'price' => 'required|numeric',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'description' => 'required|string',
            // 'product_type' => 'required|string',
            // 'status' => 'required|in:active,inactive',
            // 'ingredient_id' => 'required|exists:ingredient,id',
        // ]);

        // $product = Product::findOrFail($id);

        // // Xử lý và lưu thông tin sản phẩm từ $request vào $product

        // $product->update([
            // 'product_name' => $request->input('product_name'),
            // 'price' => $request->input('price'),
            // 'description' => $request->input('description'),
            // 'product_type' => $request->input('product_type'),
            // 'status' => $request->input('status'),
            // 'ingredient_id' => $request->input('ingredient_id'),
        // ]);

        // // Xử lý tệp ảnh nếu được cung cấp

        // if ($request->hasFile('image')) {
			// $image = $request->file('image');
            // $imageName = time() . '.' . $image->getClientOriginalExtension();
            // $image->move(public_path('backend/img/'), $imageName);
            // $productData['image'] = 'backend/img/' . $imageName;
			
			// $product->update(['image' => $productData['image']]);
		// }

        // // Chuyển hướng về trang danh sách sản phẩm hoặc trang chi tiết sản phẩm
        // return redirect()->route('admin.product')->with('success', 'Product updated successfully');
    // }
	
	
	public function edit_product($id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'edit'))) {
			return redirect()->route('product')->with('error', 'Bạn không có quyền sửa sản phẩm!');
		}
		
		// if (!$user || !$user->can('edit')) {
			// return redirect()->route('product')->with('error', 'Bạn không có quyền sửa sản phẩm!');
		// }
		$product = Product::findOrFail($id);
		$ingredients = Ingredient::all();
		$product_ingredients = DB::table('product_ingredient')->where('product_id', $id)->pluck('ingredient_id')->toArray();
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 

		return view('admin.edit_product', compact('product', 'ingredients', 'product_ingredients', 'revenue', 'currentTime'));
	}

	public function update_product(Request $request, $id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'edit'))) {
			return redirect()->route('product')->with('error', 'Bạn không có quyền sửa sản phẩm!');
		}
		$request->validate([
			'product_name' => 'required|string',
			'price' => 'required|numeric',
			'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'description' => 'required|string',
			'product_type' => 'required|string',
			'status' => 'required|in:active,inactive',
			'ingredient_id' => 'required|array',
			'ingredient_id.*' => 'exists:ingredient,id',
		]);

		$product = Product::findOrFail($id);

		// Xử lý và lưu thông tin sản phẩm từ $request vào $product

		$product->update([
			'product_name' => $request->input('product_name'),
			'price' => $request->input('price'),
			'description' => $request->input('description'),
			'product_type' => $request->input('product_type'),
			'status' => $request->input('status'),
		]);

		// Xử lý tệp ảnh nếu được cung cấp

		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageName = time() . '.' . $image->getClientOriginalExtension();
			$image->move(public_path('backend/img/'), $imageName);
			$productData['image'] = 'backend/img/' . $imageName;
			
			$product->update(['image' => $productData['image']]);
		}

		// Xử lý và lưu thông tin thành phần từ $request vào bảng product_ingredient

		DB::table('product_ingredient')->where('product_id', $id)->delete();

		$ingredient_ids = $request->input('ingredient_id');
		foreach ($ingredient_ids as $ingredient_id) {
			DB::table('product_ingredient')->insert([
				'product_id' => $product->id,
				'ingredient_id' => $ingredient_id,
			]);
		}

		// Chuyển hướng về trang danh sách sản phẩm hoặc trang chi tiết sản phẩm
		return redirect()->route('product')->with('success', 'Sản phẩm được cập nhật thành công');
	}
	
	public function delete_product($id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'delete'))) {
			return redirect()->route('product')->with('error', 'Bạn không có quyền xóa sản phẩm!');
		}
		$product = Product::findOrFail($id);

		// Kiểm tra xem sản phẩm có trong giỏ hàng không
		$cart = Cart::where('product_id', $id)->first();
		if ($cart) {
			return redirect()->route('product')->with('error', 'Sản phẩm đang còn trong giỏ hàng, không xóa được');
		}

		// Xóa hình ảnh liên quan nếu cần
		if (file_exists(public_path($product->image))) {
			unlink(public_path($product->image));
		}

		$product->delete();

		return redirect()->route('product')->with('success', 'Sản phẩm đã được xóa thành công');
	}
	
	// public function search(Request $request)
	// {
		// $search = $request->get('search');
		// $products = DB::table('product') // Sửa ở đây
					// ->where('product_name', 'like', '%' . $search . '%')
					// ->get();
		// return view('user.menu', ['products' => $products]);
	// }
}
