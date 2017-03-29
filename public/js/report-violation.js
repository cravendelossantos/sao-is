

$(document).ready(function(){



	$('#violation_date_picker .input-group.date').datepicker({
		todayBtn : "linked",
		keyboardNavigation : false,
		forceParse : false,
		calendarWeeks : true,
		autoclose : true,
		format : 'yyyy-mm-dd'
	});

$('#report_btn').prop('disabled', true);

	

//Report violation
var violation_reports_table = $('#violation-reports-DT').DataTable({
	"responsive": true,
	"processing": true,
	"serverSide": true,
	"ajax": {
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		"data": function ( d ) {
			d.key = $('input[type="search"]').val();
		},
		url : "/report-violation/reports",
		type: "POST",
	},
	"bSort" : true,
	"bFilter" : true,
	"order": [[ 0, "desc" ]],
	"rowId" : 'rv_id',	
	"columns" : [
	{data : 'date_reported'},
	{data : 'rv_id'},
	{data : 'student_id'},
	{data : 'student_name'},
	//violation_name
	{data : 'name'},
	{data : 'description'},
	{data : 'offense_level'},
	{data : 'action'},
	{data : 'offense_no'},
	{data : 'sanction'},
	{data : 'complainant_details'}

	],
	
/*	dom : '<"html5buttons"B>lTgftip',

	buttons : [{
		extend : 'csv',
		title : 'Violations Reports',
	}, {
		extend :'excel',
		title : 'Violations Reports',
	} , {
		extend : 'pdf',
		title : 'Violations Reports',
	} , {
		extend : 'print',
		title : 'Violations Reports',
		customize : function(win) {
			$(win.document.body).addClass('white-bg');
			$(win.document.body).css('font-size', '8px');
			$(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
		}
	}]
*/
});	

});


$('button#report_btn').click(function(e){
	e.preventDefault();

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		type : "GET",
		url : "/report-violation/report",
		data : $('form#reportViolationForm').serialize(),

	}).fail(function(data){
				//        var errors = data.responseText;
				var errors = $.parseJSON(data.responseText);
				var msg="";
				
				$.each(errors.errors, function(k, v) {
					msg = msg + v + "\n";
					swal("Oops...", msg, "warning");

				});



			}).done(function(data){

				var msg = "";



				swal({   
					title: "Are you sure?",   
					text: "You will not be able to change or delete this record",   
					type: "warning",   
					showCancelButton: true,  
					confirmButtonColor: "#DD6B55",   
					confirmButtonText: "Save",   
					closeOnConfirm: true
				}, function(){  
					$.ajax({
						headers : {
							'X-CSRF-Token' : $('input[name="_token"]').val()
						},
						type : "POST",
						url : "/report-violation/report",
						data : $('form#reportViolationForm').serialize(),
					}).fail(function (data){

						var errors = $.parseJSON(data.responseText);
						
						swal("Oops...", errors.errors, "warning");
						
						
					}).done(function(data){

						var sent = true;
						var message = "Guardian notification sent!";

						if (data.notification[0].sent == false){
							sent = false;
							message = "Guardian notification not sent\n" + data.notification[0].response;
						} else if (data.notification[0].sent == true){
							message = data.notification[0].response;
						} else {
							message = "";
						}

						swal({   
							title: "Success!",  
							text: "Violation Reported\n\n" + message,
							type: "success",  
							showConfirmButton: true 


						});
						
						$('#v_id').val(data.response);
						$('form#reportViolationForm').each(function() {
							this.reset();
						});	
						violation_reports_table.ajax.reload();


						$('#offense_number').val("");
						$('#committed_offense_number').val("");
						$('#offense_level').val("");
						$('#student_number').val("");
						$('#complainant_id').val("");
						$('#violation_id').val("");


						$('#last_name').val("").attr("readonly",false);
						$('#first_name').val("").attr("readonly",false);

						$('#year_level').val("").attr("readonly",false);
/*$('#violation_selection').find('option').remove();
		 $('#violation_selection')
         .append($("<option selected='' disabled=''></option>")
                    .attr("value", '0')
                    .text('Select violation'));*/

                    $('#violation_date_picker .input-group.date').datepicker('setDate', null);
                    $('#report_btn').prop('disabled', true);
                    // $('#offense_level').prop('disabled', true);
                });
				});
			});
		});



//find student

$('#find_student').on('click', function(e){
	e.preventDefault();


	var stud_no = $('#student_no').val();

			//checks if textbox has input
			if (stud_no.length <= 0){

				$('#student_number').val("");
				$('#last_name').val("").attr("readonly",false);
				$('#first_name').val("").attr("readonly",false);
				$('#year_level').val("").attr("readonly",false);
				$('#report_btn').prop('disabled', true);
				$('#violation_description').val("");
				$('#violation_sanction').val("");
				$('#violation_offense_level').val("");	

			} else {		
				$.ajax({
					url : '/report-violation/search/student',
					type : 'GET',
					data : {
						term : stud_no 
					},
				}).done(function(data) {

					//checks if data reponse has value
					if (data.length == 0)
					{
						x();
						$('#violation_selection').val("");
						$('#violation_description').val("");
						$('#violation_sanction').val("");
						$('#violation_offense_level').val("");	
						$('#new').show();
						$('#student_number_error').html("Student not found");
						$('#offense_number').val("").attr("readonly",false);
						$('#committed_offense_number').val("");
						$('#guardian_name').val("");
						$('#guardian_contact_no').val("");
						$('#student_number').val("");
						$('#violation_id').val("").attr("readonly",false);

						$('#student_name').val("").attr("readonly",false);
						$('#year_level').val("").attr("readonly",false);
						// $('#offense_level').prop('disabled',true);
					}
					else if(data[0].current_status == 'Excluded'){
						$('#report_btn').prop('disabled', true);
						//$('#offense_level').prop('disabled', true);
						$('form#reportViolationForm').each(function() {
							this.reset();
						});	
						swal("Oops...", "This student is Excluded", "error");
					}
					else{
						x();
						$('#new').hide();
						$('#student_number_error').html("");
						var value = data[0].value;
						var f_name = data[0].f_name;
						var l_name = data[0].l_name;
						var year_level = data[0].year_level;
						var course = data[0].course;
						var guardian_name = data[0].guardian_name;
						var guardian_contact_no = data[0].guardian_contact_no;

						$('#student_number').val(value);

						$('#student_name').val(f_name + " " + l_name).attr("readonly",true);
				//$('#course').val(ui.item.course);
				$('#year_level').val(year_level + "/" + course).attr("readonly",true);
				$('#guardian_contact_no').val(guardian_contact_no).attr("readonly",true);
				$('#guardian_name').val(guardian_name).attr("readonly",true);
				//countOffense();
				//$('#offense_level').prop('disabled',false);
			}

		});
				


				$('#report_btn').prop('disabled', false);
			}

		});


//New student




$('#new').click(function(){
//load a modal and add record and put into inputs
var student_no = $('#student_no').val();
$('#studentNo').val(student_no);

$('#student_no').val("");
});



$('#new_student_btn').click(function(e){
	e.preventDefault();
	
	$.ajax({
		url : '/report-violation/add-student',
		type: 'POST',
		data: $('form#newStudentForm').serialize(),
	}).done(function(data){
		var msg = "";
		if (data.success == false) {
			$.each(data.errors, function(k, v) {
				msg = msg + v + "\n";
				swal("Oops...", msg, "warning");

			});

		} else {
			x();
			swal({   
				title: "Success!",  
				text: "Student Added",   
				timer: 3000, 
				type: "success",  
				showConfirmButton: false 
			});

			$('form#newStudentForm').each(function() {
				this.reset();
			});	


			$('#myModal').modal('toggle');
			$('#new').hide();
			$('#student_number_error').html("");
		}
	});

	var student_no = $('#studentNo').val();
	var first_name = $('#firstName').val();
	var last_name = $('#lastName').val();
	var year_level = $('#yearLevel').val();
	var course = $('#course').val();
	var contact = $('#contactNo').val();

	$('#student_number').val(student_no);
	$('#student_no').val(student_no);
/*	$('#student_name').val(first_name + " " + last_name);
	$('#year_level').val(year_level + " / " + course);
	$('#contact').val(contact);*/

	$('#find_student').trigger('click',function(e){
		e.preventDefault();
	});	


	//ajax
});


//Violation Selection



$('#violation_selection').on('change select', function(e) {
	e.preventDefault();



	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : '/report-violation/search/violation',
		type : 'GET',
		data : {
			violation : $('#violation_selection').val()
		},
	}).done(function(data) {
		console.log($('#violation_selection').val());
		x();
		var violation_id = data.response['id'];
		var violation_offense_level = data.response['offense_level'];
		var violation_description = data.response['description'];
			//var violation_sanction = data.response['sanction'];
			var offense_level = data.response['offense_level'];


			if (data == null) {
				alert('Not Found');
			} else {

				$('#violation_id').val(violation_id);
				$('#violation_offense_level').val(violation_offense_level);
				$('#violation_description').val(violation_description);
				$('#offense_level').val(offense_level);

				//$('#violation_sanction').val(violation_sanction);
				//$('#violation_details').show();
				countOffense();

			}



		});

});


//Other functions


function countOffense()
{
	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : '/report-violation/offense-no',
		type: 'POST',
		data : $('form#reportViolationForm').serialize(),
	}).done(function(data){

		var sanction = data.sanction['sanction'];	
		var offense_no = data.offense_no;
		var diff_offense_no = data.diff_type_offense;

				// if (offense_no != null)	{
				// 	offense_no += 1;

				var current_offense_no = parseInt(offense_no);
				var current_diff_offense_no = parseInt(diff_offense_no);
				var total_serious_offense_no = data.total_serious_offense_no;


				if (offense_no == 3 && diff_offense_no == 2 && $('#offense_level').val() == 'Less Serious')
				{

						//Warning if same and diff type will elevate
						swal("Warning!", 'This will be the third commission of student with student number ' + $('#student_number').val() + ' of ' + (current_offense_no) +' same type of ' +  $('#offense_level').val()  + 
							'\n\n .This student also committed ' + (current_diff_offense_no) +' different types of ' +  $('#offense_level').val() ,  "warning");

					}
					else if (offense_no == 3 && $('#offense_level').val() == 'Less Serious')
					{
						swal("Warning!", 'This will be the third commission of student with student number ' + $('#student_number').val() + ' of ' + (current_offense_no) +' same type of ' +  $('#offense_level').val() + ' offense level' ,  "warning");
					}


					//checks if diff types = 2 and if the selected violation is same type
					else if (diff_offense_no == 2 && offense_no <= 1 && $('#offense_level').val() == 'Less Serious')
					{
						swal("Warning!", 'The student with student number ' + $('#student_number').val() + ' committed ' + (diff_offense_no) + ' different type of ' +  $('#offense_level').val() + '. This will be the third commision of different types of Less Serious offense and will elevate to Serious offense level. Please also check if the violation is already elevated and select the corresponding violation for elevation. '  ,  "warning");

				/*			$('#offense_level').prop('selectedIndex', 2);
							$('#violation_selection').find('option').remove();	
							  $('#violation_selection')
        					 .append($("<option selected='' disabled=''></option>")
                    .attr("value", '0')
                    .text('Select violation'));

                    getViolation();*/
						//offenseLevelChange();
						// elevateToSeriousDiff();
					}

					else if (offense_no > 3 && diff_offense_no == 2 && $('#offense_level').val() == 'Less Serious')
					{
						swal("Warning!", 'This will be the fourth commission of student with student number ' + $('#student_number').val() + ' of ' + (current_offense_no) +' same type of ' +  $('#offense_level').val()  + 
							'. The offense level will elevate to Serious offense level. Please also check if the violation is already elevated and select the corresponding violation for elevation.' + 
							'\n\n This student also committed 2 different types of same Offense Level' ,  "warning");

						//'elevate same type and warning for diff type'



			/*				$('#offense_level').prop('selectedIndex', 2);
							$('#violation_selection').find('option').remove();	
							  $('#violation_selection')
        					 .append($("<option selected='' disabled=''></option>")
                    .attr("value", '0')
                    .text('Select violation'));
                    */
        				//getViolation();
						// offenseLevelChange();
						// elevateToSeriousSame();
						
					}

					else if (offense_no > 3 && $('#offense_level').val() == 'Less Serious')
					{
						swal("Warning!", 'This will be the fourth commission of student with student number ' + $('#student_number').val() + ' of ' + (current_offense_no) +' same type of ' +  $('#offense_level').val()  + 
							'. The offense level will elevate to Serious offense level. Please also check if the violation is already elevated and select the corresponding violation for elevation.' ,  "warning");


			/*				$('#offense_level').prop('selectedIndex', 2);
							$('#violation_selection').find('option').remove();	
							  $('#violation_selection')
        					 .append($("<option selected='' disabled=''></option>")
                    .attr("value", '0')
                    .text('Select violation'));

                    getViolation();*/
                }

					//must get all the serious (3) within a sem
			/*		if ((total_serious_offense_no) == 2 && $('#offense_level').val() == 'Serious')
					{
						swal("Warning!", 'The student with student number ' + $('#student_number').val() + ' committed ' + (total_serious_offense_no) + ' different type of ' +  $('#offense_level').val() + '. This will be the third commision of different types of Serious offense and will elevate to Very-Serious offense level. Please also check if the violation is already elevated and select the corresponding violation for elevation. '  ,  "warning");

							$('#offense_level').prop('selectedIndex', 3);
							$('#violation_selection').find('option').remove();	
							  $('#violation_selection')
        					 .append($("<option selected='' disabled=''></option>")
                    .attr("value", '0')
                    .text('Select violation'));

        				getViolation();
						//offenseLevelChange();
						// elevateToSeriousDiff();
					}*/




	/*				 if (diff_offense_no == 3)

					{	
				
						$('#offense_level').prop('selectedIndex', 2);
							$('#violation_selection').find('option').remove();	
							  $('#violation_selection')
         .append($("<option selected='' disabled=''></option>")
                    .attr("value", '0')
                    .text('Select violation'));

         				
						//getViolation();
						offenseLevelChange();
						elevateToSeriousDiff();


					}



					*/

				// 	else if (offense_no >6 && $('#violation_offense_level').val('Serious'))
				// 	{
				// 		$('#violation_offense_level').attr("style", "color:red").val('Very Serious');

				// 	}
				// $('#committed_offense_number').val(offense_no);	
				// $('#offense_number').val(offense_no);	
				// $('#sanction').val(sanction);
				// $('#violation_sanction').val(sanction);
				// } 
				$('#offense_number').val(offense_no);
				$('#committed_offense_number').val(offense_no);

				$('#sanction').val(sanction);
				$('#violation_sanction').val(sanction);
				
				// else {
				// $('#violation_offense_level').attr("style", "color:#cccc00");
				// $('#committed_offense_number').val(1);
				// $('#offense_number').val(offense_no);
				// $('#sanction').val(sanction);
				// $('#violation_sanction').val(sanction);



				// }

				//alert(	$('#committed_offense_number').val());

			});

}



function elevateToSeriousDiff()
{
	var data = 'Commission of three less serious ';
	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : 'report-violation/serious/elevate',
		type: 'POST',
		data: {name : data},
	}).done(function (data){
		console.log(data.violation.description);

				// $('#violation_selection').val(data.violations[key].name);
				$('#violation_selection')
				.append($("<option></option>")
					.attr("value",data.violation.name)
					.text(data.violation.name));

				$('#violation_selection').prop('selectedIndex', 0);

			});


}

function elevateToSeriousSame()
{
	var data = 'Repeated commision of less serious';
	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : 'report-violation/serious/elevate',
		type: 'POST',
		data: {name : data},
	}).done(function (data){
		console.log(data.violation.name);

				// $('#violation_selection').val(data.violations[key].name);
				$('#violation_selection')
				.append($("<option></option>")
					.attr("value",data.violation.description)
					.text(data.violation.name));

				$('#violation_selection').prop('selectedIndex', 0);

			});

}




$('#find_complainant').on('click', function(e) {
	e.preventDefault();

	var id_no = $('#complainant').val();

		//checks if textbox has input
		if (id_no.length <= 0) {

			$('#complainant_id').val("");

		} else {
			$.ajax({
				url : '/report-violation/search/complainant',
				type : 'GET',
				data : {
					term : id_no
				},
			}).done(function(data) {

				//checks if data reponse has value
				if (data.length == 0) {
					x();
					$('#complainant_id').val("");

					$('#new_complainant').show();
					$('#complainant_error').html("Complainant not found");

					$('#complainant_info').val("").attr("readonly", false);

				} else {
					x();
					$('#new_complainant').hide();
					$('#complainant_error').html("");
					var value = data[0].value;
					var c_name = data[0].name;
					var c_pos = data[0].position;
					$('#complainant_id').val(value);
					$('#complainant_info').val(c_name + " ( " + c_pos + " )").attr("readonly", true);

				}

			});

		}

	});

$('#new_complainant_btn').click(function(e) {
	e.preventDefault();

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : '/report-violation/add-complainant',
		type : 'POST',
		data : $('form#new_complainant_form').serialize(),
	}).done(function(data) {
		var msg = "";
		if (data.success == false) {
			$.each(data.errors, function(k, v) {
				msg = msg + v + "\n";
				swal("Oops...", msg, "warning");

			});

		} else {
			x();
			swal({
				title : "Success!",
				text : "Complainant Added",
				timer : 3000,
				type : "success",
				showConfirmButton : false
			});

			$('form#new_complainant_form').each(function() {
				this.reset();
			});

			$('#complainant_modal').modal('toggle');
			$('#new_complainant').hide();
			$('#complainant_error').html("");

			$('#find_complainant').trigger('click', function(e) {
				e.preventDefault();
			});
		}

	});

		//ajax
	});

$('#new_complainant').click(function() {
		//load a modal and add record and put into inputs
		var c_id = $('#complainant').val();
		$('#complainantId').val(c_id);
		$('#complainant_id').val("");

	});

$('#course').on('change', function(e) {
	e.preventDefault();

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : '/report-violation/search/course/years',
		type : 'GET',
		data : {
			course : $('#course').val()
		},
	}).done(function(data) {

		if (data == null) {
			alert('Not Found');
		} else {

			if (data.no_of_years == 5) {
				$('#yearLevel').find('option').remove();
				$('#yearLevel').append($("<option selected='' disabled=''></option>").attr("value", '0').text('Select Year'));
				$('#yearLevel').append($("<option></option>").attr("value", "1st").text("1st Year"));
				$('#yearLevel').append($("<option></option>").attr("value", "2nd").text("2nd Year"));
				$('#yearLevel').append($("<option></option>").attr("value", "3rd").text("3rd Year"));
				$('#yearLevel').append($("<option></option>").attr("value", "4th").text("4th Year"));
				$('#yearLevel').append($("<option></option>").attr("value", "5th").text("5th Year"));

			} else {
				$('#yearLevel').find('option').remove();

				$('#yearLevel').append($("<option selected='' disabled=''></option>").attr("value", '0').text('Select Year'));
				$('#yearLevel').append($("<option></option>").attr("value", "1st").text("1st Year"));
				$('#yearLevel').append($("<option></option>").attr("value", "2nd").text("2nd Year"));
				$('#yearLevel').append($("<option></option>").attr("value", "3rd").text("3rd Year"));
				$('#yearLevel').append($("<option></option>").attr("value", "4th").text("4th Year"));
			}

		}

	});

});

