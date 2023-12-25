<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Giỏ hàng</title>
	<style>
		.container h2{
			padding-top: 110px;
		}
		
		.container a{
			background-color: #75601c;
			padding: 10px;
			border-radius: 8px;
			color: #fff;
			text-decoration: none;
			font-weight: bold;
		}
		
		.container a:hover{
			text-decoration: none;
			color: #000;
		}

	</style>
    <!-- Các thẻ style và script cần thiết -->
</head>
<body>
	@extends('user.index')
	@section('content')
	<div class="container">
		<h2>Cảm ơn bạn đã mua hàng!</h2>
		<p>Đơn hàng của bạn đã được xử lý thành công. Chúng tôi sẽ gửi cho bạn một email xác nhận ngay lập tức.</p>
		<a href="{{ route('user.showinvoice', ['id' => $invoice->id]) }}">Xem hóa đơn</a>


		<a href="{{ route('user.index') }}">Quay lại trang chủ</a>
	</div>
	@endsection
</body>
</html>