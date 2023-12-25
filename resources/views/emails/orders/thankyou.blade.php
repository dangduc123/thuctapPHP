<!DOCTYPE html>
<html>
<head>
    <title>Cảm ơn bạn đã đặt hàng</title>
</head>
<body>
    <h1 style="color: #75601c;">Cảm ơn bạn đã đặt hàng ở Tiệm Cà Phê!</h1>

    <p style="color: #75601c;">Chúng tôi đã nhận được đơn hàng của bạn và sẽ bắt đầu xử lý nó ngay lập tức.</p>

    <h2 style="color: #75601c;">Thông tin đơn hàng:</h2>

    <ul>
        @foreach ($invoice->invoiceDetails as $detail)
            <li style="color: #75601c;">
                Sản phẩm: {{ $detail->product->product_name }}
                <ul>
                    <li>Số lượng: {{ $detail->quantity }}</li>
                    <li>Giá: {{ $detail->price }}đ</li>
                    <li>Tổng tiền: {{ $detail->total_price }}đ</li>
                </ul>
            </li>
        @endforeach
    </ul>

    <p style="color: #75601c;">Tổng tiền đơn hàng: {{ $invoice->invoiceDetails->sum('total_price') }}đ</p>

    <p style="color: #75601c;">Cảm ơn bạn đã mua sắm!</p>
</body>
</html>
