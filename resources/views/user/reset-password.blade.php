<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Giỏ hàng</title>
	<style>
		.form{
			text-align: center;
			margin-top: 120px;
			padding-top: 120px;
			width: 30%;
			display: block;
			margin: 0 auto;
		}
		
		label{
			padding-bottom: -20px;
			color: #75601c;
			font-weight: bold;
		}
		
		input{
			width: 300px;
			border-radius: 8px;
			height: 40px;
			border: 1px solid #75601c;
			outline: 1px solid #75601c;
		}
		
		form button{
			margin-top: 20px;
			border-radius: 8px;
			height: 40px;
			background-color: #75601c;
			color: #fff;
			font-weight: bold;
			border: none;
		}
		
		.form h1{
			color: #75601c;
		}

	</style>
    <!-- Các thẻ style và script cần thiết -->
</head>

<body>
@extends('user.index')
@section('content')
@if(session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" role="alert">
        {{ $errors->first() }}
    </div>
@endif
<div class="form">
	<h1>Đặt lại mật khẩu</h1>
	<form method="POST" action="">
		@csrf

		<label for="password">New Password</label>
		<input id="password" type="password" name="password" required>

		<label for="password_confirmation">Confirm Password</label>
		<input id="password_confirmation" type="password" name="password_confirmation" required>

		<button type="submit">Reset Password</button>
	</form>
</div>
@endsection
</body>
</html>