<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
    <title>Introduce</title>
    <style>
        .carousel-item  img{
			height: 440px;
		}
		
		.carousel{
			padding-top: 110px;
		}
		
		.content_img-text {
			transition: transform 0.5s ease;
		}

		.content_img-text:hover {
			transform: translateY(-10px);
			transform: scale(1.05);
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
@extends('user.index')
@section('content')
<div class="slider">
	<div id="carouselExampleIndicators" class="carousel" data-ride="carousel" data-interval="1000">
	  <ol class="carousel-indicators">
		<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	  </ol>
	  <div class="carousel-inner">
		<div class="carousel-item active" data-interval="1000">
		  <img src="{{asset('frontend/img/banner1.jpg')}}" class="d-block w-100" alt="...">
		</div>
		<div class="carousel-item" data-interval="1000">
		  <img src="{{asset('frontend/img/banner4.jpg')}}" class="d-block w-100" alt="...">
		</div>
		<div class="carousel-item" data-interval="1000">
		  <img src="{{asset('frontend/img/banner5.jpg')}}" class="d-block w-100" alt="...">
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
			<img src="{{asset('frontend/img/anhcaphe.jpg')}}"/>
		</div>
		<div class="content_text">
			<h2 style="font-weight: bold; font-style: italic;">VỀ CÀ PHÊ...</h2>
			<p style="color: #75601c; font-weight: bold; font-style: italic;">
				Cà phê của chúng tôi được chế biến từ những hộp cà phê nguyên chất, được thu hái tại Đắk Lắk. Hương thơm đặc trưng
				của cà phê lan tỏa ngay khi bạn mở nắp ly, kích thích giác quan và đánh thức tinh thần.
			</p>
			<p style="color: #75601c; font-weight: bold; font-style: italic;">
				Vị đắng nhẹ nhàng, sâu lắng của cà phê kết hợp với hương thơm nồng nàn, tạo nên một ly cà phê hoàn hảo. Cà phê của 
				chúng tôi không chỉ là thức uống mà còn là trải nghiệm cho mọi giác quan.
			</p>
			<p style="color: #75601c; font-weight: bold; font-style: italic;">
				Ngoài cà phê đen ra thì còn nhiều loại cà phê khác cho khách hàng lựa chọn theo sở thích cá nhân của mình.
			</p>
			
		</div>
	</div>
	<div class="content_img-text">
		<div class="content_text2">
			<h2 style="font-weight: bold; font-style: italic;">VỀ TRÀ TRÁI CÂY...</h2>
			<p style="color: #75601c; font-weight: bold; font-style: italic;">
				Trà trái cây của chúng tôi là sự kết hợp tinh tế giữa tự nhiên của trà và vị ngọt, chua nhẹ của các loại trái cây. Mỗi ly
				trà trái cây đều mang trong mình hương vị đặc trưng của từng loại trái cây.
			</p>
			<p style="color: #75601c; font-weight: bold; font-style: italic;">
				Khi thưởng thức, bạn sẽ cảm nhận được sự cân bằng hoàn hảo giữa vị trà và vị trái cây, tạo nên một hương vị độc đáo khó quên.
				Trà trái cây không chỉ giúp giải khát mà còn mang lại cảm giác thư giãn, tươi mới cho tâm hồn.
			</p>
		</div>
		<div class="content_img2">
			<img src="{{asset('frontend/img/chanhdabaohatchia.jpg')}}">
		</div>
	</div>
	<div class="content_img-text">
		<div class="content_img">
			<img src="{{asset('frontend/img/anhnuocep.jpg')}}"/>
		</div>
		<div class="content_text">
			<h2 style="font-weight: bold; font-style: italic;">VỀ NƯỚC ÉP...</h2>
			<p style="color: #75601c; font-weight: bold; font-style: italic;">
				Nước ép trái cây của chúng tôi được làm từ 100% trái cây tươi ngon, được chọn lựa kỹ lưỡng từ những vườn trái cây 
				địa phương. Mỗi ly nước ép đều giữ được hương vị tự nhiên, ngọt ngào và đầy màu sắc của trái cây.
			</p>
			<p style="color: #75601c; font-weight: bold; font-style: italic;">
				Từ vị chua nhẹ của dâu tây, vị ngọt của cam, cho đến vị thơm lừng của dứa, tất cả đều được cân nhắc kỹ lưỡng để 
				tạo nên một ly nước ép hoàn hảo.
			</p>
			<p style="color: #75601c; font-weight: bold; font-style: italic;">
				Nước ép trái cây không chỉ giúp bạn giải khát mà còn cung cấp nhiều loại vitamin và khoáng chất cần thiết cho cơ thể.
				Hãy thưởng thức và cảm nhận sự tươi mới, sức sống mà nước ép trái cây mang lại cho bạn.
			</p>
			
		</div>
	</div>
</div>
@endsection

</body>
</html>