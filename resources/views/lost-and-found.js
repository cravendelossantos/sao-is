
$(document).ready(function(){
	//Lost and found		
	//table init	
	var lost_and_found_table = $('.lost-and-found-DT').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			url : "/lost-and-founds/items/all",
			type: "POST",
			data: function (d) {

				d.school_year = $('#school_year').val();
			},
		},

		"bSort" : true,
		"bFilter" : true,
		"order": [[ 0, "desc" ]],
		"rowId" : 'id',	
		"columns" : [
		{data : 'date_reported'},
		{data : 'time_reported'},
		{data : 'item_description'},
		{data : 'endorser_name'},
		{data : 'found_at'},
		{data : 'owner_name'},
		{data : 'status'},
		{data : 'date_claimed'},
		{data : 'claimer_name'},
		],

	});

});

//Report Item
$('button#lost_and_found_reportBtn').click(function(e) {

	e.preventDefault();

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		type : "GET",
		url : "/lost-and-found/report-item",
		data : $('form#reportLostItem').serialize(),

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
			text: "This action cannot be undone",   
			type: "warning",   
			showCancelButton: true,  
			confirmButtonColor: "#DD6B55",   
			confirmButtonText: "Submit",   
			closeOnConfirm: true 
		}, function(isConfirm){  

			if (isConfirm){
				$.ajax({
					headers : {
						'X-CSRF-Token' : $('input[name="_token"]').val()
					},
					type : "POST",
					url : "/lost-and-found/report-item",
					data : $('form#reportLostItem').serialize(),
				}).done(function(data){
					swal({   
						title: "Success!",  
						text: "Item Reported!",   
						timer: 1000, 
						type: "success",  
						showConfirmButton: false 



					});
					$('form#reportLostItem').each(function() {
						this.reset();
					});	
					lost_and_found_table.ajax.reload();
				});



			}		
			else {
				return false;
			}

		});
	});

});

//Cancel Button
$('button#lost_and_found_cancelBtn').click(function() {
	$('form#reportLostItem').each(function() {
		this.reset();
	});
}); 



//Get item details to Modal
$('.lost-and-found-DT').on('click', 'tr', function(){
	var tr_id = $(this).attr('id');

	$('form#claim_item')[0].reset();
	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url: "/lost-and-found/item_details",
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
				if (data.response['status'] == "Claimed" || data.response['status'] == "Donated")
				{
					return false;
				}
				$('#LAF_Modal').modal('show');
				var item_id = data.response['id'];
				var item_description = data.response['item_description'];
				var date_reported = data.response['date_reported'];
				var found_at = data.response['founded_at'];
				var owner_name = data.response['owner_name'];
				var endorser_name = data.response['endorser_name'];

				$('#claim_id').val(item_id);
				$('#item_description').val(item_description);
				$('#_date-reported').val(date_reported);
				$('#owner_name').val(owner_name);
				$('#found_at').val(found_at);
				$('#endorser_name').val(endorser_name);
			}
		}

	});
});


$('#claimer_name').keyup(function(e){

	if ($('#owner_name').val().toUpperCase() == $('#claimer_name').val().toUpperCase()){
		$('#claimer_name_error').html("");
	}
	else{
		$('#claimer_name_error').html("Claimer name doesn't match with owner name");
	}

});
//Claim Item
$('#claim_btn').click(function(e){
	e.preventDefault();




	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url:'/lostandfound/update',
		type: 'GET',
		data: $('form#claim_item').serialize(),
	}).fail(function(data){

		var errors = $.parseJSON(data.responseText);
		var msg = "";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");

		});
	}).done(function(data){


		$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			url:'/lostandfound/update',
			type: 'POST',
			data: $('form#claim_item').serialize(),
		});
		$('#LAF_Modal').modal('hide');
		swal({   
			title: "Success!",  
			text: "Item Claimed",   
			timer: 2000, 
			type: "success",  
			showConfirmButton: false 
		});
		lost_and_found_table.ajax.reload();

	});
});




//Filter Results
$('select#sort_by').change(function(e){
	e.preventDefault();
	var selected = $('select#sort_by option:selected').index();


	if (selected == 0) {
		lost_and_found_table.ajax.url('/lost-and-founds/items/all').load();		
	} else if (selected == 1)	{
		lost_and_found_table.ajax.url('/lost-and-founds/items/sort_by=unclaimed').load();
	} else if (selected == 2) {
		lost_and_found_table.ajax.url('/lost-and-founds/items/sort_by=claimed').load();	
	} else if (selected == 3) {
		lost_and_found_table.ajax.url('/lost-and-founds/items/sort_by=donated').load();	
	}



});

//load current month reports
