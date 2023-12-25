<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
    <title>Ingredient Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
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
				window.location.href = '/admin/delete_ingredient/' + id;
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
<h1>Danh sách nguyên liệu</h1>

    <form action="{{ route('admin.ingredient') }}" method="get">
        <input type="text" name="search" placeholder="Tìm kiếm...">
        <input type="submit" value="Tìm">
    </form>

    @if(count($ingredients) > 0)
        <table>
            <tr>
                <th>ID</th>
                <th>Tên nguyên liệu</th>
                <th>Số lượng</th>
                <th>Đơn vị</th>
                <th>Trạng thái</th>
                <th>Giá</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
            @foreach($ingredients as $ingredient)
                <tr>
                    <td>{{ $ingredient->id }}</td>
                    <td>{{ $ingredient->ingredient_name }}</td>
                    <td>{{ $ingredient->quantity }}</td>
                    <td>{{ $ingredient->unit }}</td>
                    <td>{{ $ingredient->status }}</td>
                    <td>{{ number_format($ingredient->price, 0, ',','.') }}đ</td>
                    <td>{{ $ingredient->created_at }}</td>
                    <td>{{ $ingredient->updated_at }}</td>
                    <td><a class="sua" href="{{ route('admin.edit_ingredient', ['id' => $ingredient->id]) }}">Sửa</a></td>
                    <td><a class="xoa" href="#" onclick="confirmDelete({{ $ingredient->id }})">Xóa</a></td>
                </tr>
            @endforeach
        </table>
		<div class="pagination" style="text-align: center; padding-top: 40px;">
			@if ($ingredients->currentPage() > 1)
				<a href="{{ route('admin.ingredient', ['page' => $ingredients->currentPage() - 1, 'search' => request('search')]) }}"><-</a>
			@endif
			
			@for ($i = 1; $i <= $ingredients->lastPage(); $i++)
				<a href="{{ route('admin.ingredient', ['page' => $i, 'search' => request('search')]) }}" class="{{ $i == $ingredients->currentPage() ? 'active' : '' }}">{{ $i }}</a>
			@endfor

			@if ($ingredients->currentPage() < $ingredients->lastPage())
				<a href="{{ routes('admin.ingredient', ['page' => $ingredients->currentPage() + 1, 'search' => request('search')]) }}">-></a>
			@endif
		</div>
    @else
        <p>Không có kết quả</p>
    @endif
@endsection

</body>
</html>