@extends('layouts.master')

@section('title', 'SAO | Text Messaging')

@section('header-page')
<div class="col-md-12">
	<h1>Compose Text Message</h1>
	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
       		Text Messaging
        </li>
        <li class="active">
            <strong>Compose Text message</strong>
        </li>
	</ol>
	<hr/>	
	
	@if (count($errors) > 0)
    <div class="alert alert-danger">
        
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        
    </div>
	@endif

	@if ($message = Session::get('api_code_response'))
		<div class="alert alert-success" role="alert">
			{{ Session::get('api_code_response') }}
		</div>
	@endif

	<div class="form-group pull-right">
		<form action="/text-messaging/api_code/update" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<label>API Code</label>
				
				<br>

				<div class="input-group" style="width: 220px;">
					<input type="hidden" name="api_code_id" value="{{ $keys->id }}">
					<input type="text" name="api_code" class="form-control" placeholder="Your API Code" value="{{ $keys->api_code }}">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="submit">Save</button>
					</span>
				</div>
				<br>
			<a target="_blank" class="btn btn-warning btn-rounded btn-sm" href="https://www.itexmo.com/Developers/packages/index.php" style="width: 220px;"><i class="fa fa-money"></i>&nbsp;Buy package from iTexMo.com</a>
		</form>		
	</div>
	
	<div class="form-group">
		@if (count($credits) == null)
			<label id="available-credits" style="color: red;">Failed to communicate with the SMS server. Please check your connection</label>
		
		@elseif ($credits == false)
			
			<label style="color: red;"><h3>API Code is required</h3></label>
			<li>Please use a valid API Code.</li>
			<li>Click the buy package from iTexMo button to purchase a new package or visit www.iTexMo.com</li>
		
		@else
			<div class="form-group">
			<h3>Available Credits:</h3>
			<h2><label id="available-credits" style="color: green;"> {{ $credits }} </label></h2>

			<small>Number of credits/message per day will reset every (PHT) 12:00AM</small>
			</div>


		@endif
		
			
		
	</div>


	
	

	<!-- <form action="/modem-test" method="get">
	<div class="form-group">
	<button class="btn btn-primary">Test Modem Connection</button>
	</div>
	</form>
	<form action="/modem-info" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
	<button class="btn btn-primary">Device Status</button>
	</div>
	</form> -->
</div>

@endsection

@section('content')

<div class="row">

	<div class="col-md-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>Compose a message</h5>
			</div>
				<div id="try" style="display:none">

								<div class="sk-spinner sk-spinner-wave">
									<div class="sk-rect1"></div>
									<div class="sk-rect2"></div>
									<div class="sk-rect3"></div>
									<div class="sk-rect4"></div>
									<div class="sk-rect5"></div>
								<h5>Sending...</h5>
								</div>

							</div>

			<div class="ibox-content">


				<form id="text-messaging-form">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="api_key" value="{{ $keys->api_code }}">
					<div class="form-group">
						<label>Mobile No.</label>
						<input type="text" value="" name="mobile_number" id="mobile_number" class="form-control" data-role="tagsinput" >

					</div>
					<div class="form-group">
						<textarea name="message" id="message" placeholder="Enter your message here" class="form-control"></textarea>
					</div>


				</div>

				<div class="ibox-footer">
					<button class="btn btn-w-m btn-primary" id="send_btn" type="button">
						<span class="fa fa-send"></span>&nbsp;<strong>Send</strong>
					</button>

				</form>
			</div>

		</div>
	</div>

</div>


<script type="text/javascript">
	$('#send_btn').click(function(){

		swal({
  title: "Send",
  text: "Are you sure you want to send this message?",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: true,
  showLoaderOnConfirm: true,
},
function(){
  $('#try').show();
		$.ajax({
		url : '/text-messaging/send',
		type: 'POST',
		data: $('form#text-messaging-form').serialize(),
	}).done(function(data){
		var msg = "";
		if (data.success == false) {
			$.each(data.errors, function(k, v) {
				msg = msg + v + "\n";
			
				$('#try').fadeOut('slow');
			

				swal("Oops...", msg, "warning");

			});

		} else {
			if (data.response[0].sent == false){
			

			$('#try').fadeOut('slow');
			


				swal("Oops...", data.response[0].response, "warning");
			}else{
			
					$('#try').fadeOut('slow');
			

				swal({   
				title: "Success!",  
				text: " " + data.response[0].response,   
				timer: 5000, 
				type: "success",  
				showConfirmButton: true 
			},function(isConfirm){
				window.location.reload();
			});

			$('form#text-messaging-form').each(function() {
				this.reset();
			});	

			}

			

		}
	});
});

	});	

</script>


<style>


	textarea { 
		resize:vertical;

	}

	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		margin: 0; 
	}
</style>


<script type="text/javascript">
	



</script>


<style>
	.sk-spinner-wave.sk-spinner {
		margin: 0 auto;
		width: 50px;
		height: 30px;
		text-align: center;
		font-size: 10px;
		position: fixed;
		z-index: 999;
		overflow: show;
		margin: auto;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
	}

	#try {
		width: auto;
		height: auto;
		position: fixed;
		z-index: 999;
		overflow: show;
		margin: auto;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		background-color: #f3f3f4;
	}
	#try2 {
		width: auto;
		height: auto;
		position: fixed;
		z-index: 999;
		overflow: show;
		margin: auto;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		background-color: #f3f3f4;
	}
</style>

@endsection