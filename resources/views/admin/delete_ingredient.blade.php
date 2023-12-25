<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Ingredient</title>
</head>
<body>
	@can('access-admin')
    <h1>Xóa Nguyên liệu</h1>

    <form action="{{ route('admin.delete_ingredient', $ingredient->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" value="{{ $ingredient->id }}" readonly>
        </div>

        <div class="form-group">
            <label for="ingredient_name">Tên nguyên liệu:</label>
            <input type="text" id="ingredient_name" name="ingredient_name" value="{{ $ingredient->ingredient_name }}" readonly>
        </div>

        <div class="form-group">
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" value="{{ $ingredient->quantity }}" readonly>
        </div>

        <div class="form-group">
            </br><label for="unit">Đơn vị:</label></br></br>
			<select name="unit" class="form-control" required>
				<option value="kg" {{ $ingredient->unit === 'kg' ? 'selected' : '' }}>Kg</option>
				<option value="túi" {{ $ingredient->unit === 'túi' ? 'selected' : '' }}>Túi</option>
				<option value="hộp" {{ $ingredient->unit === 'hộp' ? 'selected' : '' }}>Hộp</option>
			</select>
        </div>

        <div class="form-group">
            </br><label for="status">Trạng thái:</label></br>
			<select name="status" class="form-control" required>
				<option value="active" {{ $ingredient->status === 'active' ? 'selected' : '' }}>Active</option>
				<option value="inactive" {{ $ingredient->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
			</select></br>
        </div>

        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" id="price" name="price" value="{{ $ingredient->price }}" readonly>
        </div>

        <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa nguyên liệu này không?')">Xóa Nguyên liệu</button>
    </form>
	@endcan
</body>
</html>