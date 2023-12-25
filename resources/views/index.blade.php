<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
	<title>Thêm nguyên liệu</title>
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
		}
		
	</style>
</head>
<body>
@extends('admin.index')

@section('content')
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Doanh thu từ mỗi sản phẩm</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($revenue as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->total_revenue }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
</body>
</html>