<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('product_name', 'like', "%{$search}%")->get();
		$user_id = Auth::guard('user')->id();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		$cartItems = Cart::where('user_id', $user_id)->get();
		if ($products->isEmpty()) {
            $errorMessage = "Sản phẩm '{$search}' không có trong menu.";
            return view('user.menu', ['products' => $products, 'errorMessage' => $errorMessage]);
        }
        return view('user.menu', compact('products', 'cartQuantity', 'cartItems'));
    }
}
