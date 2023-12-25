<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Giỏ hàng</title>
	<style>
		img {
			width: 100px;  
			height: 200px;
			object-fit: cover;
		}
		
		.cart ul{
			list-style: none;
		}
		
		.swal-button--confirm {
            background-color: #dc3545;
        }
		
		.swal-button--confirm:hover {
            background-color: #dc3545;
        }
		
		.row{
			text-align: center;
		}
		
		.row button{
			margin-bottom: 10px;
		}
		
		.card{
			display: block;
			margin: 0 auto;
		}
		
		.card {
		  transition: transform .2s; /* Animation */
		}

		.card:hover {
		  transform: scale(1.1);
		}
		
		
		
		
	</style>
    <!-- Các thẻ style và script cần thiết -->
</head>

<body>
@extends('user.index')
@section('content')
    <h1 style="padding-top: 110px; margin-bottom: 60px;">Giỏ Hàng</h1>

    @if($cartItems->isEmpty())
        <p>Giỏ hàng của bạn trống.</p>
    @else
		<div class="row">
			<?php $total = 0; ?>
			@foreach($cartItems as $cartItem)
			<?php $total += $cartItem->quantity * $cartItem->price; ?>
				<div style="margin-bottom: 60px;" class="col-md-4">
					<div class="card" data-id="{{ $cartItem->product->id }}" style="width: 18rem;">
						<img src="{{ asset($cartItem->product->image) }}" class="card-img-top product-image" alt="{{ $cartItem->product->product_name }}">
						<div class="card-body">
							<h5 style="color: #75601c;" class="card-title">{{ $cartItem->product->product_name }}</h5>
							<h5 style="color: #75601c;" class="card-title">{{ number_format($cartItem->price, 0, ',', '.') }}đ</h5>
							<p style="color: #75601c;"  lass="card-text">{{ $cartItem->product->description }}</p>
							<p style="color: #75601c;"  class="card-text">
								<button style="background-color: #75601c; height: 30px; border-radius: 8px; border: none; outline: none; color: #fff; width: 30px;" class="minus-btn" type="button" name="button" onclick="updateQuantity({{ $cartItem->id }}, -1)">-</button>
								Số lượng: <span class="quantity" id="quantity_{{ $cartItem->id }}">{{ $cartItem->quantity }}</span>
								<button style="background-color: #75601c; height: 30px; border-radius: 8px; border: none; outline: none; color: #fff; width: 30px;" class="plus-btn" type="button" name="button" onclick="updateQuantity({{ $cartItem->id }}, 1)">+</button>
							</p>
                            <p style="color: #75601c; font-weight: bold;" class="card-text" id="total_price_{{ $cartItem->id }}">Tổng tiền: {{ number_format($cartItem->quantity * $cartItem->price, 0, ',', '.') }}đ</p>
							<form action="{{ route('checkout.process2',  ['productId' => $cartItem->product->id]) }}" method="POST" onsubmit="saveQuantity({{ $cartItem->id }})">
								@csrf
								<input type="hidden" name="product_id" value="{{ $cartItem->product->id }}">
								<input type="hidden" name="quantity" id="quantityInput_{{ $cartItem->id }}" value="{{ $cartItem->quantity }}">
								<button style="background-color: #75601c; color: #fff; font-weight: bold;"type="submit" class="btn" >Thanh toán</button>
							</form>
							<form action="{{ route('remove_from_cart', ['id' => $cartItem->id]) }}" method="POST">
								@csrf
								@method('DELETE')
								<input type="hidden" name="product_id" value="{{ $cartItem->product->id }}">
								<button style="font-weight: bold;" type="submit" class="btn btn-danger btn-remove-from-cart">Xóa khỏi giỏ hàng</button>
							</form>
							<form id="updateQuantityForm_{{ $cartItem->id }}" action="{{ route('cart.updateQuantity') }}" method="POST" style="display: none;">
								@csrf
								<input type="hidden" name="id" value="{{ $cartItem->id }}">
								<input type="hidden" name="quantityChange" id="quantityChangeInput_{{ $cartItem->id }}">
							</form>
							
						</div>
					</div>
				</div>
			@endforeach
			<form style="background-color: #75601c; width: 80%; display: block; margin: 0 auto; border-radius: 40px;" action="{{ route('checkout.process') }}" method="POST">
				@csrf
				@foreach($cartItems as $cartItem)
					<input type="hidden" name="product_ids[]" value="{{ $cartItem->product->id }}">
					<input type="hidden" name="quantities[]" value="{{ $cartItem->quantity }}">
				@endforeach
				<button  style="color: #fff; font-weight: bold; width: 1200px;" type="submit" class="btn"><p id="total">Tổng tiền tất cả sản phẩm: {{ number_format($total, 0, ',', '.') }}đ</p> Mua tất cả</button>
			</form>
		</div>
    @endif

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lắng nghe sự kiện khi nút "Xóa khỏi giỏ hàng" được nhấn
        document.querySelectorAll('.btn-remove-from-cart').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                
                var form = this.closest('form');
				var productElement = this.closest('.card');
				var productQuantity = parseInt(productElement.querySelector('.quantity').innerText);

                // Thực hiện yêu cầu DELETE không đồng bộ
                fetch(form.action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hiển thị thông báo thành công
                        swal({
                            title: "Thành công!",
                            text: data.message,
                            icon: "success",
                            button: "Đóng",
                        });
						productElement.remove();
						var cartQuantity = parseInt(document.getElementsByClassName("cart-quantity")[0].innerText);
						document.getElementsByClassName("cart-quantity")[0].innerText = cartQuantity - productQuantity;
						document.getElementById('cart_popup').innerHTML = data.cartHTML;
						document.getElementById("total").innerText = "Tổng tiền tất cả sản phẩm: " + data.total_all_price + "đ";
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
                    // Hiển thị thông báo lỗi trong console
                    console.error('Error:', error);
                });
            });
        });
    });
	
	
	// function saveQuantity(productId) {
		// var quantity = parseInt(document.getElementById("quantity_" + productId).innerText);
		// localStorage.setItem("quantity_" + productId, quantity);
	// }

	
	
	// function updateQuantity(productId, change) {
		// // Lấy giá trị hiện tại của số lượng từ span
		// var currentQuantity = parseInt(document.getElementById("quantity_" + productId).innerText);

		// // Tính toán số lượng mới
		// var newQuantity = currentQuantity + change;

		// // Kiểm tra xem số lượng mới có lớn hơn hoặc bằng 0 không
		// if (newQuantity >= 0) {
			// // Cập nhật giá trị trong span
			// document.getElementById("quantity_" + productId).innerText = newQuantity;
			// document.getElementById("quantityInput_" + productId).value = newQuantity;
		// } else {
			// alert("Số lượng không thể nhỏ hơn 0");
		// }
	// }
	
	// function redirectToCheckout() {
		// // Chuyển hướng sang trang thanh toán
		// window.location.href = "{{ route('checkout.process') }}";
	// }
	
	function updateQuantity(productId, change) {
		var currentQuantityElement = document.getElementById("quantity_" + productId);
		var currentQuantity = parseInt(currentQuantityElement.innerText);
		var newQuantity = currentQuantity + change;

		if (newQuantity <= 50) {
			var formData = new FormData();
			formData.append('id', productId);
			formData.append('quantityChange', change);
			formData.append('_token', '{{ csrf_token() }}');

			var request = new XMLHttpRequest();
			request.open('POST', '/cart/updateQuantity', true);
			request.onload = function() {
				if (request.status >= 200 && request.status < 400) {
					var response = JSON.parse(request.responseText);

					if (response.newQuantity === 0) {
						// Nếu newQuantity bằng 0, xóa sản phẩm khỏi giao diện người dùng
						var productContainer = currentQuantityElement.closest('.card');
						productContainer.remove();
						var cartQuantity = parseInt(document.getElementsByClassName("cart-quantity")[0].innerText);
						var newCartQuantity = cartQuantity - currentQuantity;
						document.getElementsByClassName("cart-quantity")[0].innerText = newCartQuantity;
						document.getElementById("total").innerText = "Tổng tiền tất cả sản phẩm: " + response.total_all_price + "đ";
						document.getElementById('product_image_' + productId).style.display = "none";
						document.getElementById('product_name_' + productId).style.display = "none";
						document.getElementById('hover_quantity_' + productId).style.display = "none";
						document.getElementById('hover_total_price_' + productId).style.display = "none";
						if (newCartQuantity == 0) {
							document.getElementById('cart_popup').innerHTML = "Giỏ hàng trống";
						}
					} else {
						// Nếu newQuantity không phải là 0, cập nhật giao diện người dùng bình thường
						currentQuantityElement.innerText = response.newQuantity;
						document.getElementById("total_price_" + productId).innerText = "Tổng tiền: " + response.total_price + "đ";
						var cartQuantity = parseInt(document.getElementsByClassName("cart-quantity")[0].innerText);
						document.getElementsByClassName("cart-quantity")[0].innerText = cartQuantity + change;
						document.getElementById('hover_quantity_' + productId).innerText = response.newQuantity;
						document.getElementById('hover_total_price_' + productId).innerText = response.total_price + "đ";
						document.getElementById("total").innerText = "Tổng tiền tất cả sản phẩm: " + response.total_all_price + "đ";
					}
				} else {
					console.error('Có lỗi xảy ra');
				}
			};
			request.onerror = function() {
				console.error('Không thể kết nối đến máy chủ');
			};

			request.send(formData);
		} else {
			alert("Số lượng giới hạn đến 50");
		}
	}
	

</script>
<script src="/frontend/js/cart.js"></script>




</body>
</html>
