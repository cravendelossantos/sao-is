
//Date pickers

$('#data_1 .input-group.date').datepicker({
	todayBtn : "linked",
	keyboardNavigation : false,
	forceParse : false,
	calendarWeeks : true,
	autoclose : true,
	format : 'yyyy-mm-dd'
});



$('#LAF_date_picker .input-group.date').datepicker({
	todayBtn : "linked",
	keyboardNavigation : false,
	forceParse : false,
	calendarWeeks : true,
	autoclose : true,
	format : 'yyyy-mm-dd'
});


$('#data_4 .input-group.date').datepicker({
//   	todayBtn : "linked",
format : 'yyyy-mm',
minViewMode: 1,
keyboardNavigation: false,
forceParse: false,
autoclose: true,
todayHighlight: true
});

$('#first_sem_range .input-daterange').datepicker({
	keyboardNavigation: false,
	forceParse: false,
	autoclose: true
});


$('#second_sem_range .input-daterange').datepicker({
	keyboardNavigation: false,
	forceParse: false,
	autoclose: true
});

$('#summer_range .input-daterange').datepicker({
	keyboardNavigation: false,
	forceParse: false,
	autoclose: true
});



//Summer note functions

$('.summernote').summernote();

var edit = function() {
	$('.click2edit').summernote({focus: true});

};
var save = function() {
        var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
        $('.click2edit').destroy();
    };

    $('#sy_date_btn').click(function (e){
    	e.preventDefault();
    	$.ajax({
    		type : "GET",
    		url : "/settings/dates/school-year/set",
    		data : $('form#sy_form').serialize(),

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
    			text: "This will create a new school year (" + $('#school_year').val() + " )" ,   
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
    				url : "/settings/dates/school-year/set",
    				data : $('form#sy_form').serialize(),
    			}).done(function(data){
    				swal({   
    					title: "Success!",  
    					text: "School Year added",   
    					timer: 1000, 
    					type: "success",  
    					showConfirmButton: false 



    				});
	
		});
    		});
    	});
    });

//School Year
var school_year_table = $('.school-year-DT').DataTable({
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
		url : "/settings/show/school-years",
		type: "POST",
	},
	"rowId" : 'id',	
	"columns" : [
	{data : 'school_year'},
	{data : 'term_name'},
	{data : 'start'},
	{data : 'end'},

	]
});




function x(){
	$('#try').show();
	setTimeout(function(){

		$('#try').fadeOut('slow');
	},700);
}



function y(){
	$('#try2').show();
	setTimeout(function(){

		$('#try2').fadeOut('slow');
	},3000);
}


$('.time_reported').clockpicker({

	twelvehour : true

});








//Student Records

var student_records_table = $('.student-records-DT').DataTable({
	"processing": true,
	"serverSide": true,
	"ajax": {
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : "/student-records/list",
		type: "POST",
	},
	"bSort" : true,
	"bFilter" : true,
	"order": [[ 0, "desc" ]],
	"rowId" : 'student_no',	
	"columns" : [

	{data : 'student_no'},
	{data : 'first_name'},
	{data : 'last_name'},
	{data : 'course'},
	{data : 'year_level'},
	{data : 'student_contact_no'},
	{data: 'action', name: 'action', orderable: false, searchable: false},

	],
	dom : '<"html5buttons"B>lTfgtip',
	buttons : [{
		extend : 'csv',
		title : 'STUDENT RECORDS',
	}, {
		extend :'excel',
		title : 'STUDENT RECORDS',
	} , {
		extend : 'pdf',
		title : 'STUDENT RECORDS',
	} , {
		extend : 'print',
		title : 'STUDENT RECORDS',
		customize : function(win) {
			$(win.document.body).addClass('white-bg');
			$(win.document.body).css('font-size', '8px');
			$(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
		}
	}]
});




//Student Records

var violation_records_table = $('.violation-records-DT').DataTable({
	"processing": true,
	"serverSide": true,
	"ajax": {
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : "/violation-list/all",
		type: "POST",
	},
	"bSort" : true,
	"bFilter" : true,
	"order": [[ 0, "desc" ]],
	"rowId" : 'id',	
	"columns" : [

	{data : 'name'},
	{data : 'description'},
	{data : 'offense_level'},
	{data : 'first_offense_sanction'},
	{data : 'second_offense_sanction'},
	{data : 'third_offense_sanction'},

	],
	dom : '<"html5buttons"B>lTfgtip',
	buttons : [{
		extend : 'csv',
		title : 'VIOLATION RECORDS',
	}, {
		extend :'excel',
		title : 'VIOLATION RECORDS',
	} , {
		extend : 'pdf',
		title : 'VIOLATION RECORDS',
	} , {
		extend : 'print',
		title : 'STUDENT RECORDS',
		customize : function(win) {
			$(win.document.body).addClass('white-bg');
			$(win.document.body).css('font-size', '8px');
			$(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
		}
	}]
});	


	$('#truncate_btn').click(function(e){
		e.preventDefault();

		swal({title: "Are you sure?",   
			text: "This will empty the violation records",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "Proceed",   
			cancelButtonText: "Cancel",   
			closeOnConfirm: true,   
			closeOnCancel:true  }, 
			function(isConfirm){   
				if (isConfirm) {  
					$.ajax({
						headers : {
							'X-CSRF-Token' : $('input[name="_token"]').val()
						},
						url : '/violation-records/truncate',
						type: 'POST',
						success : function(response){
							if (response.success == true){
								swal({   
									title: "Success!",  
									text: "Table truncated",   
									timer: 2000, 
									type: "success",  
									showConfirmButton: false,

								});
								violation_records_table.ajax.reload();
							}
							else if (response.success == false) {
								var msg="";
								$.each(response.errors, function(k, v) {
									msg = msg + v + "\n";
									swal("Failed", msg, "error");  

								});





							}


						},
					});  		 
				} 

			});

	});





//Report Print Function

var date = new Date();
var options = {year: "numeric", month: "long", day: "numeric"};
var newdate = date.toLocaleDateString('en-US', options);
$('#date').val(newdate);
$('#schoolyear').val("S.Y." + $('#school_year').val());

$('#print').click(function(e){

	var content = document.getElementById('report_content').innerHTML;

	document.body.innerHTML = content;
	window.print();
	window.location.reload();
	e.preventDefault();
});





// DataTables
//with Buttons

 $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>',
               

            });
 /*
 $('.dataTable').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });*/
/*
$('.dataTables-example').DataTable({
	dom : '<"html5buttons"B>lTfgtip',

});*/

$('.dataTables-without-buttons').DataTable({
	dom : '<"html5buttons">'

});