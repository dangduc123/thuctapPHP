<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <link rel="stylesheet" href="./front/css/index.css"> <!-- Import CSS từ trang index -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
		h2{
			color: #75601c;
		}
        body {
            background-color: #75601c;
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            width: 400px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #75601c;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #75601c;
			outline: none;
            border-radius: 8px;
			outline: 1px solid #75601c;
        }

        button {
            background-color: #75601c;;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
			margin-bottom: 10px;
        }

        button:hover {
            background-color: #555;
        }

        /* Style checkboxes */
        .checkbox-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: row; /* Các phần tử con nằm ngang */
            align-items: center; /* Căn giữa các phần tử con theo chiều dọc */
        }

        .checkbox-group label {
            margin-right: 10px;
        }

        .checkbox-group input {
            margin-right: 5px;
        }
		
		form a{
			text-decoration: none;
			color: #000;
		}
		
		form a:hover{
			color: #555;
		}
		
		#password {
		  padding-right: 25px; /* add padding to make room for the eye icon */
		}

		.password-icon {
		  position: absolute;
		  right: 10px;
		  top: 50%;
		  transform: translateY(-50%);
		  cursor: pointer;
		}
		
		.password-container{
			display: flex;
			justify-content: center;
			align-items: center;
		}
		
		
	
		
		
    </style>
	<script>
		setTimeout(function() {
			const element = document.getElementById('error-message');
			if (element) {
				element.style.display = 'none';
			}
		}, 3000);
	</script>
</head>
<body>

    <form method="POST" action="{{ route('user.register') }}">
		@csrf
		<h2>Đăng ký</h2>
		@csrf
		@if ($errors->any())
			<div id="error-message" style="color: red;">
				@foreach ($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach
			</div>
		@endif
		<label for="user_name">Tên người dùng:</label>
		<input type="text" name="user_name" required>

		<label for="email" >Email:</label>
		<input type="email" name="email" required>

		<label for="password" >Mật khẩu:</label>
		<div style="display: flex; align-items: center;">
			<input type="password" name="password" id="password" required>
			<i id="toggle-password" style="height: 30px; padding-left: 5px;" onclick="togglePasswordVisibility('password', 'toggle-password')" class="fa fa-fw fa-eye-slash"></i>
		</div>

		<label for="password_confirmation">Xác nhận mật khẩu:</label>
		<div style="display: flex; align-items: center;">
			<input type="password" id="password_confirmation" name="password_confirmation" required>
			<i id="toggle-password-confirmation" style="height: 30px; padding-left: 5px;" onclick="togglePasswordVisibility('password_confirmation', 'toggle-password-confirmation')" class="fa fa-fw fa-eye-slash"></i>
		</div>

		<label for="address">Địa chỉ:</label>
		<input type="text" name="address" required>

		<label for="phone_number">Số điện thoại:</label>
		<input type="number" name="phone_number" required>

		<button type="submit">Đăng ký</button>
		<br>
		<a href="{{ route('user.login') }}">Đến trang đăng nhập</a>
		<br>
	</form>

	<script>
	function togglePasswordVisibility(inputId, iconId) {
	  var x = document.getElementById(inputId);
	  var y = document.getElementById(iconId);
	  if (x.type === "password") {
		x.type = "text";
		y.classList.remove("fa-eye-slash");
		y.classList.add("fa-eye");
	  } else {
		x.type = "password";
		y.classList.remove("fa-eye");
		y.classList.add("fa-eye-slash");
	  }
	}
	</script>

	

</body>
</html>
