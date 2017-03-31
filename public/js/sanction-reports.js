

$(document).ready(function(){


	


});


	function getStudentReports(){
		var sanctions_table = $('#sanctions-DT1').DataTable({
			"bPaginate" : false,
			"bInfo" :false,
			"bFilter" : false,
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
					d.v_reports_offense_level = $('#v_reports_offense_level').val();
					console.log(v_reports_offense_level);
				}
			},

			"bSort" : false,
			"bFilter" : false,
			"bDestroy": true,

			"rowId" : 'rv_id',  
			"columns" : [

			{data : 'date_reported'},
			{data : 'student_information'},
			{data : 'rv_id'},	
			{data : 'description'},
			{data : 'offense_level'},
			{data : 'offense_no'},
			{data : 'sanction'},
			{data : 'status'},

			],
		});
	}





  //Sanction


$('#sanction_find_student').on('click', function(e) {
	getStudentReports();
});

/*

  $('#sanction_find_student').on('click', function(e) {

  	var stud_no = $('#sanction_student_no ').val();
  	getStudentReports();

  	$.ajax({
  		url : '/report-violation/search/student',
  		type : 'GET',
  		data : {
  			term : stud_no
  		},
  	}).done(function(data){


  		var f_name = data[0].f_name;
  		var l_name = data[0].l_name;
  		var year_level = data[0].year_level;
  		var course = data[0].course;
  		var guardian_name = data[0].guardian_name;
  		var guardian_contact_no = data[0].guardian_contact_no;


  		$('#report_from').val("Name: "+f_name + " " + l_name).attr("readonly",true);
  		$('#report_to').val(course).attr("readonly",true);
  		$('#report_type').val("List of Offenses ");

  	});
    // $('#report_from').val("Student Number: " + $('#sanction_student_no').val());
    e.preventDefault();
});*/













  $('#v_reports_offense_level').change(function (e){
  	e.preventDefault();
});


/*
$('#v_reports_offense_level').change(function(e){
	e.preventDefault();
getReports();
})*/


function getReports(){
	$('.violation-reports-reports-DT').DataTable().destroy();
	var v_reports_table = $('.violation-reports-reports-DT').DataTable({

		"bPaginate" : false,
		"bInfo" :false,
		"bSort" : false,
		"bFilter" : false,
		"processing": true,
		"serverSide": true,
		"ajax": {
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			url : "/violation-reports/reports",
			type: "POST",
			data: function (d) {
				d.v_reports_from = $('#v_reports_from').val();
				d.v_reports_to = $('#v_reports_to').val();
				d.v_reports_offense_level = $('#v_reports_offense_level').val();
				d.v_reports_college = $('#college').val();
				d.v_reports_course = $('#course').val();
				d.school_year = $('#school_year').val();

			},


		},
		"columns" : [

		{data:"first_name",
		"className":"left",
		"render":function(data, type, full, meta){
			return full.first_name + " " + full.last_name;
		}
	},
// {data : 'first_name',},

{data : 'course'},
// {data : 'complainant'},
{data : 'date_reported'},
{data : 'name'},
{data : 'offense_no'},
{data : 'description'},

],


});

}

$('#v_reports_range .input-daterange').datepicker({
	keyboardNavigation: false,
	forceParse: false,
	autoclose: true,
	format: 'yyyy-mm-dd',
});



