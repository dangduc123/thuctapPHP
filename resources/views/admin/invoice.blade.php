<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
    <title>Product Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
		
		td .sua{
			background-color: #3452eb;
			text-decoration: none;
			color: white;
			padding: 5px;
			border-radius: 8px;
		}
		
		td .xoa{
			background-color: red;
			text-decoration: none;
			color: white;
			padding: 5px;
			border-radius: 8px;
		}
		
		h1{
			text-align: center;
			margin-top: 100px;
		}
		
		form{
			text-align: center;
		}
		
		form input:nth-child(1){
			height: 25px;
			margin-right: 5px;
			border-radius: 8px;
		}
		
		form input:nth-child(2){
			background-color:#111;
			padding: 2px;
			width: 40px;
			color: white;
			cursor: pointer;
			border-radius: 8px;
		}
		
		.container .pagination a{
			text-decoration: none;
			background-color: #111;
			color: #fff;
			padding: 10px;
			border-radius: 8px;
			font-weight: bold;
		}
		
		table, th, td {
			border: none;
		}
		
		table tr th{
			text-align: center;
		}
		
		table tr td{
			text-align: center;
		}
		
    </style>
	<script>
		function confirmDelete(id) {
			if (confirm("Bạn có chắc chắn muốn xóa đơn hàng này không?")) {
				// Nếu người dùng nhấn OK, hãy chuyển hướng đến URL xóa
				window.location.href = '/admin/delete/' + id;
			}
		}
	</script>
	<script>
		// Chờ cho đến khi tài liệu HTML hoàn toàn được tải xong
		document.addEventListener('DOMContentLoaded', function() {
			// Tìm tất cả các khối cảnh báo
			var alerts = document.querySelectorAll('.alert');

			// Duyệt qua từng khối cảnh báo
			alerts.forEach(function(alert) {
				// Đặt một hẹn giờ để ẩn khối cảnh báo sau 3 giây
				setTimeout(function() {
					alert.style.display = 'none';
				}, 3000);
			});
		});
	</script>
</head>
<body>
@extends('admin.index')
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div style="margin-top: 100px;" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <h1>Danh sách hóa đơn</h1>
	<form action="{{ route('invoice') }}" method="get">
		<input type="text" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}">
		<input type="submit" value="Tìm">
	</form>
    <table class="table table-striped">
        <thead>
            <tr>
				<th>STT</th>
                <th>Số hóa đơn</th>
                <th>Ngày lập</th>
                <th>Tên khách hàng</th>
                <th>Tên sản phẩm</th>
                <th>Số tiền mua</th>
                <th>Số lượng mua</th>
                <th>Tổng tiền</th>
                <th>Tạo lúc</th>
                <th>Cập nhật lúc</th>
				<th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
					<td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->date }}</td>
                    <td>{{ $invoice->user_name }}</td>
                    <td>{{ $invoice->product_name }}</td>
                    <td>{{ number_format($invoice->price, 0, ',', '.') }}đ</td>
                    <td>{{ $invoice->quantity }}</td>
                    <td>{{ number_format($invoice->total_price, 0, ',', '.') }}đ</td>
                    <td>{{ $invoice->created_at }}</td>
                    <td>{{ $invoice->updated_at }}</td>
					<td><a class="xoa" href="#" onclick="confirmDelete({{ $invoice->id }})">Xóa</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination" style="text-align: center; padding-top: 40px;">
		@if ($invoices->currentPage() > 1)
			<a href="{{ route('invoice', ['page' => $invoices->currentPage() - 1, 'search' => request('search')]) }}"><-</a>
		@endif
		
		@php
			$start = max(1, $invoices->currentPage() - 2);
			$end = min($invoices->lastPage(), $invoices->currentPage() + 2);
		@endphp

		@for ($i = $start; $i <= $end; $i++)
			<a href="{{ route('invoice', ['page' => $i, 'search' => request('search')]) }}" class="{{ $i == $invoices->currentPage() ? 'active' : '' }}">{{ $i }}</a>
		@endfor

		@if ($invoices->currentPage() < $invoices->lastPage())
			<a href="{{ route('invoice', ['page' => $invoices->currentPage() + 1, 'search' => request('search')]) }}">-></a>
		@endif
	</div>
</div>
@endsection

</body>
</html>
