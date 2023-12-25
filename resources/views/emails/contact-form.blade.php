<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <title>Welcome Email</title>
	<style>
		
	</style>
</head>
<body>
    <div>
		<h2>Tên khách hàng: {{ $data['name'] }}</h2>
		<br/>
		Email khách hàng: {{ $data['email'] }}
		<br/>
		Nội dung: {{ $data['message']}}
		
	</div>
</body>
</html>