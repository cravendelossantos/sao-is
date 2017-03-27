<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	
	<title>SAO | Log In</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/animate.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
	
</head>

<body class="white-bg">

	<div class="loginColumns1 ">
		
		<div class="row">

			<div class="col-md-5 animated fadeInLeft">

				<div class="animated flipInX">
				<center><img src="/img/lpu.png" class="img-responsive" alt="SAO-IS Logo"></center>
				</div>
				<h1>Log In</h1> 
				<div class="">
					<form class="m-t" role="form" id="loginForm" method="POST" action="{{ url('/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						{!! csrf_field() !!}

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

							<input type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" name="email" required="" autofocus="">

						</div>
						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

							<input type="password" class="form-control" placeholder="Password" name="password" required="">

						</div>


						
						@if (count($errors) > 0)

						@foreach ($errors->all() as $error)
						<div class="alert alert-danger">
							{{ $error }}
						</div>
						@endforeach

						@endif
						<button type="submit" id="loginBtn" class="btn btn-lpu block full-width m-b">
							<i class="fa fa-sign-in"></i>&nbsp;Log In
						</button>
						<a href="{{ url('/password/reset') }}"><center><small>Forgot password?</small></center></a>

						
						
					</form>
					

				</div>


			</div>



			<div class="col-md-offset-1 col-md-6 animated fadeInRight">

			{!! $content->value !!}
	
			</div>
			</div>

		</div>
		
		<hr/>
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center fixed">
				Lyceum of the Philippines University - Cavite
				<br>
				<small>&copy; 2016 - {{ Carbon\Carbon::now()->format('Y') }}</small>
			</div>
			
		</div>
	</body>

	</html>
