<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<title>Giỏ hàng</title>
	<style>
		
		.container{
			padding-top: 110px;
		}
	</style>
	<!-- Các thẻ style và script cần thiết -->
</head>
<body>
	@extends('user.index')

	@section('content')
		<h1>All Invoices</h1>

		@foreach ($invoices as $invoice)
			<div>
				<h2>Invoice ID: {{ $invoice->id }}</h2>
				<p>Date: {{ $invoice->date }}</p>
				<p>User ID: {{ $invoice->user_id }}</p>

				@foreach ($invoice->invoiceDetails as $detail)
					<div>
						<h3>Product ID: {{ $detail->product_id }}</h3>
						<p>Quantity: {{ $detail->quantity }}</p>
						<p>Price: {{ $detail->price }}</p>
						<p>Total Price: {{ $detail->total_price }}</p>
					</div>
				@endforeach
			</div>
		@endforeach
	@endsection

</body>
</html>