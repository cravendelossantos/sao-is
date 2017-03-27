<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>SAO | Register</title>

		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

		<link href="/css/animate.css" rel="stylesheet">
		<link href="/css/style.css" rel="stylesheet">
		<link href="/css/mystyle.css" rel="stylesheet">
	</head>

	<body class="white-bg">

		<div class="loginColumns animated fadeInDown">

			<div class="row">

				<div class="col-md-6">
					<img src="/img/lpulogo.png" height="388" width="366">

				</div>
				<div class="col-md-6">
					<div id="regDone" style="display : none">
						
					</div>
					
					<form class="m-t" role="form" id="regForm" method="POST" action="/register">

					<h1>Create a new account</h1>
					{!! csrf_field() !!}
					<div class="row">
					<div class="form-group">
					<div class="col-md-6">

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
					<input type="text" class="form-control"  style="text-transform: capitalize;" name="first_name" value="{{ old('first_name')}}" placeholder="First name" autocomplete="off" required autofocus>
					</div>

					<div class="col-md-6">
					<input type="text" class="form-control"  style="text-transform: capitalize;" name="last_name" value="{{ old('last_name') }}"  placeholder="Last name" autocomplete="off" required>
					</div>
					</div>
					</div>
				
					<br>
					<div class="form-group">
					<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="off">
					</div>
					<div class="form-group">

					<input type="password" class="form-control" placeholder="Password" name="password">
					</div>

					<div class="form-group">

					<input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">
					</div>

					</p>
					<div>
					<button type="button" id="registerBtn" class="btn btn-lpu block full-width m-b">
					Register
					</button>
					</div>
					</form>

					<!--
					<p class="m-t">
					<small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
					</p>-->

				</div>

			</div>
		</div>
		<br>
		<br>
		<br>

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
<link href="/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="/css/animate.css" rel="stylesheet">
<link href="/css/style.css" rel="stylesheet">
<link href="/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<script src="/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/js/plugins/chartJs/Chart.min.js"></script>
<link href="/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.10.4.min.js"></script>

<link rel="stylesheet" type="text/css" href="/css/plugins/jQueryUI/jquery-ui.css" />

<!-- Mainly scripts -->
<script src="/js/jquery-2.1.1.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/js/jquery-ui-1.10.4.min.js"></script>

<!-- jQuery UI -->
<script src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Sweet Alert -->
<script src="/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/js/plugins/chartJs/Chart.min.js"></script>

