<div style="width: 600px; margin: 0 auto">
	<div style="text-align: center">
		<h2>Xin chào {{$user->user_name}}</h2>
		<p>Email này để giúp bạn lấy lại mật khẩu tài khoản đã bị quên</p>
		<p>Vui lòng click vào link dưới đây để đặt lại mật khẩu</p>
		<p>Chú ý: mã xác nhận trong link chỉ có hiệu lực trong 72 giờ</p>
		<p>
			<a href="{{route('user.reset-password', ['user' => $user->id, 'token' => $user->reset_token_hash])}}"
				style="display: inline-block; background-color: green; color: #fff; padding: 7px 25px; font-weight: bold">Đặt lại mật khẩu</a>
		</p>
	</div>
</div>