<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./backend/css/index.css">
	<link rel="stylesheet" href="/backend/fonts/fontawesome-free-6.4.2-web/css/all.min.css">
    <title>Admin Dashboard</title>
	<style>
		#sidebar1.hidden {
			display: none;
		}
		
		#header_home a{
			margin-left: 270px;
			text-decoration: none;
			color: white;
			font-weight: bold;
		}
		
		#quantity{
			display: flex;
		}
		
		#quantity div a{
			color: white;
			font-size: 10px;
			text-decoration: none;
		}
		
		#quantity div a:hover{
			color: red;
		}
		
		#user-avatar {
			width: 50px;
			height: 50px;
			border-radius: 50%;
			object-fit: cover;
			margin-right: 10px;
			cursor: pointer;
		}
		
		#header_home{
			padding-left: 200px;
		}
		
		#header_home ul{
			display: flex;
			color: #fff;
			list-style: none;
		}
		
		
		#header_home ul li{
			padding-right: -250px;
		}
		
		#header_home ul li a{
			margin: 0;
			padding-left: 10px;
		}
		
		#header_home ul li a:hover{
			color: #818181;
		}
		
		#login-signup{
			margin-top: 20px;
			margin-right: 20px;
		}
		
		.justify-content-center{
			text-align: center;
			margin-top: 60px;
		}
		
		.card-body{
			margin-left: 400px;
			font-size: 20px;
		}
		
		.card-body table{
			font-size: 20px;
		}
		
		#quantity div {
		  -webkit-transition: all 0.5s ease;
		  -moz-transition: all 0.5s ease;
		  -o-transition: all 0.5s ease;
		  transition: all 0.5s ease;
		}

		#quantity div:hover {
		  -webkit-transform: scale(1.1);
		  -moz-transform: scale(1.1);
		  -o-transform: scale(1.1);
		  transform: scale(1.1);
		}

	</style>
	
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Lấy ra nút "Danh mục" và sidebar
			var toggleSidebarBtn = document.getElementById("toggleSidebar");
			var sidebar = document.getElementById("sidebar1");
			var alert = document.getElementById("alert");
			var closebtn = document.getElementById("closebtn");

			// Thêm sự kiện click cho nút "Danh mục"
			toggleSidebarBtn.addEventListener("click", function() {
				// Kiểm tra xem người dùng đã đăng nhập hay chưa
				@if(!auth()->guard('user')->check())
					// Nếu người dùng chưa đăng nhập, hiển thị thông báo và không hiển thị sidebar
					alert.style.display = "block";
				@else
					// Nếu người dùng đã đăng nhập, toggle class 'hidden' cho sidebar
					sidebar.classList.toggle("hidden");
				@endif
			});

			// Thêm sự kiện click cho nút đóng
			closebtn.addEventListener("click", function() {
				alert.style.display = "none";
			});
		});
	</script>
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Tên sản phẩm', 'Số lượng', 'Doanh thu'],
				@foreach ($revenue as $product)
					['{{ $product->product_name }}', {{ $product->total_quantity }}, {{ $product->total_revenue }}],
				@endforeach
			]);

			var options = {
				title: 'Doanh thu và số lượng từ mỗi sản phẩm',
				vAxes: {0: {title: 'Số lượng'}, 1: {title: 'Doanh thu'}},
				seriesType: 'bars',
				series: {0: {targetAxisIndex:0}, 1:{targetAxisIndex:1}},
				hAxis: {title: 'Tên sản phẩm'},
			};

			var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	</script>

</head>
<body>
<div id="alert" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; border-radius: 15px; width: 30%;">
        <span id="closebtn" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <p>Bạn cần đăng nhập để có thể truy cập</p>
    </div>
</div>
<div id="header">
	<div id="header_home">
		<ul>
			<li><a href="{{ route('admin.index') }}">Home</a></li>
			<li><a href="{{ route('revenue.index')}}">Thống kê doanh thu sản phẩm</a></li>
		</ul>
		<!--<a href="{{ route('admin.index') }}">Home</a>-->
	</div>
    <div id="login-signup">
        @if(auth()->guard('user')->check())
            <a style="text-decoration: none;">
				@foreach (auth()->guard('user')->user()->roles as $role)
					{{ $role->name }}
				@endforeach
			</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('admin.login') }}">Đăng nhập</a>
        @endif
    </div>
</div>


<div id="sidebar">
    <a href="#" id="toggleSidebar"><i class="fa-solid fa-bars"></i> Danh mục</a>
		<div id="sidebar1" class="hidden">
			<div class="dropdown">
				<a href="#"><i class="fa-solid fa-user"></i> Quản lý khách hàng</a>
				<div class="dropdown-content">
					<a href="{{ route('user.user_list') }}">Danh sách khách hàng</a>
				</div>
			</div>
			<div class="dropdown">
				<a href="#"><i class="fa-solid fa-mug-hot"></i> Quản lý sản phẩm</a>
				<div class="dropdown-content">
					<a href="{{ route('admin.create') }}">Thêm sản phẩm</a>
					<a href="{{ route('product') }}">Danh sách sản phẩm</a>
				</div>
			</div>
			<div class="dropdown">
				<a href="#"><i class="fa-solid fa-file-invoice"></i> Quản lý đơn hàng</a>
				<div class="dropdown-content">
					<a href="{{ route('invoice')}}">Danh sách đơn hàng</a>
				</div>
			</div>
			
			<!--<div class="dropdown">
				<a href="#"><i class="fa-solid fa-user-tie"></i> Quản lý phân quyền</a>
				<div class="dropdown-content">
					<a href="{{ route('admin.admin_list')}}">Danh sách phân quyền</a>
				</div>
			</div>-->
			
			<div class="dropdown">
				<a href="#"><i class="fa-solid fa-carrot"></i> Quản lý nguyên liệu</a>
				<div class="dropdown-content">
					<a href="{{ route('admin.add_ingredient')}}">Thêm nguyên liệu</a>
					<a href="{{ route('admin.ingredient')}}">Danh sách nguyên liệu</a>
				</div>
			</div>
		</div>
</div>

<div id="content">
	@section('content')
		<h1 style="margin-top: 40px;">Tổng quan</h1>
		<?php
			// Kết nối đến cơ sở dữ liệu của bạn
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "laravel";

			$conn = new mysqli($servername, $username, $password, $dbname);

			// Kiểm tra kết nối
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			
			
			$sql_product = "SELECT id, product_name, price, image, description, product_type, status, created_at, updated_at FROM product";
			$result_product = $conn->query($sql_product);
			
			$sql_ingredient = "SELECT id, ingredient_name, quantity, unit, status, price, created_at, updated_at FROM ingredient";
			$result_ingredient = $conn->query($sql_ingredient);
			
			$sql_user = "SELECT id, user_name, email, password, address, phone_number, reset_token_hash, reset_token_expires_at, created_at, updated_at FROM user";
			$result_user = $conn->query($sql_user);
			
			$sql_invoice = "SELECT id, date, created_at, updated_at FROM invoice";
			$result_invoice = $conn->query($sql_invoice);
			
			// Truy vấn SQL để tính tổng doanh thu từ tất cả các sản phẩm
			// Truy vấn SQL để tính tổng doanh thu từ tất cả các sản phẩm
			$sql_revenue = "SELECT SUM(product.price * invoicedetail.quantity) as total_revenue FROM product JOIN invoicedetail ON product.id = invoicedetail.product_id";
			$result_revenue = $conn->query($sql_revenue);
			$row = $result_revenue->fetch_assoc();
			$total_revenue = $row['total_revenue'];

			// Đếm số lượng người dùng có quyền truy cập vào trang admin
			
			// echo "Số lượng người dùng có quyền truy cập vào trang admin: " . $num_admin_users . "<br>";
			//Đếm số lượng sản phẩm
			$num_products = $result_product->num_rows;
			// echo "Số lượng sản phẩm: " . $num_products . "<br>";
			//Đếm số lượng nguyên liệu
			$num_ingredients = $result_ingredient->num_rows;
			// echo "Số lượng nguyên liệu: " . $num_ingredients . "<br>";
			// Đếm số lượng khách hàng
			$num_users = $result_user->num_rows;
			// echo "Số lượng khách hàng: " . $num_users;
			
			$num_invoices = $result_invoice->num_rows;
			
			// $num_revenues = $result_revenue->num_rows;
			
			$conn->close();
		?>
		<div id="quantity">
			<div style="border: 1px solid black; color: #fff; font-weight: bold; background-color: #333; width: 350px; height: 160px; padding: 10px; margin-bottom: 10px; margin-right: 10px;">
				<i class="fa-solid fa-mug-hot"></i> Số lượng sản phẩm: <?php echo $num_products; ?>
				<div><a href="{{ route('product')}}">chi tiết</a></div>
			</div>
			<div style="border: 1px solid black; color: #fff; font-weight: bold; background-color: #333; width: 350px; height: 160px; padding: 10px; margin-bottom: 10px; margin-right: 10px;">
				<i class="fa-solid fa-carrot"></i> Số lượng nguyên liệu: <?php echo $num_ingredients; ?>
				<div><a href="{{ route('admin.ingredient')}}">chi tiết</a></div>
			</div>
			<div style="border: 1px solid black; color: #fff; font-weight: bold; background-color: #333; width: 350px; height: 160px; padding: 10px; margin-bottom: 10px; margin-right: 10px;">
				<i class="fa-solid fa-user"></i> Số lượng khách hàng: <?php echo $num_users; ?>
				<div><a href="{{ route('user.user_list')}}">chi tiết</a></div>
			</div>
			<div style="border: 1px solid black; color: #fff; font-weight: bold; background-color: #333; width: 350px; height: 160px; padding: 10px; margin-bottom: 10px; margin-right: 10px;">
				<i class="fa-solid fa-file-invoice"></i> Số lượng đơn hàng: <?php echo $num_invoices; ?>
				<div><a href="{{ route('invoice')}}">chi tiết</a></div>
			</div>
			<div style="border: 1px solid black; color: #fff; font-weight: bold; background-color: #333; width: 350px; height: 160px; padding: 10px; margin-bottom: 10px;">
				<i class="fa-solid fa-coins"></i> Tổng doanh thu từ các sản phẩm: <?php echo number_format($total_revenue, 0, ',', '.'); ?>đ
				<div><a href="{{ route('revenue.index')}}">chi tiết</a></div>
			</div>
		</div>
		
		
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header"><h1>Doanh thu từ mỗi sản phẩm</h1></div>
					<div class="card-body">
						<p style="margin-left: -400px;">Thời gian hiện tại: {{ $currentTime }}</p>
						<div id="chart_div" style="width: 900px; height: 500px; margin-left: -180px;"></div>
					</div>
				</div>
			</div>
		</div>
	@endsection
		
    <!-- Nội dung trang admin sẽ được thêm vào đây -->
	@yield('content')
</div>

</body>
</html>
