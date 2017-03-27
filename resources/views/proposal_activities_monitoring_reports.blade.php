@extends('layouts.master')

@section('title', 'SAO | List of proposal activities')

@section('header-page')

<div class="row">
	<div class="col-md-12">
		<h1>Proposal of Activitities Reports</h1>
		<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Monitoring of Proposal of Activities
        </li>
        <li class="active">
            <strong>Reports</strong>
        </li>
	</ol>
	</div>
</div>
<hr/>
<div class="row">
  <div class="col-md-12">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{ csrf_field() }}
    <div class="row">
    					<div class="col-md-3">
								<div class="form-group">

								<label>Select Organization</label>
								<select name="organizationName" id="organizationName" class="form-control">
								<option autofocus="" disabled selected value="0">Select Organization</option>
									@foreach ($organizations as $organization)
									<option>{{$organization->organization }}</option>
								
									@endforeach
									
								</select>
								

								</div>


							</div>
							<div class="col-md-3">
							<div class="form-group">
								<label>Status</label>
								<select id="sort_by" name="sort_by"  class="form-control">
									<option value="">All</option>
									<option value="1">Submitted</option>
									<option value="0">Not Submitted</option>
								</select>	
							</div>
							</div>
						<div class="col-md-3">
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

    		
 	 </div>
</div>
</div>

@endsection


@section('content')

                     <div class="ibox float-e-margins">
                        <div class="ibox-title">

                            <h5><b>Proposal of Activities</b></h5>
                           
                           
                             <button type="button" class="btn btn-primary btn-xs m-l-sm pull-right" id="print">Print</button>
                              <button id="save" class="btn btn-primary  btn-xs m-l-sm pull-right" onclick="save()" type="button">Save</button>
                              <button id="edit" class="btn btn-primary btn-xs m-l-sm pull-right" onclick="edit()" type="button">Edit</button>

                        </div>
</div>

 
<div class="click2edit">
<div class="row" id="report_content">

<div class="col-lg-12">

  

    
    <div class="ibox float-e-margins">
      <div class="ibox-content p-xl">
              <div class="row">

<!-- 
         	<div id="locator">
              <img src="/img/officialseal1.png" height="100" width="100" class="pic1">
              <img src="/img/officialseal1.png"  class="pic1">
              </div>  -->
          <div class="col-sm-12 text-center">
              <img src="/img/officialseal1.png"  class="pic1">

          </div>
        </div>
        <div class="row">
         
<br><br>
          <div class="col-sm-12 text-center">
          <h5>Student Affair's Office</h5>
            <h5>Proposal of Activities School Year Report</h5>
            <!-- <output id="report_type">Proposal of Activities Report</output>  -->


          </div>
    <br>
        </div>
         <div class="row">
         
          <div class="form-group col-xs-6 text-left">
       		
          <output id="report_from1"></output>
          </div> 
         

          <div class="form-group col-xs-6 text-right">   
            <output id="report_to1"></output>  
           </div>
          
        </div>

         <div class="row">
         
          <div class="form-group col-xs-6 text-left">
       		
          <output id="report_from"></output>
          </div> 
         

          <div class="form-group col-xs-6 text-right">   
            <output id="report_to"></output>  
           </div>
          
        </div>

         <div class="row">


            <div class="col-sm-12 text-center">
            <output id="report_type"></output>
                                        
             </div>
         </div>


        <div class="row">

          <div class="col-md-12">
            <div class="table-responsive">

<br>
<table class="table table-striped table-bordered table-hover activities-DT dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid" style="width: 100%;" >

							<thead>
						
									<th>Organization</th>
									<th>Title of Activity</th>
									<th>Date</th>
									<th>Status</th>
									
						
							</thead>
							
						
						</table>
        </div>
        </div>

<br><br>
       	 <div class="row" style="bottom: -10; margin-left: 10px;">

       <label class="text-center" >Prepared by:</label><br><br> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br> {{ Auth::user()->roles->first()->name }} , Student Affairs Office
          </div>
                <br>
              <div class="row"   style="bottom: -10; margin-left: 10px;">
       <label class="text-center">Noted by:</label><br><br> Ms. Lourdes C. Reyes <br>Head, Student Affairs Office 
                </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>




<script>


$(document).ready(function(){

	var date = new Date();
	var options = {year: "numeric", month: "long", day: "numeric"};
      var newdate = date.toLocaleDateString('en-US', options);
// $('#report_from1').val("Report Type: Yearly");
$('#report_type').val("List of proposed activities");
$('#report_to1').val(newdate);
$('#report_to').val("S.Y." + $('#school_year').val());


// var sy_id = $('#school_year').val();
// var org_id = $('#organizationName').val();

//
var activities_table = $('.activities-DT').DataTable({
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
        d.sort_by = $('select#sort_by').val();
    },
			},
	"bPaginate" : false,
	"bSort" : false,
	"bFilter" : false,

	"bInfo" :false,
	"order": [[ 0, "desc" ]],
	"rowId" : 'id',	
	"columns" : [
		{data : 'organization'},
		{data : 'activity'},
		{data : 'date'},
		{data : 'status'},
/*		{"data": null ,"defaultContent":"<button>View</button>"},*/
		
	],
	"columnDefs":[{
		"targets":3, 
		"render":function(data,type,full,meta){
			console.log("data = " +data);
			if(data == 0){
				return '<p> Not Submitted </p>';
			} else{
				return '<p> Submitted </p>';
			}
		},
}],
});
});


$('select#school_year').change(function(e){

	// $('.activities-DT').DataTable().draw();
	$('.activities-DT').DataTable().ajax.url('/activities/ActivitiesByYear').load();
	$('#report_to').val("S.Y." + $('#school_year').val());
	$('#report_from1').val("");

});

$('select#sort_by').change(function(e){

		if($('#sort_by').val() == 1)
	{
		$('#report_from').val("Status: Complete").val();
	}
	else if ($('#sort_by').val() == 0)
	{
		$('#report_from').val("Status: Incomplete").val();
	}

	// $('.activities-DT').DataTable().draw();
	$('.activities-DT').DataTable().ajax.url('/activities/ActivitiesByYearAndOrgAndStatus').load();
	

});


// $('select#organizationName').change(function(e){
// 	$('.activities-DT').DataTable().draw();
// });


$('select#organizationName').change(function(e){
	e.preventDefault();
	var sy_id = $('#school_year').val();
	var org_id = $('#organizationName').val();

$('#report_from1').val("Organization: " + $('#organizationName').val());




	

	$('.activities-DT').DataTable().ajax.url('/activities/ActivitiesByYearAndOrg').load();
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
				activities_table.ajax.reload();
			
	

			}
		});

	});



	$('button#lost_and_found_cancelBtn').click(function() {
		$('form#AddActvity').each(function() {
			this.reset();
		});
	}); 







	//Get item details to Modal
	$('.activities-DT').on('click', 'tr', function(){
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

	$('#print').click(function(e){
$(this).hide();
var content = document.getElementById('report_content').innerHTML;
document.body.innerHTML = content;

window.print();
// window.location.reload();


e.preventDefault();
});







</script>	


     <script src="js/inspinia.js"></script>

    <!-- SUMMERNOTE -->
    <script src="js/plugins/summernote/summernote.min.js"></script>
     <script>
        $(document).ready(function(){

            $('.summernote').summernote();


       });
        var edit = function() {
            $('.click2edit').summernote({focus: true});

        };
        var save = function() {
            var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
            $('.click2edit').destroy();
        };
    </script>

    <style type = "text/css">


/*.pic1{
float:left;
	margin-left:50px; 
	position: absolute;

		top: 250px;
		left: 70px;
}*/

/*#locator { position: absolute; visibility: visible; left: 450px; top: 10px; height: 100px; width: 150px; z-index: 200; float: right;}
*/
.note-codable {
display:none;
}
.note-help {
display:none;
}
.note-insert {
display:none;
}
.note-view {
display:none;
}


.note-toolbar {
    /*background-color: white;*/
/*position: absolute;
    bottom: 330px;
    right: 200px;*/
/*padding-left: 30px;*/
padding-bottom: 30px;
/*border-bottom:1px solid #a9a9a9*/
}








</style>

@endsection

