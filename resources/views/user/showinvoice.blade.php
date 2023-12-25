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
	<div class="container">
		<h2>Hóa đơn #{{ $invoice->id }}</h2>
		<p>Ngày: {{ $invoice->date }}</p>

		<h3>Chi tiết hóa đơn:</h3>
		@if($invoiceDetails->count() > 0)
			<?php $total = 0; ?>
			<table class="table">
				<thead>
					<tr>
						<th>Sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
						<th>Tổng tiền</th>
					</tr>
				</thead>
				<tbody>
					@foreach($invoiceDetails as $detail)
						<?php $total += $detail->total_price; ?>
						<tr>
							<td>{{ $detail->product->product_name }}</td>
							<td>{{ $detail->quantity }}</td>
							<td>{{ number_format($detail->price,0, ',', '.') }}đ</td>
							<td>{{ number_format($detail->total_price,0, ',','.') }}đ</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<p>Tổng tiền tất cả sản phẩm: {{ number_format($total, 0, ',', '.') }}đ</p>
		@else
			<p>Không có chi tiết hóa đơn nào.</p>
		@endif
	</div>
	@endsection

</body>
</html>