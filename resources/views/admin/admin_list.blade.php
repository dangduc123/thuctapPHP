<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
    <title>Admin Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
		
		td .sua{
			background-color: #3452eb;
			text-decoration: none;
			color: white;
			padding: 5px;
			border-radius: 8px;
		}
		
		td .xoa{
			background-color: red;
			text-decoration: none;
			color: white;
			padding: 5px;
			border-radius: 8px;
		}
		
		h1{
			text-align: center;
		}
		
		form{
			text-align: center;
		}
		
		form input:nth-child(1){
			height: 25px;
			margin-right: 5px;
			border-radius: 8px;
		}
		
		form input:nth-child(2){
			background-color:#111;
			padding: 2px;
			width: 40px;
			color: white;
			cursor: pointer;
			border-radius: 8px;
		}
		
    </style>
	<script>
		function confirmDelete(id) {
			if (confirm("Bạn có chắc chắn xóa người này ra khỏi danh sách không?")) {
				// Nếu người dùng nhấn OK, hãy chuyển hướng đến URL xóa
				window.location.href = '/admin/delete_admin/' + id;
			}
		}
	</script>
	<script>
		// Chờ cho đến khi tài liệu HTML hoàn toàn được tải xong
		document.addEventListener('DOMContentLoaded', function() {
			// Tìm tất cả các khối cảnh báo
			var alerts = document.querySelectorAll('.alert');

			// Duyệt qua từng khối cảnh báo
			alerts.forEach(function(alert) {
				// Đặt một hẹn giờ để ẩn khối cảnh báo sau 3 giây
				setTimeout(function() {
					alert.style.display = 'none';
				}, 3000);
			});
		});
	</script>
</head>
<body>
@extends('admin.index')
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<?php
// Kết nối đến cơ sở dữ liệu của bạn
echo "<h1>Danh sách phân quyền</h1>";
echo '<form action="" method="get">';
echo '<input type="text" name="search" placeholder="Tìm kiếm...">';
echo '<input type="submit" value="Tìm">';
echo '</form>';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laravel";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truy vấn để lấy thông tin từ bảng sản phẩm
$sql = "SELECT id, user_type, email, created_at, updated_at FROM admin ";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= "WHERE user_type LIKE '%$search%' OR email LIKE '%$search%' OR id LIKE '%$search%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Hiển thị dữ liệu trong bảng HTML
	echo "<style>
    table, th, td {
      border: none;
    }
    </style>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Quyền hạn</th><th>Email</th><th>Created At</th><th>Updated At</th><th>Quyền</th><th>Xóa</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["user_type"]."</td>";
        echo "<td>".$row["email"]."</td>";
        echo "<td>".$row["created_at"]."</td>";
        echo "<td>".$row["updated_at"]."</td>";
		echo '<td><a class="sua" href="'. route('admin.edit', ['id' => $row['id']]) .'">Phân quyền</a></td>';
		echo '<td><a class="xoa" href="#" onclick="confirmDelete(' . $row['id'] . ')">Xóa</a></td>';
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Đóng kết nối
$conn->close();
?>
@endsection

</body>
</html>
