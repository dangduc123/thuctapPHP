<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
	<link rel="stylesheet" href="/backend/fonts/fontawesome-free-6.4.2-web/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Menu</title>
    <style>
        .card {
            margin-top: 150px;
        }

        .card-body a {
            background-color: #75601c;
            font-weight: bold;
            color: white;
        }
		
		.error-message{
			padding-top: 100px;
			padding-bottom: 150px;
		}

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        

        p {
            color: #75601c;
            text-align: center;
        }

        .card-body .btn {
            color: #fff;
            background-color: #75601c;
            font-weight: bold;
            display: block;
            margin: 0 auto;
        }

        .modal-content .btn {
            color: #fff;
            background-color: #75601c;
            font-weight: bold;
        }
		
		
		
		.quantity{
			text-align: center;
			margin-bottom: 10px;
		}
		
		.quantity button{
			width: 30px;
			border-radius: 5px;
			background-color: #75601c;
			color: #fff;
			border: none;
			outline: none;
		}
			
		
		.swal-button--confirm {
            background-color: #75601c;
        }
		
		.swal-button--confirm:hover {
            background-color: #75601c;
        }
		
		#productImage{
			width: 400px;
			display: block;
			margin: 0 auto;
		}
		
		.product-card{
			color: #75601c;
		}
		
		.product-card:hover{
			color: #fff;
			background-color: #75601c;
		}
		
		.product-card:hover .card-title,
		.product-card:hover .card-text
		{
			color: #fff;
		}
		
		.product-card:hover .add-to-cart-btn,
		.quantity:hover button{
			color: #75601c;
			background-color: #fff;
		}
		
		
		
		
		
		

    </style>
	
</head>

<body>
@extends('user.index')
@section('content')
@php 
    $products = $products ?? \App\Models\Product::all()->take(200); 
@endphp


<!--<div class="container">
	@if($products->isEmpty())
		<p class="error-message"></p>
	@else
		@foreach($products->chunk(3) as $chunk)
			<div class="row">
				@foreach($chunk as $product)
					<div class="col-md-4">
						<div class="card product-card" data-id="{{ $product->id }}" style="width: 18rem;">
							<img src="{{ asset($product->image) }}" class="card-img-top product-image" alt="{{ $product->product_name }}">
							<div class="card-body">
								<h5 style="text-align: center; font-weight: bold; color: #75601c;" class="card-title">{{ $product->product_name }}</h5>
								<h5 style="text-align: center; font-weight: bold; color: #75601c;" class="card-title">{{ $product->price }}đ</h5>
								<p class="card-text">{{ $product->description }}</p>
								<form class="add-to-cart-form" data-product-id="{{ $product->id }}">
									@csrf
									<div class="quantity">
										<button type="button" class="minus">-</button>
										<input type="number" name="quantity" placeholder="Số lượng.." value="1" min="1" style="width: 60px;" max="{{ $product->stock }}">
										<button type="button" class="plus">+</button>
									</div>
									<input type="hidden" name="product_id" value="{{ $product->id }}">
									<button type="button" class="btn add-to-cart-btn" data-product-id="{{ $product->id }}"><i class="fas fa-shopping-cart"></i> Đặt hàng</button>
								</form>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		@endforeach
	@endif
</div>-->
<div class="container">
    @if($products->isEmpty())
        <p class="error-message"></p>
	
    @else
		
        @foreach($products->chunk(3) as $chunk)
            <div class="row">
                @foreach($chunk as $product)
                    @if($product->status != 'inactive') <!-- Thêm điều kiện kiểm tra ở đây -->
                        <div class="col-md-4">
                            <div class="card product-card" data-id="{{ $product->id }}" style="width: 18rem;">
                                <img src="{{ asset($product->image) }}" class="card-img-top product-image" alt="{{ $product->product_name }}">
                                <div class="card-body">
                                    <h5 style="text-align: center; font-weight: bold; " class="card-title">{{ $product->product_name }}</h5>
                                    <h5 style="text-align: center; font-weight: bold; " class="card-title">{{ number_format($product->price, 0, ',', '.') }}đ</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                    <form class="add-to-cart-form" data-product-id="{{ $product->id }}">
                                        @csrf
                                        <div class="quantity">
                                            <button style="outline: none;" type="button" class="minus">-</button>
                                            <input required type="number" name="quantity" placeholder="Số lượng.." value="1" min='1' style="width: 60px;" max="{{ $product->stock }}">
                                            <button style="outline: none;" type="button" class="plus">+</button>
                                        </div>
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="button" class="btn add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="addToCart({{ $product->id }})"><i class="fas fa-shopping-cart"></i> Đặt hàng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
    @endif
</div>

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Chi tiết sản phẩm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="productImage" src="" alt="">
        <p id="productDescription"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
    $('.plus').click(function () {
        var $input = $(this).prev('input');
        var currentVal = parseInt($input.val());
        if (!isNaN(currentVal)) {
            $input.val(currentVal + 1);
        }
    });

    $('.minus').click(function () {
        var $input = $(this).next('input');
        var currentVal = parseInt($input.val());
        if (!isNaN(currentVal) && currentVal > 1) {
            $input.val(currentVal - 1);
        }
    });
	
	$('.product-card').hover(function() {
        $(this).css('transform', 'scale(1.15)');
    }, function() {
        $(this).css('transform', 'scale(1)');
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lắng nghe sự kiện khi nút "Đặt hàng" được nhấn
        document.querySelectorAll('.add-to-cart-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                var form = this.closest('.add-to-cart-form');
                var formData = new FormData(form);
                
                // Thực hiện yêu cầu POST không đồng bộ
                fetch('/add_to_cart', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token')
                    }
                })
                // .then(response => response.json())
				.then(response => {
					if (response.status === 401) {
						// Người dùng chưa đăng nhập, chuyển hướng họ đến trang đăng nhập
						window.location.href = '/user/login';
					} else {
						return response.json();
					}
				})
                .then(data => {
                    if (data.success) {
                        // Hiển thị thông báo thành công
                        swal({
                            title: "Thành công!",
                            text: data.message,
                            icon: "success",
                            button: "Đóng",
                        });
						var cartQuantity = parseInt(document.getElementsByClassName("cart-quantity")[0].innerText);
						var productQuantity = parseInt(form.querySelector('input[name="quantity"]').value);
						document.getElementsByClassName("cart-quantity")[0].innerText = cartQuantity + productQuantity;
						// updateCartPopup(data.cartItems);
						document.getElementById('cart_popup').innerHTML = data.cartHTML;
						// document.getElementById('cart_icon').addEventListener('mouseover', function() {
							// document.getElementById('cart_popup').style.display = 'block';
						// });
						
						// document.getElementById('cart_icon').addEventListener('mouseout', function() {
							// document.getElementById('cart_popup').style.display = 'none';
						// });
                    } else {
                        // Xử lý khi có lỗi
                        swal({
                            title: "Lỗi!",
                            text: data.message,
                            icon: "error",
                            button: "Đóng",
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
	
	
	function updateCartPopup(cartItems) {
		var cartPopup = document.getElementById('cart_popup');
		var table = cartPopup.querySelector('table');
		var rows = table.querySelectorAll('tr');

		// Xóa các hàng hiện tại
		for (var i = rows.length - 1; i > 0; i--) {
			table.deleteRow(i);
		}

		// Thêm các hàng mới
		for (var i = 0; i < cartItems.length && i < 5; i++) {
			var row = table.insertRow(i + 1);
			row.insertCell(0).innerHTML = '<img src="' + cartItems[i].product.image + '" alt="Product Image">';
			row.insertCell(1).innerHTML = cartItems[i].product.product_name;
			row.insertCell(2).innerHTML = cartItems[i].quantity;
			row.insertCell(3).innerHTML = cartItems[i].price * cartItems[i].quantity + 'đ';
		}
	}
	

	
	
	
</script>
<script src="/frontend/js/cart.js"></script>
<script>
	$(document).ready(function() {
	  $(' .product-image').click(function() {
		var imageSrc;
		var description;
		if ($(this).hasClass('product-image')) {
		  imageSrc = $(this).attr('src');
		  description = $(this).parent().find('.card-text').text();
		} else {
		  imageSrc = $(this).find('.product-image').attr('src');
		  description = $(this).find('.card-text').text();
		}

		$('#productImage').attr('src', imageSrc);
		$('#productDescription').text(description);

		$('#productModal').modal('show');
	  });

	  $('.add-to-cart-btn, .minus, .plus, input[name="quantity"]').click(function(event) {
		event.stopPropagation();
	  });
	});
</script>

<script>
    document.querySelector('input[name="quantity"]').addEventListener('change', function(e) {
        if (e.target.value > 50) {
            e.target.value = 50;
        }
    });
</script>
@endsection



</body>
</html>
