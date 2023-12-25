<!-- resources/views/products/edit_product.blade.php -->
@php
    if (!Auth::check() || Auth::user()->user_type == 'subscriber') {
        abort(403, 'Bạn không có quyền truy cập vào phần này.');
    }
@endphp
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
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
		}
		
		select{
			margin-bottom: 10px;
		}
		
		textarea{
			margin-bottom: 10px;
			width: 300px;
			height: 100px;
			border-radius: 8px;
		}
	</style>
    <title>Product Information</title>
</head>
<body>
	@can('access-user')
	@extends('admin.index') <!-- Đảm bảo rằng layout của bạn đã được tạo -->

	@section('content')
		<div class="container">
			<h2>Xóa sản phẩm</h2>
			<form method="POST" action="{{ route('admin.delete_product', $product->id) }}" id="deleteProductForm">
				@csrf
				@method('DELETE')

				<div class="form-group">
					<label for="product_name">Tên sản phẩm:</label>
					<input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" readonly>
				</div>

				<div class="form-group">
					<label for="price">Giá:</label>
					<input type="number" name="price" class="form-control" value="{{ $product->price }}" readonly>
				</div>

				<div class="form-group">
					<label for="image">Ảnh sản phẩm:</label>
					<input type="text" name="image" class="form-control" value="{{ $product->image }}" readonly>
				</div>

				<div class="form-group">
					<label for="description">Mô tả:</label>
					<textarea name="description" class="form-control" readonly>{{ $product->description }}</textarea>
				</div>

				<div class="form-group">
					<label for="product_type">Loại sản phẩm:</label>
					<select name="product_type" class="form-control" required>
						<option value="cà phê" {{ $product->product_type === 'cà phê' ? 'selected' : '' }}>Cà phê</option>
						<option value="trà" {{ $product->product_type === 'trà' ? 'selected' : '' }}>Trà</option>
						<option value="nước ép" {{ $product->product_type === 'nước ép' ? 'selected' : '' }}>Nước ép</option>
					</select>
				</div>

				<div class="form-group">
					<label for="status">Trạng thái:</label>
					<select name="status" class="form-control" required>
						<option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
						<option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
					</select>
				</div>

				<div class="form-group">
					<label for="ingredient_id">Nguyên liệu</label>
					<select name="ingredient_id" class="form-control" required>
						@foreach ($ingredients as $ingredient)
							<option value="{{ $ingredient->id }}" {{ $product->ingredient_id == $ingredient->id ? 'selected' : '' }}>
								{{ $ingredient->ingredient_name }}
							</option>
						@endforeach
					</select>
				</div>

				<button type="button" class="btn btn-danger" onclick="confirmDelete()">Xóa sản phẩm</button>
			</form>
			@endcan
			<script>
				function confirmDelete() {
					if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
						document.getElementById('deleteProductForm').submit();
					}
				}
			</script>

		</div>
	@endsection
</body>
</html>