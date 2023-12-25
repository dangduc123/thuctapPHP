<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
	<title>Thêm nguyên liệu</title>
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
			border-radius: 8px;
			height: 30px;
		}
		
		label{
			font-weight: bold;
		}
		
		textarea{
			margin-bottom: 10px;
			width: 300px;
			height: 100px;
			border-radius: 8px;
		}
		
		button{
			margin-top: 20px;
			background-color: #000;
			color: #fff;
			height: 30px;
			font-weight: bold;
			border-radius: 8px;
			margin-bottom: 20px;
		}
		
	</style>
</head>
<body>
@extends('admin.index')

@section('content')
    <h1>Thêm Nguyên Liệu</h1>

    <form method="POST" action="{{ route('admin.ingredient.store') }}">
        @csrf

        <label for="ingredient_name">Tên Nguyên Liệu:</label>
        <input type="text" id="ingredient_name" name="ingredient_name" required>

        </br><label for="quantity">Số Lượng:</label></br>
        <input type="number" id="quantity" name="quantity" required>

        <!--<label for="unit">Đơn Vị:</label>
        <input type="text" id="unit" name="unit" required>-->
		
		</br><label for="unit">Đơn vị:</label></br>
        <select name="unit" required>
            <option value="kg">Kg</option>
            <option value="túi">Túi</option>
            <option value="hộp">Hộp</option>
        </select></br>

        <label for="status">Trạng thái:</label></br>
        <select name="status" required>
            <option value="active">Còn hàng</option>
            <option value="inactive">Hết hàng</option>
        </select><br>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" required>

        <button type="submit">Thêm Nguyên Liệu</button></br>
		<a style="background-color: #000; padding: 10px; text-decoration: none; border-radius: 8px; color: #fff; font-weight: bold;" href="{{ route('admin.ingredient') }}">Trở về</a>
    </form>
@endsection
</body>
</html>