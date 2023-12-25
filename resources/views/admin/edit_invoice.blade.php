<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
    <title>Chỉnh sửa đơn hàng</title>
	<style>
		h2{
			text-align: center;
		}
		
		form{
			margin:auto;
			text-align: center;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
			max-width: 400px; 
			padding-top: 20px;
			padding-bottom: 20px;
			border-radius: 8px;
			
		}
		
		input{
			margin-bottom: 10px;
			width: 300px;
			height: 30px;
			border-radius: 8px;
			display: block;
			margin: 0 auto;
		}
		
		select{
			margin-bottom: 10px;
			height: 30px;
			width: 100px;
			border-radius: 8px;
			display: block;
			margin: 0 auto;
		}
		
		textarea{
			margin-bottom: 10px;
			width: 300px;
			height: 100px;
			border-radius: 8px;
		}
		
		button{
			height: 30px;
			border-radius: 8px;
			background-color: #000;
			color: #fff;
			margin-top: 20px;
		}
	</style>
</head>
<body>
@extends('admin.index')
@section('content')
    <h2>Chỉnh sửa đơn hàng</h2>

    <form action="/admin/update_invoice/{{ $invoice->id }}" method="post">
        @csrf
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="{{ $invoice->date }}"><br>
        <label for="user_name">User Name:</label><br>
        <input type="text" id="user_name" name="user_name" value="{{ $user->user_name }}"><br>
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" value="{{ $product->product_name }}"><br>
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" value="{{ $invoicedetail->price }}"><br>
        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity" value="{{ $invoicedetail->quantity }}"><br>
        <label for="total_price">Total Price:</label><br>
        <input type="number" id="total_price" name="total_price" value="{{ $invoicedetail->total_price }}"><br>

        <button type="submit">Cập nhật đơn hàng</button>
    </form>
@endsection
</body>
</html>