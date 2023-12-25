var addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
var removeFromCartButtons = document.querySelectorAll('.btn-remove-from-cart');

// Thêm sự kiện 'click' cho mỗi nút "add-to-cart"
addToCartButtons.forEach(function(button) {
	button.addEventListener('click', function() {
		updateCart(this.dataset.id, this.dataset.quantity);
	});
});

// Thêm sự kiện 'click' cho mỗi nút "remove-from-cart"
removeFromCartButtons.forEach(function(button) {
	button.addEventListener('click', function() {
		updateCart(this.dataset.id, -this.dataset.quantity);
	});
});

// Hàm để cập nhật giỏ hàng
function updateCart(id, quantity) {
	fetch('/update-cart/' + id, {
		method: 'PATCH',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		},
		body: JSON.stringify({
			quantity: quantity
		})
	})
	.then(response => response.json())
	.then(data => {
		document.querySelector('#cart_icon .cart-quantity').textContent = data.totalQuantity;
	});
}