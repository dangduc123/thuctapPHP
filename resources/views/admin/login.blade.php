<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Admin Login</title>

    <style>
        body {
            background-color: #f0f0f0;
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
            width: 300px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #333;
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

    <form method="POST" action="{{ route('admin.login') }}">
		@if (Session::has('error'))
			<div class="alert alert-danger" id="myAlert">
				{{ Session::get('error') }}
			</div>
			<script>
				setTimeout(function() {
					$('#myAlert').fadeOut('fast');
				}, 5000); // 5 giây
			</script>
		@endif
        @csrf
        <h2>Admin Login</h2>
		@if ($errors->any())
			<div id="error-message" style="color: red;">
				@foreach ($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach
			</div>
		@endif

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Mật khẩu:</label>
        <div class="password-container">
			<input type="password" id="password" name="password"  required >
			<i id="toggle-password" style="height: 30px; padding-left: 5px;"onclick="togglePasswordVisibility()" class="fa fa-fw fa-eye-slash"></i>
		</div>

        <button type="submit">Login</button>
    </form>
	
	<script>
		function togglePasswordVisibility() {
		  var x = document.getElementById("password");
		  var y = document.getElementById("toggle-password");
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