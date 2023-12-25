<table>
    <tr>
        <th>Ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Số lượng</th>
        <th>Tổng tiền</th>
    </tr>
    @if(count($cartItems) > 0)
        @foreach($cartItems as $key => $cartItem)
            @if($key < 5)
                <tr>
                    <td><img src="{{ asset($cartItem->product->image) }}" alt="Product Image"></td>
                    <td>{{ $cartItem->product->product_name }}</td>
                    <td>{{ $cartItem->quantity }}</td>
                    <td>{{ $cartItem->price * $cartItem->quantity }}đ</td>
                </tr>
            @else
                @break
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="3">Giỏ hàng trống</td>
        </tr>
    @endif
</table>
<a style="color: #000;"href="{{ route('user.cart') }}">Xem tất cả</a>