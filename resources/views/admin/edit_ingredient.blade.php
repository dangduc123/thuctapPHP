
<html>
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
			margin-bottom: 20px;
		}
		
		
	</style>
</head>
<body>
@extends('admin.index')

@section('content')
	<h1>Chỉnh Sửa Nguyên Liệu</h1>

    <form method="POST" action="{{ route('admin.update_ingredient', ['id' => $ingredient->id]) }}">
        @csrf
        @method('PUT')

        <label for="ingredient_name">Tên Nguyên Liệu:</label>
        <input style="margin-bottom: 10px;" type="text" id="ingredient_name" name="ingredient_name" value="{{ $ingredient->ingredient_name }}" required>

        <label for="quantity">Số Lượng:</label>
        <input style="margin-bottom: 10px;" type="number" id="quantity" name="quantity" value="{{ $ingredient->quantity }}" required>

       
		
		<label for="unit">Đơn vị:</label>
		<select style="margin-bottom: 10px;" name="unit" class="form-control" required>
			<option value="kg" {{ $ingredient->unit === 'kg' ? 'selected' : '' }}>Kg</option>
			<option value="túi" {{ $ingredient->unit === 'túi' ? 'selected' : '' }}>Túi</option>
			<option value="hộp" {{ $ingredient->unit === 'hộp' ? 'selected' : '' }}>Hộp</option>
		</select>

        <label for="status">Trạng thái:</label>
		<select style="margin-bottom: 10px;" name="status" class="form-control" required>
			<option value="active" {{ $ingredient->status === 'active' ? 'selected' : '' }}>Active</option>
			<option value="inactive" {{ $ingredient->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
		</select>

        <label for="price">Giá:</label>
        <input style="margin-bottom: 10px;" type="number" id="price" name="price" value="{{ number_format($ingredient->price, 0, ',', '.') }}" required>

        <button type="submit">Cập Nhật Nguyên Liệu</button></br>
		<a style="background-color: #000; padding: 10px; text-decoration: none; border-radius: 8px; color: #fff; font-weight: bold;" href="{{ route('admin.ingredient') }}">Trở về</a>
    </form>

@endsection
</body>
</html>