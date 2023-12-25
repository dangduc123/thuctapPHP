<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link rel="stylesheet" href="./backend/css/index.css"> <!-- Import CSS từ trang index -->

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

        input, select {
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
		
    </style>
	<!--<script>
		setTimeout(function() {
			document.getElementById('error-message').style.display = 'none';
		}, 3000);  // The message will be hidden after 5 seconds
	</script>-->
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

    <form method="POST" action="{{ route('admin.register') }}">
        @csrf
        <h2>Admin Register</h2>
		@if ($errors->any())
			<div id="error-message" style="color: red;">
				@foreach ($errors->all() as $error)
					<p>{{ $error }}</p>
				@endforeach
			</div>
		@endif
        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
		<br>
		<a href="{{ route('admin.login') }}">Đến trang đăng nhập</a>
    </form>

</body>
</html>
