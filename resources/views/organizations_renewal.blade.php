@extends('layouts.master')

@section('title', 'SAO | Update Checklist of Requirements')

@section('header-page')
<div class="row">
	<div class="col-md-12">
		<h1>Requirements Checklist</h1>
		<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Organizations Renewal Management
        </li>
        <li class="active">
            <strong>Requirements Checklist</strong>
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
				<h5>Update Checklist of Requirements</h5>
			</div>

			<div class="ibox-content">
				<form role="form" id="UpdateRequirement" method="POST" action="/organizationsRenewal/update">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="update_id" id="update_id">

						<div id="try" style="display:none">
								<div class="sk-spinner sk-spinner-wave">
									<div class="sk-rect1"></div>
									<div class="sk-rect2"></div>
									<div class="sk-rect3"></div>
									<div class="sk-rect4"></div>
									<div class="sk-rect5"></div>
								</div>

							</div>

					

				<div class="row">
<!-- 					<div class="col-md-4">
						<label>Select Organization</label>
						<div class="input-group ">
							<input type="text" placeholder="Name of Organization" id="organizationName" name="organizationName" class="form-control" autofocus="" aria-required="true">
						<div class="input-group-btn">
                            <button type="button" class="btn btn btn-primary" name="search_organizationBtn" id="search_organizationBtn">
                                Search
                            </button>
                        </div>
						</div>
					</div> -->

						<div class="col-md-6">
							<div class="form-group">

								<label>Select Organization</label>
								<select name="organizationName" id="organizationName" class="form-control">
								<option autofocus="" disabled selected value=>Select Organization</option>
									@foreach ($organizations as $organization)
									<option>{{$organization->organization }}</option>
									
							
								
									@endforeach
									
								</select>	





							</div>
					</div>



					<div class="col-md-6">
						<div class="form-group">

								<label>School Year</label>
<!-- 								<select name="year" id="year" class="form-control">

									@foreach ($schoolyear as $schoolyear)
									<option>{{$schoolyear->school_year }}</option>
									
							
								
									@endforeach
									
								</select>	 -->


									<output id="school_year1" name="school_year1" class="form-control" autofocus="" aria-required="true"  >{{$schoolyear->school_year }}</output>
									<input type="hidden" id="school_year" name="school_year" class="form-control" autofocus="" aria-required="true" value="{{$schoolyear->school_year }}">
					</div>
					</div>
				
				</div>

			</div>	

			<div class="ibox-footer">
				<div class="row">
					<div class="col-md-6">
							<div class="input-group">
								 <label>1. Constitution and By-Laws Signed by Officers (<i>Complete Signatures</i>)</label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement1" id="requirement1a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement1" id="requirement1b"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
					</div>
<!-- 				</div>
			</div>


			<div class="ibox-footer">
				<div class="row"> -->
					<div class="col-md-6">
							<div class="form-group">
								 <label>2. Officers List <i>(Name, Address, Signature, Postition, Contact Number)</i></label>
								
                                    <div class="col-sm-10">
                                   
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement2" id="requirement2a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement2" id="requirement2b"> <i> Not Submitted</i></label></div>
                                   
                                    </div>
                                

							</div>
					</div>
				</div>
			</div>


			<div class="ibox-footer">
				<div class="row">
					<div class="col-md-6">
							<div class="form-group">
								<label>3. Grades of Elected Officers<i>(no failing grade/FDA)</i></label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement3" id="requirement3a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement3" id="requirement3b"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
					</div>
<!-- 				</div>
			</div>

			<div class="ibox-footer">
				<div class="row"> -->
					<div class="col-md-6">
							<div class="form-group">
								<label>4. Proposed Activities <i>(w/dates of implementation)</i></label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement4" id="requirement4a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement4" id="requirement4b"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
					</div>
				</div>
			</div>

			<div class="ibox-footer">
				<div class="row">
					<div class="col-md-6">
							<div class="form-group">
								<label>5. Annual Report<i>(Activity reports)</i>/ Accomplishements</label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement5" id="requirement5a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement5" id="requirement1b"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
					</div>
<!-- 				</div>
			</div>

			<div class="ibox-footer">
				<div class="row"> -->
					<div class="col-md-6">
							<div class="form-group">
								<label>6. Audited Financial Report<i>(w/receipts)</i></label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement6" id="requirement6a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement6" id="requirement6b"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
					</div>
				</div>
			</div>


			<div class="ibox-footer">
				<div class="row">
					<div class="col-md-6">
							<div class="form-group">
								<label>7. Recommendation of Adviser <i>(must be sign by Dean)</i></label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement7" id="requirement7a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement7" id="requirement7b"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
					</div>
<!-- 				</div>
			</div>

			<div class="ibox-footer">
				<div class="row"> -->
					<div class="col-md-6">
							<div class="form-group">
								<label>8. Photocopy of EAF of each officer for the preceding semester</label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement8" id="requirement8a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement8" id="requirement8b"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
					</div>
				</div>
			</div>

			<div class="ibox-footer">
				<div class="row">
					<div class="col-md-6">
							<div class="form-group">
								<label>9. Updated List of Members<i>(at least 30, with their address and contact number)</i></label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="requirement9" id="requirement9a"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio"  checked=""  value="0" name="requirement9" id="requirement9b"> <i> Not Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
					</div>
<!-- 				</div>
			</div>

			<div class="ibox-footer">
				<div class="row"> -->
					<div class="col-md-6">
							<div class="form-group">
								<label>10. Activity Documentation </label>
								
                                    <div class="col-sm-10">
                                     
                                       <center><input type="text" placeholder="Input Number of Documents" id="requirement10" name="requirement10"  class="form-control" autofocus="" aria-required="true"></center>
                                    
                                    </div>
                                

							</div>	
					</div>
				</div>
			</div>

			<div class="ibox-footer">
				<div class="row">
					<div class="col-md-6">
							<div class="form-group">
								<center><label>Deadline for Requirements </label></center>
								
                                   
                                     
                                       <center><input type="text"  id="deadline" name="deadline"  class="form-control" autofocus="" aria-required="true"></center>
                                    
                                    
							</div>	
					</div>
					<div class="col-md-6">
						<center><label>Remarks</label></center>
						<div class="form-group">
							<center><input type="text" placeholder="Input Remarks" id="requirement11" name="requirement11"  class="form-control" autofocus="" aria-required="true"></center>

						</div>
					</div>

				
				</div>
			</div>
			


					<div class="ibox-footer">

						<button class="btn btn-w-m btn-primary" id="update_requirementBtn" type="button">
							<strong>Update</strong>
						</button>

						<button class="btn btn-w-m btn-danger" id="cancel_requirementBtn" type="button">
							<strong>Cancel</strong>
						</button>
						<input type="hidden" value="{{Session::token()}}" name="_token">
						</form>

					</div>



		


		</div>


	</div>


</div>

<script>


	$('button#add_requirementBtn').click(function(e) {

		e.preventDefault();

		$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			type : "POST",
			url : "/organizationsRenewal/add",
			data : $('form#UpdateRequirement').serialize(),

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

				swal('Success!', 'Added New Requirement List', 'success');
				

	

			}
		});

	});






		$('button#update_requirementBtn').click(function(e) {

		e.preventDefault();

		$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			type : "POST",
			url : "/organizationsRenewal/update",
			data : $('form#UpdateRequirement').serialize(),

		}).done(function(data) {

			var msg = "";
			if (data.success == false) {
				$.each(data.errors, function(k, v) {
					msg = msg + v + "\n";
					swal("Oops...", msg, "warning");

				});

			} else {

			swal({   
			 	title: "Success!",  
			 	 text: "Requirements Updated",   
			 	 timer: 2000, 
			 	 type: "success",  
			 	 showConfirmButton: false 
			 	});
				



	

			}
		});

	});



	// $('button#search_organizationBtn').click(function(e) {
	

	$('#organizationName').on('change', function(e){

		var req_id = $('#organizationName').val();

		var year_id = $('#school_year').val();
	

		if (req_id.length <= 0){

			$('#requirement10').val("").attr("readonly",false);	
			$('#requirement11').val("").attr("readonly",false);	
		}

		else {
		$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			type : "GET",
			url : "/OrganizationsRenewal/Search",
			data : 
			{
				organization : req_id, year : year_id
			},


		}).done(function(data) {
				x();



				var update_id = data.id;
				var organization = data.organization;
				var deadline = data.deadline;	
				var requirement1 = data.requirement1;
				var requirement2 = data.requirement2;
				var requirement3 = data.requirement3;
				var requirement4 = data.requirement4;
				var requirement5 = data.requirement5;
				var requirement6 = data.requirement6;
				var requirement7 = data.requirement7;
				var requirement8 = data.requirement8;
				var requirement9 = data.requirement9;
				var requirement10 = data.requirement10;
				var requirement11 = data.requirement11;


				if (requirement1 ==1){
				$('#requirement1a').prop("checked", true);

				
				} else {
				
				$('#requirement1b').prop("checked", true);
				}

				if (requirement2 ==1){
				$('#requirement2a').prop("checked", true);
				
				} else {
				
				$('#requirement2b').prop("checked", true);
				}

				if (requirement3 ==1){
				$('#requirement3a').prop("checked", true);

				
				} else {
				
				$('#requirement3b').prop("checked", true);
				}

				if (requirement4 ==1){
				$('#requirement4a').prop("checked", true);
				
				} else {
				
				$('#requirement4b').prop("checked", true);
				}

				if (requirement5 ==1){
				$('#requirement5a').prop("checked", true);
				
				} else {
				
				$('#requirement5b').prop("checked", true);
				}

				if (requirement6 ==1){
				$('#requirement6a').prop("checked", true);
				
				} else {
				
				$('#requirement6b').prop("checked", true);
				}

				if (requirement7 ==1){
				$('#requirement7a').prop("checked", true);
				
				} else {
				
				$('#requirement7b').prop("checked", true);
				}

				if (requirement8 ==1){
				$('#requirement8a').prop("checked", true);
				
				} else {
				
				$('#requirement8b').prop("checked", true);
				}

				if (requirement9 ==1){
				$('#requirement9a').prop("checked", true);
				
				} else {
				
				$('#requirement9b').prop("checked", true);
				}

				$('#requirement10').val(requirement10);
				$('#requirement11').val(requirement11);
				$('#update_id').val(update_id);

				var datetoday = new Date();
				var date = new Date(deadline);
				var options = {year: "numeric", month: "long", day: "numeric"};
     			var newdate = date.toLocaleDateString('en-US', options);


				if(datetoday>=deadline)
				{
				// $('#deadline').val(deadline);
				$('#deadline').val(newdate).css("color", "red");
				}
				else
				{
				$('#deadline').val(newdate);
				// $('#deadline').val("deadline");	
				}	



			
	

			});

		}



	});



function x(){
	$('#try').show();
setTimeout(function(){

        $('#try').fadeOut('fast');
    },200);
}

	$('button#cancel_requirementBtn').click(function() {
		$('form#UpdateRequirement').each(function() {
			this.reset();
		});
	}); 






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
