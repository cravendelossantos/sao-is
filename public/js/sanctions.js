

$(document).ready(function(){
	$('#all_suspension_dates').datepick({

		multiSelect: 30,
		monthsToShow: 1,
		showTrigger: '#calImg',
		dateFormat: 'yyyy-mm-dd'
	});


	$('.time_in').clockpicker({

		twelvehour: true

	});

	$('.time_out').clockpicker({

		twelvehour: true
	});



	$('#time_log .input-group.date').datepicker({
		todayBtn : "linked",
		keyboardNavigation : false,
		forceParse : false,
		calendarWeeks : true,
		autoclose : true,
		format : 'yyyy-mm-dd'
	});


//Sanctions table

var sanctions_table = $('#sanctions-DT').DataTable({
	"bPaginate" : false,
	"bInfo" :false,
	"bFilter" : true,
	"processing": true,
	"serverSide": true,
	"ajax": {
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val(),
		},
		url : "/sanctions/search/student",
		type: 'POST',
		data: function (d) {
			d.sanction_student_no = $('input[name=sanction_student_no]').val();
		}
	},

	"bSort" : true,
	"bFilter" : false,

	"rowId" : 'rv_id',
	"columns" : [

	{data : 'date_reported'},
	{data : 'student_id'},
	{data : 'student_name'},
	{data : 'rv_id'},
	{data : 'description'},
	{data : 'offense_level'},
	{data : 'offense_no'},
	{data : 'sanction'},
	{data : 'status'},

	],
});



//Suspensions table

var suspensions_table = $('.suspensions-DT').DataTable({
	"bPaginate" : false,
	"bInfo" :false,
	"bFilter" : true,
	"processing": true,
	"serverSide": true,
	"ajax": {
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val(),
		},
		url : "/sanctions/suspended_students",
		type: 'POST',
		data: function (d) {
			d.suspensions_student_no = $('input[name=suspensions_student_no]').val();
		}
	},

	"bSort" : true,
	"bFilter" : false,

	"rowId" : 'id',
	"columns" : [

	{data : 'student_id'},
	{data : 'first_name'},
	{data : 'last_name'},
	{data : 'status'},

	],
});


//CS table

var CS_table = $('#CS-DT').DataTable({
	"bPaginate" : false,
	"bInfo" :false,
	"bFilter" : true,
	"processing": true,
	"serverSide": true,
	"ajax": {
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val(),
		},
		url : "/community-service/search/student",
		type: 'POST',
		data: function (d) {
			d.cs_student_no = $('input[name=cs_student_no]').val();
		}
	},

	"bSort" : true,
	"bFilter" : false,
	/*	"order": [[ 0, "desc" ]],*/
	"rowId" : 'id',
	"columns" : [

	{data : 'student_id'},
	{data : 'violation_id'},
	{data : 'no_of_days'},
	{data : 'required_hours'},
	{data : 'status'},

	],
});

//Exclusions table
var exclusions_table = $('.exclusion-DT').DataTable({
	"bPaginate" : false,
	"bInfo" :false,
	"bFilter" : true,
	"processing": true,
	"serverSide": true,
	"ajax": {
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val(),
		},
		url : "/sanctions/excluded_students",
		type: 'POST',
		data: function (d) {
			d.suspensions_student_no = $('input[name=suspensions_student_no]').val();
		}
	},

	"bSort" : true,
	"bFilter" : false,

	"rowId" : 'id',
	"columns" : [

	{data : 'student_id'},
	{data : 'first_name'},
	{data : 'last_name'},
	{data : 'current_status'},

	],
});

});


//Sanctions functions



$('#sanction_find_student').on('click', function(e) {
	sanctions_table.draw();
	e.preventDefault();
});

$('#sanctions-DT').on('click', 'tr', function(){
	var tr_id = $(this).attr('id');

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url: "/sanctions/violation-details",
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

			else if (data.response.sanction.indexOf('suspension') != -1 || data.response.sanction.indexOf('exclusion') != -1)
			{
				$('#suspension_modal').modal('show');

				var violation_id = data.response.rv_id;
				var student_no = data.response.student_id;

				$('#suspension_student_no').val(student_no);
				$('#suspension_violation_id').val(violation_id);
				$('#_suspension_student_no').val(student_no);
				suspensions_table.ajax.reload();
			}

			else if (data.response.sanction.indexOf('Community') != -1)
			{
				var violation_id = data.response.rv_id;
				var student_no = data.response.student_id;

				$('#cs_modal').modal('show');
				$('#cs_modal_student_no').val(student_no);
				$('#cs_modal_student_id').val(student_no);
				$('#cs_violation_id').val(violation_id);
				CS_table.ajax.reload();
			}
			else{
				if (data.response['status'] == "Completed")
				{
					return false;
				}

				else{
					$('#sanction_modal').modal('show');

					var violation_id = data.response.rv_id;
					var student_no = data.response.student_id;

					$('#sanction_violation_id').val(violation_id);
					$('#m_student_no').val(student_no);
					$('#_time_log_student_no').val(student_no);
					sanctions_table.ajax.reload();
				}
			}
		}

	});
});

$('#sanction_update_btn').click(function(e){
	e.preventDefault();

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url:'/sanctions/update-status',
		type: 'GET',
		data: $('form#violation_status_update').serialize(),
	}).fail(function(data){

		var errors = $.parseJSON(data.responseText);
		var msg="";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");

		});
	}).done(function(data){

		swal({
			title: "Are you sure?",
			text: "This will update the status of the selected violation",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Submit",
			closeOnConfirm: true
		}, function(){

			$('#sanction_modal').modal('hide');

			$.ajax({
				headers : {
					'X-CSRF-Token' : $('input[name="_token"]').val()
				},
				url:'/sanctions/update-status',
				type: 'POST',
				data: $('form#violation_status_update').serialize(),
			}).done(function(data){
				swal({
					title: "Success!",
					text: "Violation status updated!",
					timer: 1000,
					type: "success",
					showConfirmButton: false

				});

			});

			sanctions_table.ajax.reload();
		});

	});
});



//Suspension functions


$('#suspension_update_btn').click(function(e){
	e.preventDefault();

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url:'/sanctions/suspended_students/update',
		type: 'GET',
		data: $('form#suspension_update_status').serialize(),
	}).fail(function(data){

		var errors = $.parseJSON(data.responseText);
		var msg="";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");

		});
	}).done(function(data){

		swal({
			title: "Are you sure?",
			text: "This will update the status of the selected suspension",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Submit",
			closeOnConfirm: true
		}, function(){

			$('#suspension_update_modal').modal('hide');

			$.ajax({
				headers : {
					'X-CSRF-Token' : $('input[name="_token"]').val()
				},
				url:'/sanctions/suspended_students/update',
				type: 'POST',
				data: $('form#suspension_update_status').serialize(),
			}).done(function(data){
				swal({
					title: "Success!",
					text: "Suspension status updated!",
					timer: 1000,
					type: "success",
					showConfirmButton: false

				});

			});

			suspensions_table.ajax.reload();
		});

	});
});



$('#suspensions_student_find').on('click', function(e) {

	suspensions_table.draw();
	e.preventDefault();
});

$('.suspensions-DT').on('click', 'tr', function(){
	var tr_id = $(this).attr('id');

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url: "/suspension-exclusions/details",
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
				if (data.response['current_status'] == "Excluded")
				{
					return false;
				}

				else{

//$('#suspension_update_modal').modal('show');

$('#suspension_log_student_no').val(data.response.student_id);
$('#_suspension_log_student_no').val(data.response.student_id);
$('#suspension_log_student_name').val(data.response.first_name + " " + data.response.last_name);
$('#suspension_log_violation_id').val(data.response.violation_id);
$('#_suspension_log_violation_id').val(data.response.violation_id);
$('#suspension_log_suspension_id').val(data.response.id);
$('#_suspension_log_suspension_id').val(data.response.id);
$('#suspension_log_required_days').val(data.response.suspension_days);
$('#suspension_log_status').val(data.response.status);

}
}
}

});
});

$('#suspension_btn').click(function(e){
	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url: "/sanctions/suspend",
		type: "GET",
		data: $('form#add_suspension').serialize(),
	}).fail(function(data) {

		var errors = $.parseJSON(data.responseText);
		var msg="";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");

		});

	}).done(function(data) {

		swal({
			title: "Are you sure?",
			text: "The record will be added to Suspensions/Exclusions records",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Submit",
			closeOnConfirm: true
		}, function(){
			$.ajax({
				headers : {
					'X-CSRF-Token' : $('input[name="_token"]').val()
				},
				url: "/sanctions/suspend",
				type: "POST",
				data: $('form#add_suspension').serialize(),

			}).done(function(data){
				swal({
					title: "Success!",
					text: "Record saved",
					timer: 1000,
					type: "success",
					showConfirmButton: false

				});
				$('form#add_suspension').each(function() {
					this.reset();
				});
				$('#suspension_modal').modal('hide');
				suspensions_table.ajax.reload();
			});

		});
	});

});

$('#suspension_days').hide();

$("input[name='suspension_exclusion']").change(function(e){
	if ($(this).val() == 'Suspend'){
		$('#suspension_days').show();
	} else if ($(this).val() == 'Exclude') {

		$('#suspension_days').hide();
	}
});




$('#suspension_log_btn').click(function(e){
	e.preventDefault();
	$.ajax({
		type : "GET",
		url : "/sanctions/suspended_students/update",
		data : $('form#suspension_log').serialize(),

	}).fail(function(data){
		var errors = $.parseJSON(data.responseText);
		var msg="";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");

		});

	}).done(function(data) {

		swal({
			title: "Are you sure?",
			text: "Addition of new log cannot be undone",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Submit",
			closeOnConfirm: true
		}, function(){
			$.ajax({
				headers : {
					'X-CSRF-Token' : $('input[name="_token"]').val()
				},
				type : "POST",
				url : "/sanctions/suspended_students/update",
				data : $('form#suspension_log').serialize(),
			}).done(function(data){
				swal({
					title: "Success!",
					text: "Suspension log successfully updated!",
					timer: 1000,
					type: "success",
					showConfirmButton: false

				});
				$('form#suspension_log').each(function() {
					this.reset();

				});
				suspensions_table.ajax.reaload();

				$('#_time_log_cs_id').val('');
				CS_table.ajax.reload();

			});
		});
	});

});

//CS functions

	$('#new_log').on('click', function(e){
		e.preventDefault();

		$.ajax({
			url : '/community-service/new_log',
			type: 'GET',
			data: $('#new_log_form').serialize(),

		}).fail(function(data){
			var errors = $.parseJSON(data.responseText);
			var msg="";

			$.each(errors.errors, function(k, v) {
				msg = msg + v + "\n";
				swal("Oops...", msg, "warning");

			});

		}).done(function(data){

		});
	});


function CSdaysToHours()
{
	var days = parseInt($('#cs_days').val());
	var hours = (days * 8);

	$('#cs_hours').val(hours);

}

$('#cs_days').on('input', function (){
	CSdaysToHours();
});

$('#add_to_cs_btn').click(function (e){
	e.preventDefault();

	$.ajax({
		url	: '/sanctions/add-to-cs',
		type: 'GET',
		data: $('form#add_to_cs').serialize(),

	}).fail(function (data) {

		var errors = $.parseJSON(data.responseText);
		var msg="";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");

		});

	}).done(function (data) {
		console.log($('#cs_violation_id').val());

		swal({
			title: "Are you sure?",
			text: "This will action will add this student to community service",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Submit",
			closeOnConfirm: true
		}, function(){

			$.ajax({
				headers : {
					'X-CSRF-Token' : $('input[name="_token"]').val()
				},

				url	: '/sanctions/add-to-cs',
				type : 'POST',
				data: $('form#add_to_cs').serialize(),

			}).done(function(data){

				$('form#add_to_cs')[0].reset();

				$('#cs_modal').modal('hide');
				swal({
					title: "Success!",
					text: "Student added to Community Service",
					timer: 1000,
					type: "success",
					showConfirmButton: false

				});
				CS_table.ajax.reload();
			});

		});

	});
});



$('#CS-DT').on('click', 'tr', function(){
	var tr_id = $(this).attr('id');

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url: "/community-service/cs-details",
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

		} else if (data.response == null || data.response['status'] == "Completed"){
			return false;
		} else {


			var cs_id = data.response.id;
			var violation_id = data.response.violation_id;
			var student_no = data.response.student_id;
			var student_name = data.response.first_name + " " +  data.response.last_name;
			var required_hours = data.response.required_hours;

			$('#_time_log_violation_id').val(violation_id);
			$('#time_log_violation_id').val(violation_id);
			$('#_time_log_cs_id').val(cs_id);
			$('#time_log_cs_id').val(cs_id)
			$('#time_log_student_name').val(student_name);
			$('#time_log_student_no').val(student_no);
			$('#time_log_required_hours').val(required_hours);
		}


	});
});

$('#cs_find_student').on('click', function(e) {
	CS_table.draw();
	e.preventDefault();
});


$('#time_log_btn').click(function(e){
	e.preventDefault();
	$.ajax({
		type : "GET",
		url : "/community-service/new_log",
		data : $('form#time_log').serialize(),

	}).fail(function(data){
		var errors = $.parseJSON(data.responseText);
		var msg="";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");

		});

	}).done(function(data) {

		swal({
			title: "Are you sure?",
			text: "Addition of new log cannot be undone",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Submit",
			closeOnConfirm: true
		}, function(){
			$.ajax({
				headers : {
					'X-CSRF-Token' : $('input[name="_token"]').val()
				},
				type : "POST",
				url : "/community-service/new_log",
				data : $('form#time_log').serialize(),
			}).done(function(data){
				swal({
					title: "Success!",
					text: "Student time log updated!",
					timer: 1000,
					type: "success",
					showConfirmButton: false

				});
				$('form#time_log').each(function() {
					this.reset();

				});
				$('#_time_log_cs_id').val('');
				CS_table.ajax.reload();

			});
		});
	});

});