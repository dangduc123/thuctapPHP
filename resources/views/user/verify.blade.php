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
@extends('user.index')
@section('content')
    <div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">{{ __('Verify Your Email Address') }}</div>

					<div class="card-body">
						@if (session('resent'))
							<div class="alert alert-success" role="alert">
								{{ __('A fresh verification link has been sent to your email address.') }}
							</div>
						@endif

						{{ __('Before proceeding, please check your email for a verification link.') }}
						{{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
					</div>
				</div>
			</div>
		</div>
	</div>
	

@endsection
</body>