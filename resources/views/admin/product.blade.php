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
		
		.pagination a{
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
			if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
				// Nếu người dùng nhấn OK, hãy chuyển hướng đến URL xóa
				window.location.href = '/admin/delete_product/' + id;
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
    <div style="margin-top: 100px;" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div style="margin-top: 100px;" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
	<h1>Danh sách sản phẩm</h1>
    <form action="{{ route('product') }}" method="get">
        <input type="text" name="search" placeholder="Tìm kiếm...">
        <input type="submit" value="Tìm">
    </form>

    @if(count($products) > 0)
        <table>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh sản phẩm</th>
                <th>Mô tả</th>
                <th>Loại sản phẩm</th>
                <th>Trạng thái</th>
                <th>Nguyên liệu</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                    <td>
                        <img src="{{ asset($product->image) }}" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                    </td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->product_type }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->ingredients }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->updated_at }}</td>
                    <td><a class="sua" href="{{ route('admin.edit_product', ['id' => $product->id]) }}">Sửa</a></td>
                    <td><a class="xoa" href="#" onclick="confirmDelete({{ $product->id }})">Xóa</a></td>
                </tr>
            @endforeach
        </table>
		<div class="pagination" style="text-align: center; padding-top: 40px;">
			@if ($products->currentPage() > 1)
				<a href="{{ route('product', ['page' => $products->currentPage() - 1, 'search' => request('search')]) }}"><-</a>
			@endif
			
			@for ($i = 1; $i <= $products->lastPage(); $i++)
				<a href="{{ route('product', ['page' => $i, 'search' => request('search')]) }}" class="{{ $i == $products->currentPage() ? 'active' : '' }}">{{ $i }}</a>
			@endfor

			@if ($products->currentPage() < $products->lastPage())
				<a href="{{ route('product', ['page' => $products->currentPage() + 1, 'search' => request('search')]) }}">-></a>
			@endif
		</div>
    @else
        <p>Không có kết quả tìm kiếm</p>
    @endif
@endsection

</body>
</html>
