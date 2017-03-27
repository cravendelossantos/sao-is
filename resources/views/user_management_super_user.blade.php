@extends('layouts.master')

@section('title', 'SAO | User Management (Super User)')





@section('header-page')
<div class="col-lg-12">
	<h1>Add New User</h1>
</div>

@endsection


@section('content')

<div class="row">

	<div class="col-md-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-content">



			<div class="row">

		
				<div class="col-md-12">
	
					<form class="m-t" role="form" id="regFormSuperUser" method="" action="">

					<h1>Create a new account</h1>
					{{ csrf_field() }}
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="row">
					<div class="form-group">
					<div class="col-md-6">

      
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

			<div class="alert alert-info">
  <strong>Note: </strong> This account will be set as default (administrator) user type.
</div>



					<div>
					<button type="button" id="register_super_btn" class="btn btn-lpu block full-width m-b">
					Submit
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



		</div>
	</div>
</div>		


@endsection
