
$(document).ready(function(){
	
	$('#locker_reports_range .input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		format: 'yyyy-mm-dd',
	});

	
	var stats_table = $('#locker-reports-DT').DataTable({
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
			url : "/locker-reports/list",
			type: "POST",
			data: function (d) {
				d.locker_reports_from = $('#locker_reports_from').val();
				d.locker_reports_to = $('#locker_reports_to').val();
			},
		},
		"columns" : [
		{data: 'total'},
		{data: 'available'},
		{data: 'occupied'},	
		{data: 'damaged'},
		{data: 'locked'},
		],


	});




$('#show_locker_reports').click(function(e){
	stats_table.ajax.reload();
	if ($('#locker_reports_from').val() != ""  || $('#locker_reports_to').val() != ""){
    // swal("Ooops!", "Please the select dates range", "warning");
    $('#report_from').val("From: " + $('#locker_reports_from').val());
    $('#report_to').val("To: " + $('#locker_reports_to').val());
}




drawVisualization();
function drawVisualization() {
	var options = {

		legend : {
			position: 'right',
		},
		backgroundColor: { fill:'transparent' },
		/*title: 'Total number of Lost and Found items',*/
		is3D: false,
		pieHole: 0.4,
		pieSliceText: 'percentage',
		slices: {
			0: { color: 'green'},
			1: { color: 'blue', offset: 0.2},
			2: { color: 'gold', offset: 0.1},
			3: { color: 'red', offset: 0.3},
		}

	};
	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : "/locker-reports/stats",
		type: 'POST',
		data:  {
			locker_reports_from : $('#locker_reports_from').val(),
			locker_reports_to : $('#locker_reports_to').val()
		},
		async: false,
	}).fail(function(data){
		var errors = $.parseJSON(data.responseText);
		var msg="";

		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");
		});

	}).done(function(response){
		items = response;

		console.log(items);
		var items = response;

		var c_data = google.visualization.arrayToDataTable([

			['Statistics',   'Lockers'],
			['Available',   items.available],
			['Occupied',   items.occupied],
			['Locked',   items.locked],
			['Damaged',   items.damaged]
			]);

		var LAF_chart = new google.visualization.PieChart(document.getElementById('visualization'));
		LAF_chart.draw(c_data, options);

	});

	google.setOnLoadCallback(drawVisualization);

}

});

});