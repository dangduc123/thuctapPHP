<!-- resources/views/admin/product/create.blade.php -->
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
	<style>
		h1{
			text-align: center;
			padding: 20px;
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
			border-radius: 8px;
		}
		
		
		textarea{
			margin-bottom: 10px;
			width: 300px;
			height: 100px;
			border-radius: 8px;
		}
		
		button{
			height: 30px;
			background-color: #000;
			color: #fff;
			border-radius: 8px;
			margin-top: 30px;
			font-weight: bold;
			margin-bottom: 20px;
		}
		
		label{
			font-weight: bold;
		}
		
	</style>
</head>
<body>
@extends('admin.index')

@section('content')
    <h1>Thêm Sản Phẩm</h1>

    <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="product_name">Tên sản phẩm:</label></br>
        <input type="text" name="product_name" required></br>

        <label for="price">Giá:</label></br>
        <input type="number" name="price" step="0.01" required></br>

        <label for="image">Ảnh:</label></br>
        <input type="file" name="image"></br>

        <label for="description">Mô tả:</label><br>
        <textarea name="description" required></textarea><br>

        <label for="product_type">Loại sản phẩm:</label><br>
        <select style="height: 30px;" name="product_type" required>
            <option value="cà phê">Cà phê</option>
            <option value="trà">Trà</option>
            <option value="nước ép">Nước ép</option>
        </select><br>

        <label for="status">Trạng thái:</label></br>
        <select style="height: 30px;" name="status" required>
            <option value="active">Còn hàng</option>
            <option value="inactive">Hết hàng</option>
        </select><br>

        <!--<label for="ingredient_id">Nguyên liệu:</label></br>
        <select name="ingredient_id">
            @foreach($ingredient as $ingredients)
                <option value="{{ $ingredients->id }}">{{ $ingredients->ingredient_name }}</option>
            @endforeach
        </select></br>-->
		<label for="ingredient_id">Nguyên liệu:</label></br>
		<select required style="width: 300px;" id="multiSelect" name="ingredient_id[]" multiple>
			@foreach($ingredient as $ingredients)
				<option value="{{ $ingredients->id }}">{{ $ingredients->ingredient_name }}</option>
			@endforeach
		</select></br>


        <button type="submit">Thêm Sản Phẩm</button></br>
		<a style="background-color: #000; padding: 10px; text-decoration: none; border-radius: 8px; color: #fff; font-weight: bold;" href="{{ route('product') }}">Trở về</a>
    </form>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		$('#multiSelect').select2();
	});
</script>
</body>
</body>
</html>
