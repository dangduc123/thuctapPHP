<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
	<style>
		h1{
			text-align: center;
			margin-top: 100px;
		}
		form{
			margin:auto;
			text-align: center;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
			max-width: 400px; 
			padding-top: 20px;
			padding-bottom: 20px;
			border-radius: 8px;
			
		}
		
		button{
			margin: 10px 0 0 0;
			background-color:#000; 
			color: #fff;
			border-radius: 8px;
			height: 30px;
			font-weight: bold;
			margin-bottom: 20px;
		}
		
		select{
			height: 30px;
			border-radius: 8px;
		}
		
		input{
			height: 30px;
			border-radius: 8px;
			margin-bottom: 10px;
		}
		
		label{
			font-weight: bold;
		}
		
		
		
	</style>
</head>
<body>
@extends('admin.index')

@section('content')
<div class="container">
    <h1>Chỉnh sửa người dùng</h1>

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_name">Tên người dùng:</label></br>
            <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $user->user_name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label></br>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ:</label></br>
            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
        </div>

        <div class="form-group">
            <label for="phone_number">Số điện thoại:</label></br>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $user->phone_number }}" required>
        </div>

        <div class="form-group">
            <label for="role_id">Vai trò:</label></br>
            <select class="form-control" id="role_id" name="role_id" >
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button></br>
		<a style="background-color: #000; padding: 10px; text-decoration: none; border-radius: 8px; color: #fff; font-weight: bold;" href="{{ route('user.user_list') }}">Trở về</a>
    </form>
</div>
@endsection
</body>
</html>