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
			width: 30%;
			display: block;
			margin: 0 auto;
			color: #fff;
			background-color: #75601c;
			border-radius: 25px;
			padding-bottom: 20px;
		}
		
		label{
			padding-bottom: -20px;
			color: #fff;
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
		
		.h1{
			color: #75601c;
			padding-top: 120px;
			text-align: center;
		}
		
		h1{
			padding-top: 20px;
		}
		
		form button{
			background-color: #fff;
			color: #75601c;
		}

	</style>
    <!-- Các thẻ style và script cần thiết -->
</head>

<body>
@extends('user.index')
@section('content')
<h1 class="h1">CHÀO MỪNG BẠN ĐẾN VỚI TIỆM CÀ PHÊ</h1>
<div class="form">
	<h1>THÔNG TIN CÁ NHÂN</h1>
	<form action="{{ route('user.updateProfile') }}" method="POST">
		@csrf
		<label for="user_name">Tên:</label><br>
		<input type="text" id="user_name" name="user_name" value="{{ $user->user_name }}"><br>
		<label for="email">Email:</label><br>
		<input type="email" id="email" name="email" value="{{ $user->email }}"><br>
		<label for="address">Địa chỉ:</label><br>
		<input type="text" id="address" name="address" value="{{ $user->address }}"><br>
		<label for="phone_number">Số điện thoại:</label><br>
		<input type="text" id="phone_number" name="phone_number" value="{{ $user->phone_number }}"><br>
		<button type="submit">Cập nhật</button>
	</form>
</div>
@endsection
</body>
</html>