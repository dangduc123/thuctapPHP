<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Mail::to($data['email'])->send(new ContactFormMail($data));
		Mail::to('duc.d.62cntt@ntu.edu.vn')->send(new ContactFormMail($data));
		
		$replyData = [
			'name' => $data['name'],
			'email' => $data['email'],
			'message' => 'Cảm ơn bạn đã liên hệ với Tiệm Cà Phê! Chúng tôi sẽ phản hồi sớm nhất có thể.',
		];

		// Gửi email phản hồi đến khách hàng
		Mail::to($data['email'])->send(new ContactFormMail($replyData));

        return back()->with('success_message', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }
	
	// public function store(Request $request)
	// {
		// // Lấy danh sách email của tất cả khách hàng từ cơ sở dữ liệu
		// $users = User::all();

		// foreach ($users as $user) {
			// // Tạo dữ liệu cho email
			// $data = $request->validate([
				// 'name' => 'required',
				// 'email' => $user->email,
				// 'phone_number' => 'required',
				// 'message' => 'required',
			// ]);
			

			// // Gửi email
			// Mail::to($user->email)->send(new ContactFormMail($data));
		// }

		// return back()->with('success_message', 'Email đã được gửi đến tất cả khách hàng.');
	// }

	
	
	public function verify($verification_code)
	{
		$user = User::where('verification_code', $verification_code)->first();

		if ($user) {
			$user->markEmailAsVerified();
			return redirect('/home')->with('status', 'Email của bạn đã được xác minh thành công!');
		}

		return redirect('/home')->with('status', 'Liên kết xác minh không hợp lệ hoặc đã hết hạn. Vui lòng thử lại.');
	}
	
	
	public function resend(Request $request)
	{
		if ($request->user() && $request->user()->hasVerifiedEmail()) {
			return redirect($this->redirectPath());
		}

		if ($request->user()) {
			$request->user()->sendEmailVerificationNotification();
		}

		return back()->with('resent', true);
	}

	
	
}

