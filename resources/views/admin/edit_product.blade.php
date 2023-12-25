<!-- resources/views/products/edit_product.blade.php -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
	<style>
		h1{
			text-align: center;
			margin-top: 100px;
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
			border-radius: 8px;
		}
		
		textarea{
			margin-bottom: 10px;
			width: 300px;
			height: 100px;
			border-radius: 8px;
		}
		
		label{
			font-weight: bold;
		}
	</style>
    <title>Product Information</title>
</head>
<body>
	@extends('admin.index') <!-- Đảm bảo rằng layout của bạn đã được tạo -->

	@section('content')
		<div class="container">
			<h1>Cập nhật sản phẩm</h1>
			<form method="POST" action="{{ route('admin.update_product', $product->id) }}" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				<div class="form-group">
					<label for="product_name">Tên sản phẩm:</label>
					<input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" required>
				</div>

				<div class="form-group">
					<label for="price">Giá:</label></br>
					<input type="number" name="price" class="form-control" value="{{ number_format($product->price, 0, ',', '.') }}" required>
				</div>

				<div class="form-group">
					<label for="image">Ảnh sản phẩm:</label>
					<input type="file" name="image" class="form-control">
					<p>Current image: {{$product->image}}</p>
				</div>

				<div class="form-group">
					<label for="description">Mô tả:</label></br>
					<textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
				</div>

				<div class="form-group">
					<label for="product_type">Loại sản phẩm:</label></br>
					<select style="height:30px;" name="product_type" class="form-control" required>
						<option value="cà phê" {{ $product->product_type === 'cà phê' ? 'selected' : '' }}>Cà phê</option>
						<option value="trà" {{ $product->product_type === 'trà' ? 'selected' : '' }}>Trà</option>
						<option value="nước ép" {{ $product->product_type === 'nước ép' ? 'selected' : '' }}>Nước ép</option>
					</select>
				</div>

				<div class="form-group">
					<label for="status">Trạng thái:</label></br>
					<select style="height: 30px;" name="status" class="form-control" required>
						<option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
						<option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
					</select>
				</div>

				<div class="form-group">
					<label for="ingredient_id">Nguyên liệu:</label></br>
					<select name="ingredient_id[]" multiple class="form-control" required>
						@foreach ($ingredients as $ingredient)
							<option value="{{ $ingredient->id }}" {{ in_array($ingredient->id, $product->ingredient->pluck('id')->toArray()) ? 'selected' : '' }}>
								{{ $ingredient->ingredient_name }}
							</option>
						@endforeach
					</select>
				</div>


				<button style="background-color: #111; height: 30px; color: #fff; border-radius: 8px; cursor: pointer; margin-bottom: 20px;"type="submit" class="btn btn-primary">Cập nhật sản phẩm</button></br>
				<a style="background-color: #000; padding: 10px; text-decoration: none; border-radius: 8px; color: #fff; font-weight: bold;" href="{{ route('product') }}">Trở về</a>
			</form>
		</div>
	@endsection
</body>
</html>
