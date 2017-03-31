
$(document).ready(function(){

	$('#locker_reports_range .input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		format: 'yyyy-mm-dd',
	});


	$('select#status_sort').change(function(e){

		$('#report_type').val("List of "+$('select#status_sort').val() + " Lockers");

	});

	$('select#location_sort').change(function(e){


		$('#report_type').val("List of "+$('select#status_sort').val() + " Lockers at "  +$(":selected",this).text() );

	});


	var lockers_table1 = $('#lockers1-DT').DataTable({
		"processing": true,
		"serverSide": true,
		"bPaginate" : false,
		"bInfo" :false,
		"bSort" : false,
		"bFilter" : false,


		"ajax": {
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			url : "/lockers/all",
			type: "POST",
			data: function (d) {
				d.status_sort = $('#status_sort').val(),
				d.location_sort = $('#location_sort').val();
			},
		}, 


		"rowId" : 'locker_no',	
		"columns" : [

		{data : 'locker_no'},
		{data : 'floor'},
		{data : 'building'},
		/*{data : 'lessee_name'},*/
		{data : 'status'},		  


		],

	});
 function getSY()
 {
 	var date = new Date();
var options = {year: "numeric", month: "long", day: "numeric"};
var newdate = date.toLocaleDateString('en-US', options);
$('#date').val(newdate);
$('#schoolyear').val("S.Y. " + $('#school_year').val());
 }



	$('#status_sort').change(function(){
		lockers_table1.ajax.reload();
		getSY();
	});


	$('#location_sort').change(function(){
		lockers_table1.ajax.reload();
		getSY();
	});


	$('#show_locker_reports').click(function(e){

		if ($('#locker_reports_from').val() != ""  || $('#locker_reports_to').val() != ""){
			
			$('#report_from').val("From: " + $('#locker_reports_from').val());
			$('#report_to').val("To: " + $('#locker_reports_to').val());
		}


	});


});

