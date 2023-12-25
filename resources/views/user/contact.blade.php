<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <title>Liên hệ</title>
	<style>
		
		.form{
			margin-left: 20px;
			text-align: center;
			background-color: #75601c;
			width: 50%;
			display: block;
			margin: 0 auto;
			border-radius: 20px;
		} 
		
		
		
		label{
			font-weight: bold;
			color: #fff;
		}
		
		.contact{
			text-align: center;
		}
		
		.contact ul li{
			list-style: none;
		}
		
	</style>
</head>
<body>
@extends('user.index')
@section('content')
	<div class="contact">
		<label style="margin-top: 110px;"><h3 style="color: #000;">Tiệm Cà Phê - Quán cà phê tại Nha Trang</h3></label><br>
		<p>Quý khách cần đặt thức uống, vui lòng liên hệ số điện thoại hoặc chat qua zalo với đội ngũ nhân viên của Tiệm Cà Phê:</p>
		<ul>
			<li>Điện thoại: 0817 477 487</li>
			<li>Zalo: 0817 477 487</li>
			<li>Fanpage: <a href="https://www.facebook.com/TiemCaPheNT">Tiệm Cà Phê</a></li>
			<li>Địa chỉ: 30/17 Đoàn Trần Nghiệp, Vĩnh Phước, Nha Trang, Khánh Hòa 650000</li>
		</ul>
	</div>
    <form class="form" action="{{ route('user.contact') }}" method="post">
        @csrf
		<h1 style="color: #fff;">LIÊN HỆ</h1>
        <label  for="name">Tên của bạn:</label><br>
        <input style="height: 30px; width: 500px; border-radius: 8px; border: 1px solid #75601c; outline: 1px solid #75601c;" type="text" id="name" name="name"><br>
        <label for="email">Email của bạn:</label><br>
        <input style="height: 30px; width: 500px; border-radius: 8px; border: 1px solid #75601c; outline: 1px solid #75601c;" type="email" id="email" name="email"><br>
        <label for="message">Tin nhắn của bạn:</label><br>
        <textarea style="height: 400px; width: 500px; border-radius: 8px; border: 1px solid #75601c; outline: 1px solid #75601c;" id="message" name="message"></textarea><br>
        <input style="margin: 20px; border-radius: 8px; color: #75601c; border: none; height: 30px; background-color: #fff; font-weight: bold;" type="submit" value="Gửi liên hệ">
    </form>
	<div id="mapid" style="height: 500px; text-align: center; margin-top: 30px;">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.655254823767!2d109.19677807057901!3d12.27159310330555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317067cfff3c8e6b%3A0x30ca78107af226e2!2zVGnhu4dtIGPDoCBwaMOq!5e0!3m2!1svi!2s!4v1702869783840!5m2!1svi!2s" width="60%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>
	

@endsection
</body>
</html>
