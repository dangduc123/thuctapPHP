<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
	<title>Thống kê</title>
	<style>
		.justify-content-center{
			text-align: center;
			margin-top: 60px;
		}
		
		.card-body{
			margin-left: 450px;
			font-size: 20px;
		}
		
		.card-body table{
			font-size: 20px;
		}
		
		
		
		
		
	</style>
</head>
<body>
@extends('admin.index')

@section('content')
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1>Doanh thu từ mỗi sản phẩm</h1></div>
                    <div class="card-body">
						<p style="margin-left: -400px;">Thời gian hiện tại: {{ $currentTime }}</p>
                        <table style="margin-left: 30px;"class="table">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
									<th>Số lượng bán ra</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
								@php
									$total_quantity = 0;
									$total_revenue = 0;
                                @endphp
                                @foreach ($revenue as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->total_quantity}}</td>
                                        <td>{{ number_format($product->total_revenue, 0, ',', '.') }}đ</td>
                                    </tr>
									@php
										$total_quantity += $product->total_quantity;
										$total_revenue += $product->total_revenue;
                                    @endphp
                                @endforeach
								<tr>
									<td><strong>Tổng cộng</strong></td>
									<td><strong>{{ $total_quantity}}</strong></td>
                                    <td><strong>{{ number_format($total_revenue, 0, ',', '.') }}đ</strong></td>
                                </tr>
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