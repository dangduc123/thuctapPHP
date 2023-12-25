<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
    <title>User Information</title>
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
			margin-top: 100px;
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
		
		.pagination a{
			text-decoration: none;
			background-color: #111;
			color: #fff;
			padding: 10px;
			border-radius: 8px;
			font-weight: bold;
		}
		
		table, th, td {
			border: none;
		}
		
		table tr th{
			text-align: center;
		}
		
		table tr td{
			text-align: center;
		}
		
		.alert-danger{
			margin-top: 100px;
		}
		
		.alert-success{
			margin-top: 100px;
		}
    </style>
	<script>
		function confirmDelete(id) {
			if (confirm("Bạn có chắc chắn xóa người này ra khỏi danh sách không?")) {
				// Nếu người dùng nhấn OK, hãy chuyển hướng đến URL xóa
				window.location.href = '/user/delete_user/' + id;
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
<h1>Danh sách khách hàng</h1>

    <form id="permissionsForm" action="{{ route('user.user_list') }}" method="get">
        <input type="text" name="search" placeholder="Tìm kiếm...">
        <input type="submit" value="Tìm">
    </form>

    @if(count($users) > 0)
        <table>
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Vai trò</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Sửa</th>
                <th>Xóa</th>
				<th>Quyền</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>
						@foreach ($user->roles as $role)
							{{ $role->name }}
						@endforeach
					</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td><a class="sua" href="{{ route('user.edit_user', ['id' => $user->id]) }}">Sửa</a></td>
                    <td><a class="xoa" href="#" onclick="confirmDelete({{ $user->id }})">Xóa</a></td>
					<td>
						<form id="permissionsForm" method="POST" action="{{ route('update_permissions', $user->id) }}">
							@csrf
							@method('PUT')
							@foreach ($user->roles as $role)
								<input type="checkbox" name="permissions[]" value="add" {{ $role->permissions->contains('name', 'add') ? 'checked' : '' }}> Add
								<input type="checkbox" name="permissions[]" value="edit" {{ $role->permissions->contains('name', 'edit') ? 'checked' : '' }}> Edit
								<input type="checkbox" name="permissions[]" value="delete" {{ $role->permissions->contains('name', 'delete') ? 'checked' : '' }}> Delete
							@endforeach
							<button style="background-color: green; height: 30px; border-radius: 8px; outline: none; border: none; color: #fff;"type="submit">Cập nhật quyền</button>
						</form>
					</td>
                </tr>
            @endforeach
        </table>
		<div class="pagination" style="text-align: center; padding-top: 40px;">
			@if ($users->currentPage() > 1)
				<a href="{{ route('user.user_list', ['page' => $users->currentPage() - 1, 'search' => request('search')]) }}"><-</a>
			@endif
			
			@for ($i = 1; $i <= $users->lastPage(); $i++)
				<a href="{{ route('user.user_list', ['page' => $i, 'search' => request('search')]) }}" class="{{ $i == $users->currentPage() ? 'active' : '' }}">{{ $i }}</a>
			@endfor

			@if ($users->currentPage() < $users->lastPage())
				<a href="{{ route('user.user_list', ['page' => $users->currentPage() + 1, 'search' => request('search')]) }}">-></a>
			@endif
		</div>
    @else
        <p>Không có kết quả</p>
    @endif
@endsection



<script>
document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện khi form "Cập nhật quyền" được submit
    var permissionsForm = document.getElementById('permissionsForm');
    if (permissionsForm) {
        permissionsForm.addEventListener('submit', function (event) {
            event.preventDefault();

            var form = event.target;
            var formData = new FormData(form);

            // Thực hiện yêu cầu POST không đồng bộ
            fetch('/update_permissions', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': formData.get('_token')
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
    }
});
</script>

</body>
</html>