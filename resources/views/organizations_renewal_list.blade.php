@extends('layouts.master')

@section('title', 'SAO | List of Organizations')

@section('header-page')
<div class="row">
	<div class="col-md-12">
		<h1>List of Organizations</h1>
		<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Organizations Renewal Management
        </li>
        <li class="active">
            <strong>List of Organizations</strong>
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
				<h5>List of Organizations</h5>
			</div>

			<div class="ibox-content">
				<form role="form" id="AddRequirement" method="POST" action="/organizationsRenewal/add">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="update_id" id="update_id">

					<div class="row">


						<div class="col-md-4">
							<div class="form-group">

								<label>Status</label>
								<select id="sort_by" name="sort_by"  class="form-control">
									<option>All</option>
									<option>Submitted All Requirements</option>
									<option>Not Submitted All Requirements</option>
								</select>
							</div>
						</div>




						<div class="col-md-2">
							<div class="form-group">

								<label>School Year</label>
								<select name="school_year" id="school_year" class="form-control">
									@foreach ($schoolyear as $schoolyear)
									<option>{{$schoolyear->school_year }}</option>
									@endforeach

									@foreach ($schoolyears as $schoolyear)
									<option>{{$schoolyear->school_year }}</option>
									@endforeach
									
								</select>	
							</div>
						</div>






						<div class="ibox-content" id="table-content">
							<div class="table-responsive">
								<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

									<table class="table table-striped table-bordered table-hover requirements-DT dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid" style="font-size: 10.2px;width: 100%;"  >  

										<thead>
											<th>Student Organization</th>
											<th>Constitution</th>
											<th>Officers</th>
											<th>Grades of elected Officers</th>
											<th>Proposed Activities</th>
											<th>Annual Report</th>
											<th>Audited Financial Report</th>
											<th>Recommendation of Adviser</th>
											<th>Photocopy of EAF of each officer  for the preceding semester</th>
											<th>Updated list of members</th>
											<th>Activity Documentation</th>
											<th>Remarks</th>

											<!-- <th>Action</th> -->

										</thead>

<!-- 							  <tr>
   									 <td name="organization" id="organization"><center></center></td>
  								     <td><center><input type="checkbox" class="i-checks" name="requirement1" id="requirement1"></center></td>
   									 <td><center><input type="checkbox" class="i-checks" name="requirement2" id="requirement2"></center></td>
   									 <td><center><input type="checkbox" class="i-checks" name="requirement3" id="requirement3"></center></td>
  								     <td><center><input type="checkbox" class="i-checks" name="requirement4" id="requirement4"></center></td>
   									 <td><center><input type="checkbox" class="i-checks" name="requirement5" id="requirement5"></center></td>
   									 <td><center><input type="checkbox" class="i-checks" name="requirement6" id="requirement6"></center></td>
  								     <td><center><input type="checkbox" class="i-checks" name="requirement7" id="requirement7"></center></td>
   									 <td><center><input type="checkbox" class="i-checks" name="requirement8" id="requirement8"></center></td>
  								     <td><center><input type="checkbox" class="i-checks" name="requirement9" id="requirement9"></center></td>
   									 <td><center><input type="checkbox" class="i-checks" name="requirement10" id="requirement10"></center></td>
   									 <td><center><input type="checkbox" class="i-checks" name="requirement11" id="requirement11"></center></td>


   									</tr> -->


   								</table>

   							</div>
   						</div>
   					</div>




   				</div>


   			</div>



   		</div>
   	</div>

   </div>

   <script>



   	$(document).ready(function(){

   		var sy_id = $('#school_year').val();


   		var requirements_renewal_table = $('.requirements-DT').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				headers : {
   					'X-CSRF-Token' : $('input[name="_token"]').val()
   				},
   				url : "/organizationsRenewal/requirements/ByYear",
   				type: "POST",
   				"data": function ( d ) {
   					d.school_year = $('select#school_year').val();
   					d.sort_by = $('select#sort_by').val();
   				},

   			},
   			"bSort" : true,
   			"bFilter" : true,
   			"order": [[ 0, "desc" ]],
   			"rowId" : 'id',	
   			"columns" : [
   			{data : 'organization', name: 'organization'},
   			{data : 'requirement1', name : 'requirement1'},
   			{data : 'requirement2', name : 'requirement2'},
   			{data : 'requirement3', name : 'requirement3'},
   			{data : 'requirement4', name : 'requirement4'},
   			{data : 'requirement5', name : 'requirement5'},
   			{data : 'requirement6', name : 'requirement6'},
   			{data : 'requirement7', name : 'requirement7'},
   			{data : 'requirement8', name : 'requirement8'},
   			{data : 'requirement9', name : 'requirement9'},
   			{data : 'requirement10', name : 'requirement10'},
   			{data : 'requirement11', name : 'requirement11'},

   			],


   			"columnDefs":[{
   				"targets":[1,2,3,4,5,6,7,8,9], 
   				"render":function(data,type,full,meta){
   					console.log("data = " +data);
   					if(data == 0){
   						return '<center><input type="checkbox" disabled="" class="i-checks" name="requirement1"></center>';
   					} else{
   						return '<center><input type="checkbox" disabled=""  class="i-checks" name="requirement1" checked=""></center>';
   					}
   				}
   			}],

   		});
   	});

   	$('select#school_year').change(function(e){
   		$('.requirements-DT').DataTable().draw();
   	});

   	$('select#sort_by').change(function(e){
	$('.requirements-DT').DataTable().ajax.url('/organizationsRenewal/requirements/ByYearAndStatus').load();
   	});

/*

$('select#school_year').change(function(e){
	e.preventDefault();
	var sy_id = $('#school_year').val();
	 $('.requirements-DT').DataTable().draw();

$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			type : "POST",
			url : "/organizationsRenewal/requirements/ByYear",
			data : 
			{
				school_year : sy_id,
			},

	
		}).done(function(data) {*/


/* $('.requirements-DT').DataTable().destroy();
$('.requirements-DT').DataTable().ajax.url('/organizationsRenewal/requirements/ByYear').load();	*/

/* alert('asdsa');	
requirements_renewal_table.draw();
 



	
	

			});


});



*/

$('button#add_requirementBtn').click(function(e) {

	e.preventDefault();

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		type : "POST",
		url : "/organizationsRenewal/add",
		data : $('form#AddRequirement').serialize(),

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
			requirements_renewal_table.ajax.reload();



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
		data : $('form#AddRequirement').serialize(),

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


			swal('Success!', 'Updated Requirements', 'success');
			requirements_renewal_table.ajax.reload();



		}
	});

});

// 			$('button#search_organizationBtn').click(function(e) {

// 				var organization1 = $('#organizationName').val();
// alert(organization1);
// 		e.preventDefault();

// 		$.ajax({
// 			headers : {
// 				'X-CSRF-Token' : $('input[name="_token"]').val()
// 			},
// 			type : "POST",
// 			url : "/organizationsRenewal/requirements/specific",
// 			data : 
// 			{
// 		organizationName : organization1;
// 	},
// 			// $('form#AddRequirement').serialize(),

// 		}).done(function(data) {

// 			var msg = "";
// 			if (data.success == false) {
// 				$.each(data.errors, function(k, v) {
// 					msg = msg + v + "\n";
// 					swal("Oops...", msg, "warning");

// 				});

// 			} else if (data.success == true) {


// 				requirements_renewal_table.ajax.url('/organizationsRenewal/requirements/specific').load();

// 				$('form#AddActvity').each(function() {
// 					this.reset();
// 				});

// 				// requirements_renewal_table.ajax.reload();		
// 				// requirements_renewal_table.ajax.url('/organizationsRenewal/requirements/specific').load();

// 				swal('Success!', 'Added New Requirement List', 'success');




// 				var update_id = data.response['id'];	
// 				var organization = data.response['organization'];
// 				var requirement1 = data.response['requirement1'];
// 				var requirement2 = data.response['requirement2'];
// 				var requirement3 = data.response['requirement3'];
// 				var requirement4 = data.response['requirement4'];
// 				var requirement5 = data.response['requirement5'];
// 				var requirement6 = data.response['requirement6'];
// 				var requirement7 = data.response['requirement7'];
// 				var requirement8 = data.response['requirement8'];
// 				var requirement9 = data.response['requirement9'];
// 				var requirement10 = data.response['requiremen10'];
// 				var requirement11 = data.response['requirement11'];



// 				$('#organization').val(organization);
// 				if (requirement1 ==1){

// 				$('#requirement1').prop("checked", true);
// 				};
// 				if (requirement2 ==1){

// 				$('#requirement2').prop("checked", true);
// 				};
// 				if (requirement3 ==1){

// 				$('#requirement3').prop("checked", true);
// 				};
// 				if (requirement4 ==1){

// 				$('#requirement4').prop("checked", true);
// 				};

// 				if (requirement5 ==1){

// 				$('#requirement5').prop("checked", true);
// 				};

// 				if (requirement6 ==1){

// 				$('#requirement6').prop("checked", true);
// 				};

// 				if (requirement7 ==1){

// 				$('#requirement7').prop("checked", true);
// 				};

// 				if (requirement8 ==1){

// 				$('#requirement8').prop("checked", true);
// 				};
// 				if (requirement9 ==1){

// 				$('#requirement9').prop("checked", true);
// 				};

// 				if (requirement10 ==1){

// 				$('#requirement10').prop("checked", true);
// 				};

// 				if (requirement11 ==1){

// 				$('#requirement11').prop("checked", true);
// 				};













// 			}
// 		});

// 	});






</script>


@endsection

