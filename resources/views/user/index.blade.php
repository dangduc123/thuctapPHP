<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./frontend/css/index.css">
	<link rel="stylesheet" href="/backend/fonts/fontawesome-free-6.4.2-web/css/all.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Admin Dashboard</title>
	<style>
		#sidebar1.hidden {
			display: none;
			background: none;
		}
		
		#header_page{
			display: flex;
			justify-content: space-between;
			height: 30px;
		}
		
		#login-signup{
			padding-left: 150px;
		}
		
		#header_menu{
			height: 30px;
			max-width: 150px;
		}
		
		#header_menu a{
			color: white;
			margin-left: 20px;
			text-decoration: none;
			font-weight: bold;
		}
		
		#header_cart a{
			color: white;
			margin-left: 20px;
			text-decoration: none;
			font-weight: bold;
		}
		
		#header_menu a:hover{
			color: black;
		}
		
		#header_cart a:hover{
			color: black;
		}
		
		#header_logo img{
			width: 100px;	
			height: 100px;
			margin-top: -10px;
		}
		
		.header_search .header__search-input{
			margin-left: 10px;
			font-size: 15px;
			width: 40%;
			border: none;
			outline: none;
			margin-top: 15px;
			height: 25px;
			border-radius: 3px;
			display: inline-block;
		}
		.header_search a i{
			color: var(--text-color);
		}
		
		.header_search a i:hover{
			color: var(--hover-color);
		}
		
		
		.btn_search{
			background-color: var(--main-color);
			border: none;
			outline:none;
			color: var(--text-color);
		}
		
		
		.carousel-control-next-icon,
		.carousel-control-prev-icon {
			background-color: black;
		}

		.carousel-control-next,
		.carousel-control-prev {
			width: 50px;
		}
		
		.carousel{
			padding-top: 100px;
		}
		
		.content_text{
			margin-top: 50px;
			margin-left: 20px;
			margin-right: 150px;
		}

		.content_text p{
			margin-bottom: 30px;
		}

		.content_text h2{
			text-align: center;
			margin-bottom: 20px;
			color: #75601c;
		}
		
		.content_text2 p{
			margin-bottom: 30px;
		}

		.content_text2 h2{
			text-align: center;
			margin-bottom: 20px;
			color: #75601c;
		}
		
		.content_img-text{
			display: flex;
		}

		.content_img img{
			width: 500px;
			margin: 50px 0 50px 50px;	
			height: 305px;
		}
		
		
		.content_text2 {
			margin-right: 20px;
			margin-top: 40px;
			margin-left: 50px;
		}
		
		.content_img2 img{
			width: 500px;
			float: left;
			margin-right: 160px;
			height: 305px;
			padding-bottom: 50px;
		}
		
		.content_img3 img{
			width: 500px;
			height: 305px;
			margin-right: 160px;
			margin-top: 50px;
			padding-bottom: 40px;
		}
		
		#carouselExampleIndicators{
			width: 100%;
		}
		
		#footer{
			margin-top: 50px;
			display: flex;
			justify-content: space-between;
		}
		
		#footer #footer_content{
			padding-left: 20px;
			padding-top: 20px;
			color: #fff;
		}
		
		#footer #footer_media{
			padding-right: 20px;
			padding-top: 20px;
		}
		
		#footer #footer_media a{
			color: #fff;
			font-size: 32px;
			padding-right: 10px;
		}
		
		#header_menu .active {
			border-bottom: 5px solid #fff;
		}
		
		#header_menu .active:hover {
			border-bottom: 5px solid #000;
		}
		
		.cart-quantity {
			display: inline-block;
			background-color: red;
			color: white;
			border-radius: 50%;
			padding: 5px 10px;
			margin-left: 5px;
		}
		
		
		#cart_popup {
			display: none;
			position: absolute;
			background-color: #fff;
			border: 1px solid #ddd;
			padding: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
			z-index: 1;
		}
		
		#cart_popup::before {
			content: "";
			position: absolute;
			top: -10px; /* Điều chỉnh vị trí của lớp giả */
			left: 0;
			width: 100%;
			height: 20px; /* Điều chỉnh kích thước của lớp giả */
		}
		
		#cart_icon:hover + #cart_popup,
		#cart_popup:hover {
			display: block;
		}

		#cart_popup table {
			width: 100%;
			border-collapse: collapse;
		}

		#cart_popup th, #cart_popup td {
			border: 1px solid #ddd;
			padding: 8px;
			text-align: left;
		}
		
		#cart_popup table, #cart_popup th, #cart_popup td {
			border: none;
		}
		
		#cart_popup table tr td:nth-child(1){
			width: 100px;
			
		}
		
		#cart_popup img {
			width: 50px; 
			height: auto; 
		}
		
		.modal-content{
			color: #75601c;
		}
		
		.dropdown {
			position: relative;
			display: inline-block;
		}

		.dropdown-content {
			display: none;
			position: absolute;
			height: 80px;
			background-color: #fff;
			z-index: 1;
			text-align: center;
			width: 100%;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
		}
		
		.dropdown-content a{
			display: block;
		}
		
		.dropdown-content a:hover{
			width: 100%;
			background-color: black;
		}

		.dropdown:hover .dropdown-content {
			display: block;
		}
		
		
		.content_img-text {
			transition: transform 0.5s ease;
		}

		.content_img-text:hover {
			transform: translateY(-10px);
			transform: scale(1.05);
		}
		
		#header_menu{
			transition: transform 0.5s ease;
		}
		
		#header_menu:hover{
			transform: translateY(10px);
		}
		
		.carousel-item img {
		  -webkit-transition: all 2s ease;
		  -moz-transition: all 2s ease;
		  -o-transition: all 2s ease;
		  transition: all 2s ease;
		}

		.carousel-item img:hover {
		  -webkit-transform: scale(1.1);
		  -moz-transform: scale(1.1);
		  -o-transform: scale(1.1);
		  transform: scale(1.1);
		}
		
		
		

		
		
		
	</style>

</head>
<body>
<div id="header">
	<div id="header_page">
		<div id="header_logo">
			<a href="{{ route('user.index') }}"><img src="{{('/frontend/img/logo123.png')}}" alt="Logo"></i></a>
		</div>
		<div id="header_menu">
			<a href="{{ route('user.index') }}" class="{{ Request::routeIs('user.index') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> TRANG CHỦ</a>
		</div>
		<div id="header_menu">
			<a href="{{ route('user.introduce') }}" class="{{ Request::routeIs('user.introduce') ? 'active' : '' }}"><i class="fa-solid fa-face-smile"></i> GIỚI THIỆU</a>
		</div>
		<div id="header_menu">
			<div class="dropdown">
				<a href="{{ route('user.menu') }}" class="{{ Request::routeIs('user.menu') ? 'active' : '' }}"><i class="fa-solid fa-mug-hot"></i> SẢN PHẨM</a>
				<div class="dropdown-content">
					<a style="color: #75601c; margin: 0;" href="{{ route('products.showByType', ['type' => 'trà']) }}">Trà</a>
					<a style="color: #75601c; margin: 0;" href="{{ route('products.showByType', ['type' => 'cà phê']) }}">Cà phê</a>
					<a style="color: #75601c; margin: 0;" href="{{ route('products.showByType', ['type' => 'nước ép']) }}">Nước ép</a>
				</div>
			</div>
		</div>
		<div id="header_menu">
			<a href="{{ route('user.contact') }}" class="{{ Request::routeIs('user.contact') ? 'active' : '' }}"><i class="fa-solid fa-phone"></i> LIÊN HỆ</a>
		</div>
		<div id="header_cart">
			<a href="{{ route('user.cart') }}" id="cart_icon">
				<i class="fas fa-shopping-cart"></i>
				<span class="cart-quantity">{{ $cartQuantity }}</span>
			</a>
			<div id="cart_popup">
				@if(count($cartItems) > 0)
					<table>
						<tr>
							<th>Ảnh</th>
							<th>Tên sản phẩm</th>
							<th>Số lượng</th>
							<th>Tổng tiền</th>
						</tr>
						@foreach($cartItems as $key => $cartItem)
							@if($key < 5)
								<tr class="product">
									<td><img id="product_image_{{ $cartItem->id }}" src="{{ asset($cartItem->product->image) }}" alt="Product Image"></td>
									<td id="product_name_{{ $cartItem->id }}">{{ $cartItem->product->product_name }}</td>
									<td id="hover_quantity_{{ $cartItem->id }}">{{ $cartItem->quantity }}</td>
									<td id="hover_total_price_{{ $cartItem->id }}">{{ number_format($cartItem->price * $cartItem->quantity, 0, ',', '.') }}đ</td>
								</tr>
							@else
								@break
							@endif
						@endforeach
					</table>
					<a style="color: #000;"href="{{ route('user.cart') }}">Xem tất cả</a>
				@else
					<tr>
						<td id="colspan" colspan="3">Giỏ hàng trống</td>
					</tr>
				@endif
			</div>
		</div>
		<div id="login-signup">
			@if(auth()->guard('user')->check())
				<h5 style="color: #fff;">Xin chào<a href="{{ route('user.profile') }}" style="text-decoration: none;">{{ auth()->guard('user')->user()->user_name }}</a>
				<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></h5>
				<form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			@else
				<a href="{{ route('user.login') }}">Đăng nhập</a>
				<a href="{{ route('user.register') }}">Đăng ký</a>
			@endif
		</div>
	</div>
	<div class="header_search">
		<form action="/search" method="get">
			<input type="text" class="header__search-input" required oninvalid="this.setCustomValidity('Ô tìm kiếm rỗng! Vui lòng nhập tên thức uống để tìm kiếm!')" oninput="this.setCustomValidity('')" name="search" placeholder=" Nhập để tìm kiếm thức uống">
			<button type="submit" class="btn_search"><i class='fa-solid fa-magnifying-glass'></i></button>
		</form>
		@if(isset($errorMessage))
			<p class="error-message">{{ $errorMessage }}</p>
		@endif
	</div>
</div>



<div id="content">
	@section('content')
		<div class="slider">
			<div id="carouselExampleIndicators" class="carousel" data-ride="carousel" data-interval="1000">
			  <ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			  </ol>
			  <div class="carousel-inner">
				<div class="carousel-item active">
				  <img src="{{('frontend/img/banner.jpg')}}" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item">
				  <img src="{{('frontend/img/banner2.jpg')}}" class="d-block w-100" alt="...">
				</div>
				<div class="carousel-item">
				  <img src="{{('frontend/img/banner3.jpg')}}" class="d-block w-100" alt="...">
				</div>
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			  </a>
			</div>
		</div>
		<div class="content">
			<div class="content_img-text">
				<div class="content_img">
					<img src="{{('frontend/img/anh1.jpg')}}"/>
				</div>
				<div class="content_text">
					<h2 style="font-weight: bold; font-style:italic;">VỀ KHÔNG GIAN...</h2>
					<p style="color: #75601c; font-weight: bold; font-style:italic;">
						Với không gian ấm cúng và sáng sủa, cùng với lối trang trí màu sắc của những bức tranh và sách làm khách hàng có cảm giác dễ chịu mỗi khi đến đây, 
						có trang trí thêm một số chậu cây và 1 hồ cá nhỏ làm khách hàng có cảm giác tươi mới và tràn đầy sức sống.
					</p>
					<p style="color: #75601c; font-weight: bold; font-style:italic;">
						Sắp xếp bàn, ghế một cách gọn gàng và các bức tranh và sách cũng được sắp xếp hợp lý trên kệ sách.
					</p>
					<p style="color: #75601c; font-weight: bold; font-style:italic;">
						Màu của quầy và màu của tường cùng đồng nhất với nhau làm cho mọi thứ cảm giác sáng hơn và gọn gàng hơn.
					</p>
					
				</div>
			</div>
			<div class="content_img-text">
				<div class="content_text2">
					<h2 style="font-weight: bold; font-style:italic;">ĐỘI NGŨ NHÂN VIÊN...</h2>
					<p style="color: #75601c; font-weight: bold; font-style:italic;">
						Trong suốt quá trình hoạt động và phát triển, đội ngũ quản lý và nhân viên của Tiệm Cà Phê, qua bao thế hệ, đã cùng nhau xây dựng, nuôi dưỡng niềm
						đam mê dành cho trà và cà phê với mong muốn được thử thách bản thân trong ngành dịch vụ năng động và sáng tạo.
					</p>
					<p style="color: #75601c; font-weight: bold; font-style:italic;">
						Chúng tôi tin rằng từng sản phẩm trà và cà phê sẽ càng thêm hảo hạng khi được tạo ra từ sự phấn đầu không ngừng cùng niềm đam mê. Và chính kết nối 
						dựa trên niềm tin, sự trung thực và tin yêu sẽ góp phần mang đến những nét đẹp trong văn hóa trà và cà phê ngày càng bay xa, vươn cao.
					</p>
				</div>
				<div class="content_img3">
					<img src="{{('frontend/img/anh2.jpg')}}">
				</div>
			</div>
			<div class="content-product" style="text-align: center;">
				<a style="font-size: 150px; color: #75601c; " href="#" ><i style="padding-right: 50px;" class="fa-solid fa-kitchen-set"></i></a>
				<a style="font-size: 150px; color: #75601c;" href="#" ><i style="padding-right: 50px;" class="fa-solid fa-mug-hot"></i></a>
				<a style="font-size: 150px; color: #75601c;" href="#" ><i class="fa-solid fa-beer-mug-empty"></i></a>
			</div>
			<div style="text-align: center;" class="content_images">
				<a href="#"><img style="margin-right: 20px; width: 500px;" src="{{('frontend/img/anhcaphe123.jpg')}}"></a>
				<a href="#"><img style="margin-right: 20px; width: 500px;" src="{{('frontend/img/anhcaphe123456.jpg')}}"></a>
				<a href="#"><img style="margin-right: 20px; width: 500px;" src="{{('frontend/img/anhcaphe12345.jpg')}}"></a>
			</div>
		</div>
		<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="welcomeModalLabel">Chào mừng bạn đến trang web của chúng tôi!</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<!-- Nội dung chào mừng -->
				<p>Xin chào! Cảm ơn bạn đã ghé thăm trang web của chúng tôi. Chúc bạn có trải nghiệm tuyệt vời!</p>
				<a href="#"><img style="margin-right: 20px; width: 450px; display: block; margin: 0 auto;" src="{{('frontend/img/tracascara.jpg')}}"></a>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn" style="background-color: #75601c; color: #fff" data-dismiss="modal">Đóng</button>
			  </div>
			</div>
		  </div>
		</div>
	@endsection
		
    <!-- Nội dung trang admin sẽ được thêm vào đây -->
	@yield('content')
</div>

<div id="footer">
	<div id="footer_content">
		<h5 style="font-size: 15px;">Địa chỉ: Địa chỉ: 30/17 Đoàn Trần Nghiệp, Vĩnh Phước, Nha Trang, Khánh Hòa 650000</h5>
		<h5 style="font-size: 15px;">Điện thoại: 0817 477 487</h5>
		<h5 style="font-size: 15px;">Bản quyền của Tiệm Cà Phê</h5>
	</div>
	<div id="footer_media">
		<a href="https://www.facebook.com/TiemCaPheNT"><i class="fa-brands fa-facebook"></i></a>
		<a href="https://www.facebook.com/TiemCaPheNT"><i class="fa-brands fa-instagram"></i></a>
		<a href="https://www.facebook.com/TiemCaPheNT"><i class="fa-brands fa-twitter"></i></a>
		<a href="https://www.facebook.com/TiemCaPheNT"><i class="fa-brands fa-snapchat"></i></a>
		<a href="https://www.facebook.com/TiemCaPheNT"><i class="fa-brands fa-tiktok"></i></a>
	</div>
</div>

<script>
  $(document).ready(function(){
    // Hiển thị modal sau khi trang web được tải
    $('#welcomeModal').modal('show');
  });
  
  
</script>

<script src="/frontend/js/cart.js"></script>
<script>
	// document.addEventListener('DOMContentLoaded', function () {
        // // Lắng nghe sự kiện khi nút "Đặt hàng" được nhấn
        // document.querySelectorAll('.add-to-cart-btn').forEach(function (button) {
            // button.addEventListener('click', function () {
                // var form = this.closest('.add-to-cart-form');
                // var formData = new FormData(form);
                
                // // Thực hiện yêu cầu POST không đồng bộ
                // fetch('/add_to_cart', {
                    // method: 'POST',
                    // body: formData,
                    // headers: {
                        // 'X-CSRF-TOKEN': formData.get('_token')
                    // }
                // })
                // .then(response => response.json())
                // .then(data => {
                    // if (data.success) {
                        // // Hiển thị thông báo thành công
                        // swal({
                            // title: "Thành công!",
                            // text: data.message,
                            // icon: "success",
                            // button: "Đóng",
                        // });
                    // } else {
                        // // Xử lý khi có lỗi
                        // swal({
                            // title: "Lỗi!",
                            // text: data.message,
                            // icon: "error",
                            // button: "Đóng",
                        // });
                    // }
                // })
                // .catch(error => {
                    // console.error('Error:', error);
                // });
            // });
        // });
    // });
	
	// function updateCart(newCartData) {
		// // Giả sử newCartData là một đối tượng có thuộc tính 'quantity'
		// var newQuantity = newCartData.quantity;

		// // Tìm phần tử HTML hiển thị số lượng sản phẩm trong giỏ hàng
		// var quantityElement = document.querySelector('#cart_icon .cart-quantity');

		// // Cập nhật số lượng sản phẩm trong giỏ hàng
		// if (newQuantity > 0) {
			// quantityElement.textContent = newQuantity;
			// quantityElement.style.display = 'block';
		// } else {
			// quantityElement.style.display = 'none';
		// }
	// }



</script>



</body>
</html>
