@extends('layouts.master')

@section('title', 'SAO | My Profile')

@section('header-page')
<div class="row">
<div class="col-md-12">
	
	<div>
		<img src="/img/avatars/{{ Auth::user()->avatar }}" class="img-circle"  height="180px" width="180px" style="float:left; border-radius: 50%; margin-right: 30px; margin-top: 30px;"/>
	</div>
	<h1>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} ({{ Auth::user()->roles->first()->description }})</h1>
	
	<p><i class="fa fa-map-marker"></i>&nbsp; {{ Auth::user()->address }}
	<br>{{ Auth::user()->email }}
	<br>{{ Auth::user()->contact_no }}
	</p>

	<hr/>
	<div class="row col-md-4">
	@if ($message = Session::get('success'))
	<div class="alert alert-success" role="alert">
		{{ Session::get('success') }}
	</div>
	@elseif ($message = Session::get('errors'))
	<div class="alert alert-danger" role="alert">
		{{ Session::get('errors') }}
	</div>
	@endif
	
	<form enctype="multipart/form-data" action="/upload/avatar" method="POST">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<label>Change Profile Picture</label>
		<i class="fa fa-picture-o"></i>
		<input type="file" name="avatar" class="btn btn-white btn-xs">
		</label>
	</div>
	<div class="row col-md-offset-1 col-md-5 title-action">	
		<button class="pull-right btn btn-lg btn-default" value=""><i class="fa fa-upload"></i>&nbsp; Update Profle Picture</button>
	</div>
	</form>

</div>
</div>



@endsection

@section('content')

<div class="row">

	<div class="col-md-12 animated fadeInRight">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<h2 class="font-bold">Update your account</h2>
				<hr/>

				<form class="m-t" role="form" id="account_update" method="post" action="">
					{{ csrf_field() }}
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label>First Name</label>
								<input type="text" class="form-control"  style="text-transform: capitalize;" name="first_name" value="{{ Auth::user()->first_name }}" placeholder="First name" autocomplete="off" required autofocus>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Last Name</label>
								<input type="text" class="form-control"  style="text-transform: capitalize;" name="last_name" value="{{ Auth::user()->last_name }}"  placeholder="Last name" autocomplete="off" required>
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label>E-mail</label>
								<input type="email" class="form-control" placeholder="E-mail" name="email" value="{{ Auth::user()->email }}" autocomplete="off">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Birth Date</label>
								<div class="form-group" id="reg_bday">

									<div class="input-group date" id="data_1">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" id="birthdate" name="birthdate" class="form-control" placeholder="Birthdate" value="{{ Auth::user()->birthdate }}">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label>Contact Number</label>
								<div class="input-group m-b">
									<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
									<input type="text" placeholder="Contact No.	" class="form-control" id="contact_number" name="contact_number" maxlength="13" value="{{ Auth::user()->contact_no }}">
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Adress</label>
								<textarea class="form-control" placeholder="Address" id="address" name="address" value="" style="height: 100px; resize: vertical; text-transform: capitalize;">{{ Auth::user()->address }}</textarea>
							</div>
						</div>

					</div>

					<br>
					<div class="form-group">
						<button type="button" id="update_account_btn" class="btn btn-lpu block full-width m-b"><i class="fa fa-save"></i> Save Changes</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#update_account_btn').click(function(e) {
		e.preventDefault();

		$.ajax({
			type : "GET",
			url : "/profile/edit/check",
			data : $('form#account_update').serialize(),

		}).fail(function(data) {
			var errors = $.parseJSON(data.responseText);
			var msg = "";

			$.each(errors.errors, function(k, v) {
				msg = msg + v + "\n";
				swal("Oops...", msg, "warning");

			});

		}).done(function(data) {

			swal({
				title : "Are you sure?",
				text : "This will update your account details",
				type : "warning",
				showCancelButton : true,
				confirmButtonColor : "#DD6B55",
				confirmButtonText : "Submit",
				closeOnConfirm : true
			}, function() {
				$.ajax({
					headers : {
						'X-CSRF-Token' : $('input[name="_token"]').val()
					},
					type : "POST",
					url : "/profile/edit",
					data : $('form#account_update').serialize(),
				}).done(function(data) {

					$('form#account_update').each(function() {
						this.reset();
					});
							 swal({   
			 			title: "Success!",  
			 	 text: data.response,   
			 	 timer: 2000, 
			 	 type: "success",  
			 	 showConfirmButton: true

	
			 	}, function(isConfirm){
			 		window.location.reload();
			 	});
					
				});
			});
		});

	});

</script>

@endsection