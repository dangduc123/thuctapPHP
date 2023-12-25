<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Cart;
use App\Models\InvoiceDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThankYouForYourOrder;
use Auth;

class CheckoutController extends Controller
{
	
	
    // public function processCheckout(Request $request)
	// {
		// // Tạo một invoice mới
		// $paymentData = $request->all();
		// $invoice = new Invoice;
		// $invoice->date = date('Y-m-d H:i:s'); // Đặt ngày hiện tại cho invoice
		// $invoice->user_id = Auth::guard('user')->id(); // Đặt id của người dùng hiện tại cho invoice
		// $invoice->save(); // Lưu invoice

		// // Lấy thông tin từ giỏ hàng
		// $cartItems = Cart::content();

		// // Duyệt qua từng sản phẩm trong giỏ hàng và tạo một invoicedetail cho mỗi sản phẩm
		// foreach ($cartItems as $item) {
			// $invoiceDetail = new InvoiceDetail;
			// $invoiceDetail->invoice_id = $invoice->id; // Đặt id của invoice vừa tạo

			// // Kiểm tra xem $item có chứa 'model' không trước khi truy cập 'model->id'
			// if (isset($item['model']) && is_object($item['model'])) {
				// $invoiceDetail->product_id = $item['model']->id; // Đặt id của sản phẩm
			// } else {
				// // Xử lý trường hợp $item không chứa 'model'
				// // Hoặc có thể throw một exception để báo lỗi nếu cần
				// continue; // Skip iteration
			// }

			// $invoiceDetail->quantity = $item['qty']; // Đặt số lượng của sản phẩm
			// $invoiceDetail->price = $item['price']; // Đặt giá của sản phẩm
			// $invoiceDetail->total_price = $item['qty'] * $item['price']; // Tính tổng tiền
			// $invoiceDetail->save(); // Lưu invoicedetail
		// }

		// // Xóa giỏ hàng sau khi thanh toán
		// Session::forget('cart');

		// // Chuyển hướng người dùng đến trang cảm ơn hoặc trang hóa đơn
		// return redirect()->route('user.thank_you', ['id' => $invoice->id]);
	// }
	
	public function processCheckout(Request $request)
	{
		// Tạo một invoice mới
		$invoice = new Invoice;
		$invoice->date = date('Y-m-d H:i:s'); // Đặt ngày hiện tại cho invoice
		$invoice->user_id = Auth::guard('user')->id(); // Đặt id của người dùng hiện tại cho invoice
		$invoice->save(); // Lưu invoice

		// Lấy tất cả các mục từ giỏ hàng
		$cartItems = Cart::where('user_id', Auth::guard('user')->id())->get();

		foreach ($cartItems as $cartItem) {
			// Tạo một invoicedetail cho mỗi sản phẩm
			$invoiceDetail = new InvoiceDetail;
			$invoiceDetail->invoice_id = $invoice->id; // Đặt id của invoice vừa tạo
			$invoiceDetail->product_id = $cartItem->product_id; // Đặt id của sản phẩm
			$invoiceDetail->quantity = $cartItem->quantity; // Đặt số lượng của sản phẩm
			$invoiceDetail->price = $cartItem->price; // Đặt giá của sản phẩm
			$invoiceDetail->total_price = $cartItem->quantity * $cartItem->price; // Tính tổng tiền
			// Lưu invoicedetail
			$invoiceDetail->save();
			// Xóa sản phẩm khỏi giỏ hàng sau khi thanh toán
			$cartItem->delete();
			 
			
		}
		//Gửi email cảm ơn khách hàng
		$userEmail = Auth::guard('user')->user()->email; // Lấy email của khách hàng
		Mail::to($userEmail)->send(new ThankYouForYourOrder($invoice));

		// Chuyển hướng người dùng đến trang cảm ơn hoặc trang hóa đơn
		return redirect()->route('user.thank_you', ['id' => $invoice->id]);
	}
	
	public function processCheckout2(Request $request, $productId)
	{
		// Tạo một invoice mới
		$invoice = new Invoice;
		$invoice->date = date('Y-m-d H:i:s'); // Đặt ngày hiện tại cho invoice
		$invoice->user_id = Auth::guard('user')->id(); // Đặt id của người dùng hiện tại cho invoice
		$invoice->save(); // Lưu invoice

		// Lấy sản phẩm từ giỏ hàng
		$cartItem = Cart::where('user_id', Auth::guard('user')->id())
						->where('product_id', $productId)
						->first();

		if ($cartItem) {
			// Tạo một invoicedetail cho sản phẩm
			$invoiceDetail = new InvoiceDetail;
			$invoiceDetail->invoice_id = $invoice->id; // Đặt id của invoice vừa tạo
			$invoiceDetail->product_id = $cartItem->product_id; // Đặt id của sản phẩm
			$invoiceDetail->quantity = $cartItem->quantity; // Đặt số lượng của sản phẩm
			$invoiceDetail->price = $cartItem->price; // Đặt giá của sản phẩm
			$invoiceDetail->total_price = $cartItem->quantity * $cartItem->price; // Tính tổng tiền
			// Lưu invoicedetail
			$invoiceDetail->save();
			// Xóa sản phẩm khỏi giỏ hàng sau khi thanh toán
			$cartItem->delete();
		}
		
		$userEmail = Auth::guard('user')->user()->email; // Lấy email của khách hàng
		Mail::to($userEmail)->send(new ThankYouForYourOrder($invoice));

		// Chuyển hướng người dùng đến trang cảm ơn hoặc trang hóa đơn
		return redirect()->route('user.thank_you', ['id' => $invoice->id]);
	}

	
	
	// public function processAll()
	// {
		// try {
			// // Lấy tất cả các mục trong giỏ hàng của người dùng
			// // $cartItems = Cart::where('user_id', Auth::guard('user')->id())->get();
			// $cartItems = Cart::all();
			// // Tạo hóa đơn mới
			// $invoice = new Invoice;
			// $invoice->date = date('Y-m-d H:i:s');
			// $invoice->user_id = Auth::guard('user')->id();
			// $invoice->save();

			// // Xử lý thanh toán cho từng mục trong giỏ hàng
			// foreach ($cartItems as $cartItem) {
				// // Kiểm tra xem chi tiết hóa đơn đã tồn tại chưa
				// $existingDetail = InvoiceDetail::where('invoice_id', $invoice->id)
					// ->where('product_id', $cartItem->product_id)
					// ->first();

				// if ($existingDetail) {
					// // Nếu chi tiết hóa đơn đã tồn tại, bạn có thể cập nhật thông tin nếu cần thiết,
					// // hoặc bỏ qua nếu không muốn thực hiện thêm một lần nữa.
					// $existingDetail->quantity += $cartItem->quantity;
					// $existingDetail->total_price += $cartItem->quantity * $cartItem->product->price;
					// $existingDetail->save();
				// } else {
					// // Nếu chi tiết hóa đơn chưa tồn tại, tạo mới và lưu vào cơ sở dữ liệu
					// $invoiceDetail = new InvoiceDetail;
					// $invoiceDetail->invoice_id = $invoice->id;
					// $invoiceDetail->product_id = $cartItem->product_id;
					// $invoiceDetail->quantity = $cartItem->quantity;
					// $invoiceDetail->price = $cartItem->product->price;
					// $invoiceDetail->total_price = $cartItem->quantity * $cartItem->product->price;
					// $invoiceDetail->save();
				// }

				// // Xóa mục khỏi giỏ hàng
				// $cartItem->delete();
			// }
			

			// // Redirect hoặc trả về thông báo thanh toán thành công
			// return redirect()->route('user.showallinvoice')->with('success', 'Đã thanh toán mua hết sản phẩm trong giỏ hàng.');
		// } catch (\Illuminate\Database\QueryException $e) {
			// // Xử lý lỗi ở đây
			// if ($e->getCode() == 23000) {
				// // Trường hợp lỗi trùng lặp
				// return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
			// }
		// } catch (\Exception $e) {
			// // Xử lý các lỗi khác
			// return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
		// }
	// }


}
