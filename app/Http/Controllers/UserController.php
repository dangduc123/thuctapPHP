<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\Cart; 
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\InvoiceDetail;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

use DB;

class UserController extends Controller
{
    public function index()
    {
		$user_id = Auth::guard('user')->id();
		$cartItems = Cart::where('user_id', $user_id)->get();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 
        return view('user.index', compact('cartQuantity', 'cartItems', 'revenue', 'currentTime'));
    }
	
	// public function showUserForm()
	// {
		// return view('user.user_list');
	// }
	
	public function index1(Request $request)
    {
		$perPage = 5;
         $users = User::with('roles');

        // Kiểm tra và thêm điều kiện tìm kiếm
        if ($request->has('search')) {
            $search = $request->input('search');
            $users->where('user.id', 'LIKE', "%$search%")
                ->orWhere('user.user_name', 'LIKE', "%$search%");
        }

        $users = $users->paginate($perPage);
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 
		$users = User::orderBy('updated_at', 'desc')->paginate(5);
		
        return view('user.user_list', compact('users', 'revenue', 'currentTime'));
    }
	
	public function showIntroduce()
	{
		$user_id = Auth::guard('user')->id();
		$cartItems = Cart::where('user_id', $user_id)->get();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		return view('user.introduce', compact('cartQuantity', 'cartItems'));
	}
	
	public function showMenu()
	{
		$user_id = Auth::guard('user')->id();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		$cartItems = Cart::where('user_id', $user_id)->get();
		return view('user.menu', compact('cartQuantity', 'cartItems'));
	}
	
	public function showByType($type)
	{
		$user_id = Auth::guard('user')->id();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		$cartItems = Cart::where('user_id', $user_id)->get();
		$products = Product::where('product_type', $type)->get();
		return view('user.products_by_type', compact('products', 'type',  'cartQuantity', 'cartItems'));
	}
	
	public function showCart()
	{
		if (!Auth::guard('user')->check()) {
			return redirect('/user/login');
		}

		$user_id = Auth::guard('user')->id();
		$cartItems = Cart::where('user_id', $user_id)->get();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		return view('user.cart', compact('cartItems', 'cartQuantity'));
	}
	
	public function showContact()
	{

		$user_id = Auth::guard('user')->id();
		$cartItems = Cart::where('user_id', $user_id)->get();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		return view('user.contact', compact('cartItems', 'cartQuantity'));
	}
	
	public function showThankYou($id){
		$invoice = Invoice::find($id);
		
		// Kiểm tra nếu hóa đơn không tồn tại
		if (!$invoice) {
			abort(404); // hoặc xử lý theo cách khác, ví dụ: return view('errors.404');
		}
		$invoiceDetails = $invoice->invoiceDetails;
		$user_id = Auth::guard('user')->id();
		$cartItems = Cart::where('user_id', $user_id)->get();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		return view('user.thank_you', compact('invoice', 'invoiceDetails', 'cartQuantity', 'cartItems'));
	}
	
	public function showInvoice($id)
	{
		// Tìm hóa đơn dựa trên id
		$invoice = Invoice::with('invoiceDetails')->find($id);

		// Kiểm tra xem hóa đơn có tồn tại không
		if (!$invoice) {
			return redirect()->route('user.index')->with('error', 'Hóa đơn không tồn tại');
		}

		// Lấy chi tiết hóa đơn
		$invoiceDetails = $invoice->invoiceDetails;
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		$user_id = Auth::guard('user')->id();
		$cartItems = Cart::where('user_id', $user_id)->get();
		// Trả về view với dữ liệu hóa đơn và chi tiết hóa đơn
		return view('user.showinvoice', compact('invoice', 'invoiceDetails', 'cartQuantity', 'cartItems'));
	}
	
	
	public function showInvoice2($id)
	{
		// Tìm hóa đơn dựa trên id
		$invoice = Invoice::with('invoiceDetails')->find($id);

		// Kiểm tra xem hóa đơn có tồn tại không
		if (!$invoice) {
			return redirect()->route('user.index')->with('error', 'Hóa đơn không tồn tại');
		}

		// Lấy chi tiết hóa đơn
		$invoiceDetails = $invoice->invoiceDetails;
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		$user_id = Auth::guard('user')->id();
		$cartItems = Cart::where('user_id', $user_id)->get();
		// Trả về view với dữ liệu hóa đơn và chi tiết hóa đơn
		return view('user.showinvoice2', compact('invoice', 'invoiceDetails', 'cartQuantity', 'cartItems'));
	}
	
	// public function showAllInvoice()
	// {
		// try {
			// // Lấy tất cả hóa đơn đã thanh toán của người dùng hiện tại
			// $invoices = Invoice::has('invoiceDetails')
				// ->where('user_id', Auth::guard('user')->id())
				// ->get();

			// // Trả về view với dữ liệu hóa đơn
			// return view('user.showallinvoice', compact('invoices'));
		// } catch (\Exception $e) {
			// // Xử lý lỗi nếu có
			// return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
		// }
	// }

	
	
	
	public function edit($id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'edit'))) {
			return redirect()->route('user.user_list')->with('error', 'Bạn không có quyền sửa khách hàng!');
		}
		$user = User::findOrFail($id);
		$roles = Role::all(); // Truy xuất tất cả vai trò
		$revenue = DB::table('invoicedetail')
            ->join('invoice', 'invoice.id', '=', 'invoicedetail.invoice_id')
            ->join('product', 'product.id', '=', 'invoicedetail.product_id')
            ->select('product.product_name', DB::raw('SUM(invoicedetail.total_price) as total_revenue'), DB::raw('SUM(invoicedetail.quantity) as total_quantity'))
			->whereMonth('invoice.date', '=', date('m')) 
            ->groupBy('product.product_name')
            ->get();
			
		$currentTime = now(); 
		return view('user.edit_user', compact('user', 'roles', 'revenue', 'currentTime')); // Truyền $roles vào view
	}


    public function update(Request $request, $id)
    {
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'edit'))) {
			return redirect()->route('user.user_list')->with('error', 'Bạn không có quyền sửa khách hàng!');
		}
        $user = User::findOrFail($id);

        // Validate the request...
		$request->validate([
			'email' => 'required|email',
			// các quy tắc xác thực khác...
		]);

        $user->user_name = $request->input('user_name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone_number');
        $user->save();
		if ($request->role === 'admin') {
			$role = Role::where('name', 'admin')->first();

			// Gán vai trò 'admin' cho người dùng
			$user->roles()->sync($request->input('role_id'));

			// Gán tất cả 3 quyền 'add', 'edit', và 'delete' cho 'admin'
			$permissions = Permission::whereIn('name', ['add', 'edit', 'delete'])->get();
			foreach ($permissions as $permission) {
				$role->permissions()->attach($permission);
			}
		} else {
			$role = Role::where('name', 'user')->first();
			// Gán vai trò 'user' cho người dùng
			$user->roles()->sync($request->input('role_id'));
		}
		
		// $user->roles()->sync($request->input('role_id'));

        return redirect()->route('user.user_list', ['id' => $id])->with('success', 'Khách hàng được chỉnh sửa thành công!');
    }
	
	// public function delete($id)
	// {
		// $user = Auth::guard('user')->user();
		// if (!$user || !$user->roles->contains('name', 'admin')) {
			// return redirect()->route('user.user_list')->with('error', 'Bạn không có quyền sửa khách hàng!');
		// }
		// $user = User::findOrFail($id);

		// // Xóa admin
		// $user->delete();

		// return redirect()->route('user.user_list')->with('success', 'Khách hàng đã được xóa thành công!');
	// }
	
	public function delete($id)
	{
		$user = Auth::guard('user')->user();
		if (!$user || !($user->roles->contains('name', 'admin') && $user->roles->first()->permissions->contains('name', 'delete'))) {
			return redirect()->route('user.user_list')->with('error', 'Bạn không có quyền xóa khách hàng!');
		}

		// Tìm người dùng có ID tương ứng trong cơ sở dữ liệu.
		$user = User::findOrFail($id);
		$invoice = Invoice::where('user_id', $id)->first();
		if ($invoice) {
			return redirect()->route('user.user_list')->with('error', 'Người dùng này còn trong hóa đơn. Bạn hãy xóa hóa đơn của người dùng này trước!');
		}

		// Xóa người dùng.
		$user->delete();

		// Chuyển hướng người dùng về trang danh sách người dùng và hiển thị thông báo thành công.
		return redirect()->route('user.user_list')->with('success', 'Khách hàng đã được xóa thành công!');
	}
	
	public function showProfile()
	{
		$user = Auth::guard('user')->user();
		$user_id = Auth::guard('user')->id();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		$cartItems = Cart::where('user_id', $user_id)->get();
		return view('user.profile', compact('user', 'cartQuantity', 'cartItems'));
	}

	public function updateProfile(Request $request)
	{
		$user = auth()->guard('user')->user();
		$user->update($request->all());
		return redirect()->back()->with('success', 'Profile updated successfully');
	}
	
	public function update_permissions(Request $request, $id)
	{
		$user = User::findOrFail($id); // Tìm người dùng theo ID

		// Lấy danh sách quyền từ yêu cầu
		$permissions = $request->input('permissions');

		// Duyệt qua tất cả vai trò của người dùng
		foreach ($user->roles as $role) {
			// Xóa tất cả quyền hiện tại của vai trò
			$role->permissions()->detach();

			// Duyệt qua tất cả quyền từ yêu cầu
			if (is_array($permissions) || is_object($permissions)) {
				foreach ($permissions as $permissionName) {
					// Tìm quyền trong cơ sở dữ liệu
					$permission = Permission::where('name', $permissionName)->first();

					// Nếu quyền tồn tại, gán quyền cho vai trò
					if ($permission) {
						$role->permissions()->attach($permission);
					}
				}
			} else {
				// Xử lý trường hợp $permissions không phải là mảng hoặc đối tượng
				echo "Error: \$permissions must be an array or object.";
			}
		}

		return redirect()->route('user.user_list', ['id' => $id])->with('success', 'Quyền được cập nhật thành công!');
	}
	
	
	
	
}
