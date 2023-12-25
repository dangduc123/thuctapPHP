<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::guard('user')->logout(); // Đăng xuất người dùng từ guard 'admin'
        return redirect('admin');
    }
	
	public function logout2()
    {
        Auth::guard('user')->logout(); // Đăng xuất người dùng từ guard 'admin'
        return redirect('user');
    }
}
