<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Admin</title>
</head>
<body>
	@can('access-admin')
    <h1>Xóa Admin</h1>

    <form action="{{ route('admin.delete', $admin->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" value="{{ $admin->id }}" readonly>
        </div>

        <div class="form-group">
            <label for="user_type">Loại người dùng:</label>
            <input type="text" id="user_type" name="user_type" value="{{ $admin->user_type }}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $admin->email }}" readonly>
        </div>

        <!--<div class="form-group">
            <label for="permission">Quyền hạn:</label>
            <input type="text" id="permission" name="permission" value="{{ $admin->permission }}" readonly>
        </div>-->

        <div class="form-group">
            <label for="created_at">Ngày tạo:</label>
            <input type="text" id="created_at" name="created_at" value="{{ $admin->created_at }}" readonly>
        </div>

        <div class="form-group">
            <label for="updated_at">Ngày cập nhật:</label>
            <input type="text" id="updated_at" name="updated_at" value="{{ $admin->updated_at }}" readonly>
        </div>

        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa admin này không?')">Xóa Admin</button>
    </form>
	@endcan
</body>
</html>
