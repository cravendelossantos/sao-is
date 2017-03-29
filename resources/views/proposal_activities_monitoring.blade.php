@extends('layouts.master')

@section('title', 'SAO | List of proposal activities')

@section('header-page')
<div class="row">
	<div class="col-md-12">
		<h1>List of Proposal Activities</h1>
		<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Monitoring of Proposal of Activities
        </li>
        <li class="active">
            <strong>Monitoring of Activities</strong>
        </li>
	</ol>
	</div>
</div>
@endsection


@section('content')
<div class="row">
<div id="activities_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">Update Proposal</h4>
			</div>

			<div class="ibox-content">

				<form role="form" id="UpdateActvity" method="POST" action="/postUpdateActivity">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="update_id" id="update_id">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group ">
								<label>Organization</label>
								<input " placeholder="Name of Organization" name="organization" id="organization" class="form-control" autofocus="" aria-required="true"></output>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Title</label>
								<input placeholder="Title of Activity" name="title" id="title" class="form-control"></output>
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group" id="data_1">
								<label>Date of Activity</label>
								<div class="input-group date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" class="form-control" name="date" id="date"placeholder="Pick Date" >
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Submitted Documentation</label>
								
                                    <div class="col-sm-10">
                                     
                                        <div class="radio i-checks"><label> <input type="radio"  value="1" name="status" id="status"> <i>Submitted&nbsp &nbsp &nbsp</i> </label>    
                                        <label> <input type="radio" value="0" name="status" id="status1"> <i> To be Submitted</i></label></div>
                                    
                                    </div>
                                

							</div>
						</div>

					</div>

			</div>

			<div class="modal-footer">
				<button class="ladda-button btn btn-w-m btn-primary claimItem" id="update_proposalBtn" type="button">
					<strong>Save</strong>
				</button>
				<button type="button" class="btn btn-w-m btn-danger"
				data-dismiss="modal">
					<strong>Cancel</strong>
				<input type="hidden" value="{{Session::token()}}" name="_token">
				</form>
				</button>
			</div>
		</div>

	</div>
</div>

	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">

				<h5>Activities</h5>

				<div class="ibox-tools">

			

				</div>

			</div>

			<div class="ibox-content">



						<div class="col-md-4">
							<div class="form-group">

								<output>Select Organization</output>
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

              <output name="">School Year</output>
                @if (is_null($current_school_year) || is_null($school_year_selection))
                  <div class="alert alert-danger">
                    School year is not set. Click <a class="alert-link" href="/settings/dates/school-year">here</a> to manage dates.
                  </div>
                @else
                  <select name="school_year" id="school_year" class="form-control">
                    
                      <option>{{ $current_school_year }}</option>
                    

                    @foreach ($school_year_selection as $selection)
                      <option>{{ $selection->school_year }}</option>
                    @endforeach
                  </select> 
                @endif
      
          </div>
					</div>










			<div class="ibox-content" id="table-content">
				<div class="table-responsive">
					

						<table class="table table-striped table-bordered table-hover dataTable" id="activities-DT" width="100%">

							<thead>
						
									<th>Organization</th>
									<th>Title of Activity</th>
									<th>Date</th>
									<th>Status</th>
									<th>Action</th>
						
							</thead>
							
						
						</table>

					
				</div>

			</div>
		</div>
	</div>
</div>


<script>

		// $(document).ready(function() {
		// 	$('#').click(function() {
  //       		var row = $(this).each;

  //       		$('#myModal #organizationName').val(row.organization);
  //         		$('#myModal #title').val(row.activity);
  //         		$('#myModal #date').val(row.date);
  //         		$('#myModal #status').val(row.status);
  //       		$('#myModal').modal('show');
  // 			  });
		// });

	// 	$(document).ready(function(){
 
	// 	 $("#").click(function(e){
 // 		e.preventDefault();
 // 		$.ajax({
 // 		headers : {
 // 				'X-CSRF-Token' : $('input[name="_token"]').val()
 // 			},
 // 			url: "/ActivityDetails",
 // 			type: "GET",
 // 			data: {
 // 				id : id	
 // 				},
 // 		}).done(function(data){

 
	// 	 	var msg = "";
 // 			if (data.success == false) {
 // 				$.each(data.errors, function(k, v) {
 // 					msg = msg + v + "\n";
 // 					swal("Oops...", msg, "warning");
 
 // 				});
 
 // 			} else {
 
 // 				var organization = data.response['organization'];
 // 				var activity = data.response['activity'];
 // 				var date = data.response['date'];
 // 				var status = data.response['status'];
 				
 
 // 				$('#organizationName').val(organization);
 // 				$('#title').val(activity);
 // 				$('#date').val(date);
 // 				$('#status').val(status);	
 
 // 			}
 
 // });
 
 // 	$('#myModal').modal("show");
 
 // });
 
 // });


$(document).ready(function(){

// var sy_id = $('#school_year').val();
// var org_id = $('#organizationName').val();

//
var activities_table = $('#activities-DT').DataTable({
	"processing": true,
    "serverSide": true,
    "ajax": {
    	headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
    	url : "/activities/ActivitiesByYear",
		type: "POST",
		"data": function ( d ) {
        d.school_year = $('select#school_year').val();

        d.organization = $('select#organizationName').val();
    },
			},
	"bSort" : true,
	"bFilter" : true,
	"order": [[ 0, "desc" ]],
	"rowId" : 'id',	
	"columns" : [
		{data : 'organization'},
		{data : 'activity'},
		{data : 'date'},
		{data : 'status'},
		{data: 'action', name: 'action', orderable: false, searchable: false},
		
	],
	
});
});
$('select#school_year').change(function(e){
	// $('.activities-DT').DataTable().draw();
	$('#activities-DT').DataTable().ajax.url('/activities/ActivitiesByYear').load();
});

// $('select#organizationName').change(function(e){
// 	$('.activities-DT').DataTable().draw();
// });


$('select#organizationName').change(function(e){
	e.preventDefault();
	var sy_id = $('#school_year').val();
	var org_id = $('#organizationName').val();

	 




	

	$('#activities-DT').DataTable().ajax.url('/activities/ActivitiesByYearAndOrg').load();
// $('.activities-DT').DataTable().draw();

// /* $('.requirements-DT').DataTable().destroy();



	
	

		


});

$('select#school_year').change(function(e){
	e.preventDefault();
	var sy_id = $('#school_year').val();

	
$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			type : "POST",
			url : "/activities/OrganizationByYear",
			data : 
			{
				school_year : sy_id,
			},

	
}).done(function(data) {

	$('#organizationName').find('option').remove();
$('#organizationName')
         .append($("<option selected='' disabled=''></option>")
                    .attr("value", '0')
                    .text('Select Organization'));
         $.each(data.response, function(key, value){
				// $('#violation_selection').val(data.violations[key].name);
			   $('#organizationName').append($("<option></option>").attr("value",value.organization).text(value.organization));
		});



	
	

			});


});





   $('#table-content tbody').on('click','button', function(e)
        {
        	e.preventDefault();
        	alert("Test");
                });





	$('button#update_proposalBtn').click(function(e) {

		e.preventDefault();

		$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			type : "POST",
			url : "/postUpdateActivity",
			data : $('form#UpdateActvity').serialize(),

		}).done(function(data) {

			var msg = "";
			if (data.success == false) {
				$.each(data.errors, function(k, v) {
					msg = msg + v + "\n";
					swal("Oops...", msg, "warning");

				});

			} else {

				$('#activities_modal').modal('hide');
				swal({   
			 	title: "Success!",  
			 	 text: "Proposal Updated",   
			 	 timer: 2000, 
			 	 type: "success",  
			 	 showConfirmButton: false 
			 	});
				// activities_table.ajax.reload();
			$('#activities-DT').DataTable().ajax.url('/activities/ActivitiesByYear').load();

	

			}
		});

	});



	$('button#lost_and_found_cancelBtn').click(function() {
		$('form#AddActvity').each(function() {
			this.reset();
		});
	}); 







	//Get item details to Modal
	$('#activities-DT').on('click', 'tr', function(){
		var tr_id = $(this).attr('id');
		
		$('form#UpdateActvity')[0].reset();
				$.ajax({
	headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
	url: "/activities/activity_details",
	type: "GET",
	data: {
		id : tr_id
	},
}).done(function(data){

	var msg = "";
			if (data.success == false) {
				$.each(data.errors, function(k, v) {
					msg = msg + v + "\n";
					swal("Oops...", msg, "warning");

				});

			} else {

				if (data.response == null)
				{
					return false;
				}
				else{
				var update_id = data.response['id'];	
				var organization = data.response['organization'];
				var title = data.response['activity'];
				var date = data.response['date'];
				var status = data.response['status'];

				$('#update_id').val(update_id);
				if (status ==0){
				$('#status1').prop("checked", true);
				console.log('HI');
				} else {
				console.log('HI123');
				$('#status').prop("checked", true);
				}


				$('#organization').val(organization);
				$('#title').val(title);
				$('#date').val(date);
				

				$('#activities_modal').modal('show');
				
			}
			}

});
	});
</script>	

@endsection

