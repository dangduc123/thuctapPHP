<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Auth;

class CartController extends Controller
{
	// public function addToCart(Request $request)
	// {
		// if (!Auth::guard('user')->check()) {
			// return redirect('/user/login');
		// }

		// $product_id = $request->input('product_id');
		// $quantity = $request->input('quantity'); // Lấy số lượng từ yêu cầu
		// $user = Auth::guard('user')->user(); // Lấy thông tin người dùng hiện tại

		// $product = Product::find($product_id);

		// if (!$product) {
			// return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại'], 404);
		// }

		// $cartItem = Cart::where('product_id', $product_id)->where('user_id', $user ? $user->id : null)->first();

		// if ($cartItem) {
			// $cartItem->quantity += $quantity;
		// } else {
			// $cartItem = new Cart([
				// 'product_id' => $product_id,
				// 'user_id' => $user ? $user->id : null,
				// 'quantity' => $quantity,
				// 'price' => $product->price,
			// ]);
		// }

		// $cartItem->save();
		// $request->session()->flash('success', 'Sản phẩm đã được thêm vào giỏ hàng thành công!');
		// return redirect('/user/menu');
	// }
	public function addToCart(Request $request)
	{
		if (!Auth::guard('user')->check()) {
			return response()->json(['redirect' => '/user/login'], 401);
		}

		$product_id = $request->input('product_id');
		$quantity = $request->input('quantity'); // Lấy số lượng từ yêu cầu
		$user = Auth::guard('user')->user(); // Lấy thông tin người dùng hiện tại
		
		if ($quantity <= 0) {
			return response()->json(['success' => false, 'message' => 'Số lượng phải lớn hơn 0.']);
		}
		
		if ($quantity > 50) {
			return response()->json(['success' => false, 'message' => 'Số lượng phải bé hơn hoặc bằng 50.']);
		}

		$product = Product::find($product_id);

		if (!$product) {
			return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại'], 404);
		}

		$cartItem = Cart::where('product_id', $product_id)->where('user_id', $user ? $user->id : null)->first();

		// Kiểm tra xem số lượng hiện tại cộng với số lượng muốn thêm vào có vượt quá 50 không
		if ($cartItem && $cartItem->quantity + $quantity > 50) {
			return response()->json(['success' => false, 'message' => 'Số lượng của 1 sản phẩm trong giỏ hàng không được vượt quá 50.']);
		} else {
			if ($cartItem) {
				$cartItem->quantity += $quantity;
			} else {
				$cartItem = new Cart([
					'product_id' => $product_id,
					'user_id' => $user ? $user->id : null,
					'quantity' => $quantity,
					'price' => $product->price,
				]);
			}

			$cartItem->save();

			$cartItems = Cart::where('user_id', $user ? $user->id : null)->get();
			$cartHTML = '<table>';
			$cartHTML .= '<tr><th>Ảnh</th><th>Tên sản phẩm</th><th>Số lượng</th><th>Tổng tiền</th></tr>';

			foreach ($cartItems as $cartItem) {
				$cartHTML .= '<tr>';
				$cartHTML .= '<td><img src="' . asset($cartItem->product->image) . '" alt="Product Image"></td>';
				$cartHTML .= '<td>' . $cartItem->product->product_name . '</td>';
				$cartHTML .= '<td>' . $cartItem->quantity . '</td>';
				$cartHTML .= '<td>' . number_format($cartItem->price * $cartItem->quantity, 0, ',', '.') . 'đ</td>';
				$cartHTML .= '</tr>';
			}

			$cartHTML .= '</table>';
			$cartHTML .= '<a style="color: #000;" href="/user/cart">Xem tất cả</a>';
			return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng thành công', 'cartItems' => $cartItems, 'cartHTML' => $cartHTML]);
		}
	}


	
	
	public function removeFromCart($id, Request $request)
	{
		// Tìm mục giỏ hàng bằng ID
		$cartItem = Cart::find($id);

		// Kiểm tra xem mục giỏ hàng có tồn tại không
		if (!$cartItem) {
			return response()->json(['success' => false, 'message' => 'Mục giỏ hàng không tồn tại'], 404);
		}

		// Xóa mục giỏ hàng
		$cartItem->delete();
		$user = Auth::guard('user')->user(); // Lấy thông tin người dùng hiện tại
		$cartItems = Cart::where('user_id', $user ? $user->id : null)->get();

		// Tạo HTML mới cho giỏ hàng
		if (count($cartItems) > 0) {
			$cartHTML = '<table>';
			$cartHTML .= '<tr><th>Ảnh</th><th>Tên sản phẩm</th><th>Số lượng</th><th>Tổng tiền</th></tr>';

			foreach ($cartItems as $cartItem) {
				$cartHTML .= '<tr>';
				$cartHTML .= '<td><img src="' . asset($cartItem->product->image) . '" alt="Product Image"></td>';
				$cartHTML .= '<td>' . $cartItem->product->product_name . '</td>';
				$cartHTML .= '<td>' . $cartItem->quantity . '</td>';
				$cartHTML .= '<td>' . number_format($cartItem->price * $cartItem->quantity, 0, ',', '.') . 'đ</td>';
				$cartHTML .= '</tr>';
			}

			$cartHTML .= '</table>';
			$cartHTML .= '<a style="color: #000;" href="/user/cart">Xem tất cả</a>';
		}else {
			$cartHTML = 'Giỏ hàng trống';
		}
		
		$total_all_price = 0;
		$cartItems = Cart::where('user_id', Auth::guard('user')->id())->get();
		foreach ($cartItems as $item) {
			$total_all_price += $item->quantity * $item->price;
		}

		// Trả về một thông báo thành công
		// $request->session()->flash('success', 'Sản phẩm đã được xóa khỏi giỏ hàng thành công!');
		// return redirect('/user/cart');
		return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng thành công', 'cartHTML' => $cartHTML, 'total_all_price' => $total_all_price]);
	}
	
	// public function index()
	// {
		// $cartQuantity = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
		// return view('index', compact('cartQuantity'));
	// }
	
	
	public function updateQuantity(Request $request) {
		$id = $request->input('id');
		$quantityChange = $request->input('quantityChange');

		// Lấy sản phẩm từ giỏ hàng
		$cartItem = Cart::find($id);

		// Cập nhật số lượng
		$cartItem->quantity += $quantityChange;
		if ($cartItem->quantity === 0) {
			$cartItem->delete();
		} else {
			// Lưu thay đổi vào cơ sở dữ liệu
			$cartItem->save();
		}
		$total_price = $cartItem->quantity * $cartItem->price;
		// // Lưu thay đổi vào cơ sở dữ liệu
		// $cartItem->save();
		
		$total_all_price = 0;
		$cartItems = Cart::where('user_id', Auth::guard('user')->id())->get();
		foreach ($cartItems as $item) {
			$total_all_price += $item->quantity * $item->price;
		}
		

		// Trả về số lượng mới để cập nhật giao diện người dùng
		return response()->json(['newQuantity' => $cartItem->quantity , 'total_price' => number_format($total_price, 0, ',', '.'), 'total_all_price' => number_format($total_all_price, 0, ',', '.')]);
	}
	
	
	// public function update(Request $request, $id)
	// {
		// $quantity = $request->quantity;

		// // Tìm sản phẩm trong giỏ hàng dựa trên $id
		// $cartItem = Cart::find($id);

		// if($cartItem) {
			// $cartItem->quantity = $quantity;
			// $cartItem->save();
		// }

		// // Tính toán tổng số lượng sản phẩm trong giỏ hàng
		// $totalQuantity = Cart::where('user_id', auth()->id())->sum('quantity');

		// return response()->json([
			// 'totalQuantity' => $totalQuantity
		// ]);
	// }
	



	
	
}
