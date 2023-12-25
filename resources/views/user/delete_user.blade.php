<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
	@can('access-admin')
    <h1>Xóa khách hàng</h1>

    <form action="{{ route('user.delete', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" value="{{ $admin->id }}" disabled="disabled" readonly>
        </div>

        <div class="form-group">
            <label for="user_name">Tên khách hàng:</label>
            <input type="text" id="user_name" name="user_name" value="{{ $user->user_name }}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" readonly>
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" value="{{ $user->address }}" readonly>
        </div>
		
		<div class="form-group">
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ $user->phone_number }}" readonly>
        </div>

        <div class="form-group">
            <label for="created_at">Ngày tạo:</label>
            <input type="text" id="created_at" name="created_at" value="{{ $admin->created_at }}" readonly>
        </div>

        <div class="form-group">
            <label for="updated_at">Ngày cập nhật:</label>
            <input type="text" id="updated_at" name="updated_at" value="{{ $admin->updated_at }}" readonly>
        </div>

        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')">Xóa khách hàng</button>
    </form>
	@endcan
</body>
</html>
