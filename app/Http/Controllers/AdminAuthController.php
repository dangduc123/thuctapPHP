<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }
	
	public function login(Request $request)
	{
		// validate the form data
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required|min:6'
		], [
			'password.min' => 'Mật khẩu ít nhất phải 6 ký tự'
		]);
		
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		// attempt to log the user in
		if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
			// if successful, then redirect to their intended location
			return redirect()->intended(route('admin.index'));
		} 

		// if unsuccessful, then redirect back to the login with the form data
		return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['error'=>'Email hoặc mật khẩu không chính xác']);
	}
	
	public function showLoginUserForm()
	{
		return view('user.login');
	}
	
	public function login_user(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required|min:6'
		], [
			'password.min' => 'Mật khẩu ít nhất phải 6 ký tự'
		]);
		
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}
		
		if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
			// if successful, then redirect to their intended location
			return redirect()->intended(route('user.index'));
		} 
		
		return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['error'=>'Email hoặc mật khẩu không chính xác']);
	}
	
	
	// public function forgotPassword(Request $request)
	// {
		// $user = User::where('email', $request->email)->first();

		// if ($user) {
			// $token = Str::random(60);  // generate a random token
			// $user->reset_token_hash = bcrypt($token);  // use bcrypt to hash the token
			// $user->reset_token_expires_at = now()->addMinutes(60);  // the token expires after 60 minutes
			// $user->save();

			// Mail::send('emails.forgot-password', ['token' => $token], function ($message) use ($user) {
				// $message->to($user->email);
				// $message->subject('Reset Password Notification');
			// });

			// return back()->with('status', 'We have e-mailed your password reset link!');
		// }

		// return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
	// }
	
	
	// public function resetPassword(Request $request)
	// {
		// $request->validate([
			// 'token' => 'required',
			// 'email' => 'required|email',
			// 'password' => 'required|min:8|confirmed',
		// ]);

		// $user = User::where('email', $request->email)->first();

		// if ($user && password_verify($request->token, $user->reset_token_hash) && $user->reset_token_expires_at > now()) {
			// $user->password = Hash::make($request->password);
			// $user->reset_token_hash = null;
			// $user->reset_token_expires_at = null;
			// $user->save();

			// return back()->with('status', 'Your password has been reset!');
		// }

		// return back()->withErrors(['email' => 'Invalid token or email address.']);
	// }
	
	public function forgetPass()
	{
		$user_id = Auth::guard('user')->id();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
		$cartItems = Cart::where('user_id', $user_id)->get();
		return view('user.forgot-password', compact('cartQuantity', 'cartItems'));
	}
	
	public function postForgetPass(Request $req)
	{
		$req->validate([
			'email' => 'required|exists:user'
		],[
			'email.required' => 'Vui lòng nhập địa chỉ email hợp lệ',
			'email.exists' => 'Email này không tồn tại trong hệ thống',
		]);
		$token = strtoupper(Str::random(10));
		$user = User::where('email', $req->email)->first();
		$user->update(['reset_token_hash' => $token]);
		
		
		Mail::send('emails.check_email_forget', compact('user'), function($email) use($user){
			$email->subject('Tiệm Cà Phê - Xác nhận tài khoản');
			$email->to($user->email, $user->user_name);
		});
		return redirect()->back()->with('yes', 'Vui lòng check email để thực hiện thay đổi mật khẩu');
			
	}
	
	public function getPass(User $user, $token)
	{
		if($user->reset_token_hash === $token){
			$user_id = Auth::guard('user')->id();
			$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
			$cartItems = Cart::where('user_id', $user_id)->get();
			return view('user.reset-password', compact('cartQuantity', 'cartItems'));
		}
		return abort(404);
	}
	
	public function postGetPass(User $user, $token, Request $req)
	{
		$req->validate([
			'password' => 'required',
		]);
		
		$password_h = bcrypt($req->password);
		$user->update(['password' => $password_h, 'reset_token_hash' => null]);
		return redirect()->route('user.login')->with('yes', 'Đổi mật khẩu thành công');
	}

	
	
	
}