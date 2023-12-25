<!-- resources/views/admin/product/create.blade.php -->
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('backend/css/index.css') }}">
	<style>
		h2{
			text-align: center;
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
			
		}
		
		button a{
			color: white;
			text-decoration: none;
		}
		
		select{
			height: 30px;
			border-radius: 8px;
		}
		
		input{
			height: 30px;
			border-radius: 8px;
		}
		
		p{
			color: red;
		}
		
		
		
		
	</style>
</head>
<body>
@extends('admin.index')

@section('content')
    <h1>Phân quyền</h1>

    <form method="POST" action="{{ route('admin.update', ['id' => $admin->id]) }}">
		@csrf
		@method('PUT')

		<label for="user_type">Chức vụ:</label>
		@if($admin->user_type != 'admin')
			<select name="user_type" required>
				<option value="admin" @if($admin->user_type == 'admin') selected @endif>Admin</option>
				<option value="author" @if($admin->user_type == 'author') selected @endif>Author</option>
				<option value="editor" @if($admin->user_type == 'editor') selected @endif>Editor</option>
				<option value="subscriber" @if($admin->user_type == 'subscriber') selected @endif>Subscriber</option>
			</select>
		@else
			<p>Không thể phân quyền cho admin!</p>
		@endif

		<label for="email">Email:</label>
		<input type="email" name="email" value="{{ $admin->email }}" disabled="disabled" required>

		@if($admin->user_type != 'admin')
			<button type="submit">Cập nhật</button>
		@else
			<button><a href="{{ route('admin.admin_list') }}" class="btn btn-default">Trở về</a></button>
		@endif
	</form>

@endsection
</body>
</html>
