<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
	
	public function showRegisterForm()
	{
		return view('admin.register');
	}
    public function register(Request $request)
	{
		// Validate the request...
		$validator = Validator::make($request->all(),[
			'email' => 'required|email',
			'password' => 'required|min:6',
		],[
			'password.min' => 'Mật khẩu ít nhất phải 6 ký tự'
		]);
		
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		// Check if the email already exists
		$existingAdmin = Admin::where('email', $request->email)->first();
		if ($existingAdmin) {
			return back()->withErrors(['email' => 'Email đã tồn tại']);
		}

		$admin = new Admin;
		$admin->email = $request->email;
		$admin->password = bcrypt($request->password); // Sử dụng hàm bcrypt()
		$admin->user_type = "subscriber";

		$admin->save();

		return redirect('admin/login');
	}
	
	public function showRegisterUserForm()
	{
		return view('user.register');
	}
	
	public function register_user(Request $request)
	{
		// Validate the request...
		$validator = Validator::make($request->all(),[
			'user_name' => 'required|max:255',
			'email' => 'required|email|unique:user',
			'password' => 'required|min:6',
			'address' => 'required|max:255',
			'phone_number' => 'required|max:15',
		],[
			'password.min' => 'Mật khẩu ít nhất phải 6 ký tự',
			'password.confirmed' => 'Mật khẩu xác nhận không khớp',
			'email.unique' => 'Email đã tồn tại',
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$user = new User;
		$user->user_name = $request->user_name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->address = $request->address;
		$user->phone_number = $request->phone_number;
		

		$user->save();
		
		// $role = Role::where('name', 'admin')->first();
		// $user->roles()->attach($role->id);
		
		// $permissions = Permission::whereIn('name', ['add', 'edit', 'delete'])->get();
		
		// foreach ($permissions as $permission) {
			// $role->permissions()->attach($permission);
		// }
		
		if ($request->role === 'admin') {
			$role = Role::where('name', 'admin')->first();
			$permissions = Permission::whereIn('name', ['add', 'edit', 'delete'])->get();
			foreach ($permissions as $permission) {
				if (!$role->permissions()->find($permission->id)) {
					$role->permissions()->attach($permission);
				}
			}
		} else {
			$role = Role::where('name', 'user')->first();

		}
		
		$user->roles()->attach($role->id);

		// Auth::login($user);

		return redirect('user')->with('success', 'Đăng ký thành công!');
	}

	
	
}
