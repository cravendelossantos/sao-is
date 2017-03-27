@extends('layouts.master')

@section('title', 'SAO | Add  Activity')

@section('header-page')
<div class="row">
	<div class="col-md-12">
		<h1>Add Activity</h1>
		<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Monitoring of Proposal of Activities
        </li>
        <li class="active">
            <strong>Sanctions Monitoring</strong>
        </li>
	</ol>
	</div>
</div>
@endsection


@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>Add Activitiy</h5>
				<div class="ibox-tools">

				</div>
			</div>
			<div class="ibox-content">

				<form role="form" id="AddActvity" method="POST" action="/postAddActivity">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="row">
<!-- 						<div class="col-md-6">
							<div class="form-group ">
								<label>Organization</label>
								<input type="text" placeholder="Name of Organization" name="organizationName" class="form-control" autofocus="" aria-required="true">
							</div>
						</div> -->

						<div class="col-md-4">
							<div class="form-group">

								<label>Select Organization</label>
								<select name="organizationName" id="organizationName" class="form-control">
								<option autofocus="" disabled selected >Select Organization</option>
									@foreach ($organizations as $organization)
									<option>{{$organization->organization }}</option>
									
							
								
									@endforeach
									
								</select>	





							</div>
						</div>





						<div class="col-md-4">
							<div class="form-group">
								<label>Title</label>
								<input type="text" placeholder="Title of Activity" name="title" class="form-control">
							</div>
						</div>

											<div class="col-md-3">
						<div class="form-group">

								<label>School Year</label>
<!-- 								<select name="school_year" id="school_year" class="form-control" >
\
									@foreach ($schoolyears as $schoolyear)
									<option>{{$schoolyear->school_year }}</option>
									
							
								
									@endforeach
									
								</select>	 -->

									<output id="school_year1" name="school_year1" class="form-control" autofocus="" aria-required="true"  >{{$schoolyear->school_year }}</output>
									<input type="hidden" id="school_year" name="school_year" class="form-control" autofocus="" aria-required="true" value="{{$schoolyear->school_year }}">





					</div>
					</div>




						<div class="col-md-6">
							<div class="form-group" id="data_1">
								<label>Date of Activity</label>
								<div class="input-group date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" class="form-control" name="date" placeholder="Pick Date" >
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Submitted Documentation</label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="status"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="status"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
						</div>

					</div>

			</div>

			<div class="ibox-footer">
				<button class="btn btn-w-m btn-primary" id="add_proposalBtn" type="button">
					<strong>Add</strong>
				</button>
				<button class="btn btn-w-m btn-danger" id="lost_and_found_cancelBtn" type="button">
					<strong>Cancel</strong>
				</button>
				<input type="hidden" value="{{Session::token()}}" name="_token">
				</form>
			</div>

		</div>

	</div>
</div>


<script>
	$('button#add_proposalBtn').click(function(e) {

		e.preventDefault();

		$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			type : "POST",
			url : "/postAddActivity",
			data : $('form#AddActvity').serialize(),

		}).done(function(data) {

			var msg = "";
			if (data.success == false) {
				$.each(data.errors, function(k, v) {
					msg = msg + v + "\n";
					swal("Oops...", msg, "warning");

				});

			} else if (data.success == true) {

				$('form#AddActvity').each(function() {
					this.reset();
				});
				$("#table-content").fadeTo("slow", 0.3);

				swal('Success!', 'Added Proposal', 'success');

	

			}
		});

	});



	$('button#lost_and_found_cancelBtn').click(function() {
		$('form#AddActvity').each(function() {
			this.reset();
		});
	}); 
</script>	

@endsection

