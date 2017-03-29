$(document).ready(function(){

		tinymce.init({
			selector: "textarea",
			plugins: [
				"advlist lists textcolor colorpicker autoresize print",
			],
			toolbar: [ "print | undo redo | styleselect | fontselect | forecolor | fontsizeselect",
				"bold italic underline | alignleft aligncenter alignright alignjustify | indent outdent | bullist numlist",
			],
			fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt 40pt',
			menubar: 'file'
		});
		
	var lockers_table = $('#lockers-DT').DataTable({
		"processing": true,
		"serverSide": true,
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
		{data : 'status'},		  
		{data : 'lessee_name'},
		{data: 'action', name: 'action', orderable: false, searchable: false},



		],
		dom : '<"html5buttons"B>lTfgtip',
		buttons : [{
			extend : 'csv',
			title : 'Lockers',
		}, {
			extend :'excel',
			title : 'Lockers',
		} , {
			extend : 'pdf',
			title : 'Lockers',
		} , {
			extend : 'print',
			title : 'Lockers',
			customize : function(win) {
				$(win.document.body).addClass('white-bg');
				$(win.document.body).css('font-size', '8px');
				$(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
			}
		}]
	});




//Locker Management
function lockerRange()
{
	var num = parseInt($('#no_of_lockers').val());
	var from = parseInt($('#from').val());

	var val = num + from;
	$('#to').val(val - 1);

}



$('#from').on('input', function (){
	lockerRange();
});

$('#no_of_lockers').on('input', function (){
	lockerRange();
});


$('#add_locker_btn').click(function(e){
	e.preventDefault();


	swal({   
		title: "Are you sure?",   
		text: "This action will add new lockers",   
		type: "warning",   
		showCancelButton: true,  
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Submit",   
		closeOnConfirm: true 
	}, function(){ 
		$.ajax({
			url : '/lockers/add',
			type: 'POST',	
			data: $('#add_locker_form').serialize(),
		}).fail(function(data){
			var errors = $.parseJSON(data.responseText);
			var msg="";

			$.each(errors.errors, function(k, v) {
				msg = msg + v + "\n";
				swal("Oops...", msg, "warning");

			});


		}).done(function(data) {
			swal('Success!' , 'New Lockers added!', "success");
			$('form#add_locker_form')[0].reset();
			lockers_table.ajax.reload();
		});
	});

});




$('#status_sort').change(function(){
	lockers_table.ajax.reload();
});


$('#location_sort').change(function(){
	lockers_table.ajax.reload();
});





$('.lockers-DT').on('click', 'tr', function(){
	var tr_id = $(this).attr('id');
	$('#occupancy_div').hide();
	$('#m_update_status').prop('selectedIndex',0);
	//$('form#claim_item')[0].reset();
	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url: "/locker/details",
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
				if (data.response['status'] == "Occupied")
				{
					return false;
				}
				$('#lockers_modal').modal('show');

				var locker_no = data.response['locker_no'];
				var location = data.response['location'];


				$('#m_locker_no').val(locker_no);
				$('#_m_locker_no').val(locker_no)
				$('#m_location').val(location);

				var current_status = data.response['status'];

				var status_color = "";

				if (current_status == 'Available'){
					status_color = 'Green';
				} else if (current_status == 'Damaged'){
					status_color = 'Red';
				} else if (current_status == 'Locked'){
					status_color = 'Gold';
				} else if (current_status == 'Occupied'){
					status_color = 'Blue';
				}

				$('#m_current_status').val(current_status).css('color', status_color);

				$('#m_update_status').change(function(e){

					
					if (this.value == 'Occupied')
					{
						
						$('#occupancy_div').show();
						
					} else{
						
						$('#occupancy_div').hide();
						
					}
					
				});

			}
		}

	});
});



$('#locker_update').click(function(e){
	e.preventDefault();

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : '/locker/update-status',
		type: 'POST',
		data: $('form#locker_status_update').serialize(),

	}).fail(function(data){
		var errors = $.parseJSON(data.responseText);
		var msg="";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");
		});

	}).done(function(data){

	//$('#locker_status_update')[0].reset();
	//locker_contract, return occupied data from the backend and open the contract div
	$('#occupancy_div').hide();
	$('#lockers_modal').modal('hide');
	
	swal("Success", "Locker Updated!", "success");
	$('#location_sort').prop('selectedIndex', 0);
	$('#status_sort').prop('selectedIndex', 0);
	//printlockercontract
	/*if (data['occupied'] == true)
	{
		console.log($('#c_fname').val());
		$('#locker_contract').show();
		$('#c_fname').html($('#m_lessee_name').val());

	}*/
	lockers_table.ajax.reload();
	$('form#locker_status_update')[0].reset();
});
});

});
