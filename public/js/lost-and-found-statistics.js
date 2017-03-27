
$(document).ready(function(){


	$('#LAF_stats_range .input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		format: 'yyyy-mm-dd',
	});
	

	function LAF_currentMonthReports() {

		var d = new Date(),

		n = d.getMonth(),

		y = d.getFullYear();

		var current_date = n + y;

		$.ajax({
			headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			url : "/lost-and-found/reports/stats",
			type: 'POST',
			data : {LAF_stats_from : $('#LAF_stats_from').val(),
			LAF_stats_to : $('#LAF_stats_to').val(),
			school_year : $('#school_year').val(),
		},
		async: false,
		success: function(response){
			items = response;


		}
	});


		$('.lost-and-found-reports-DT').DataTable({
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
				url : "/lost-and-found/reports/list",
				type: "POST",
				data : {month : current_date},
			},
			"columns" : [
			{data: 'claimed'},
			{data: 'unclaimed'},
			{data: 'donated'},
			{data: 'total'},
			],


		});

	}
	

});

$('#print').click(function(e){
	var content = document.getElementById('report_content').innerHTML;
	document.body.innerHTML = content;
	window.location.reload();
	$(this).hide();
	/* $('.google-visualization-controls-rangefilter').hide();*/
	window.print();
});


$('#show_LAF_stats').on('click', function(){




	if ($('#LAF_stats_from').val() != ""  || $('#LAF_stats_to').val() != ""){
    // swal("Ooops!", "Please the select dates range", "warning");
    $('#report_from').val("From: " + $('#LAF_stats_from').val());
    $('#report_to').val("To: " + $('#LAF_stats_to').val());
}








drawVisualization();
function drawVisualization() {
	var options = {

		/*title: 'Total number of Lost and Found items',*/
		is3D: true,
		backgroundColor: { fill:'transparent' },  
	};


	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		url : "/lost-and-found/reports/stats",
		type: 'POST',
		data : {LAF_stats_from : $('#LAF_stats_from').val(),
		LAF_stats_to : $('#LAF_stats_to').val(),
		school_year : $('#school_year').val(),
	},
	async: false,
	success: function(response){
		var items = response;
		console.log(items);
		var c_data = google.visualization.arrayToDataTable([

			['Statistics',   'Lost and Found'],
			['Claimed',   items['claimed'],],
			['Unclaimed',   items['unclaimed'],],
			['Donated',   items['donated'],]
			]);

		var LAF_chart = new google.visualization.PieChart(document.getElementById('visualization'));
		LAF_chart.draw(c_data, options);

	}
});





}


google.setOnLoadCallback(drawVisualization);
$('.lost-and-found-reports-DT').DataTable().destroy();
$('.lost-and-found-reports-DT').DataTable({
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
		url : "/lost-and-found/reports/list",
		type: "POST",
		data: function (d) {
			d.LAF_stats_from = $('#LAF_stats_from').val();
			d.LAF_stats_to = $('#LAF_stats_to').val();
			d.school_year = $('#school_year').val();
		},
	},
	"columns" : [
	{data: 'claimed'},
	{data: 'unclaimed'},
	{data: 'donated'},
	{data: 'total'},
	],


});
$('#try').hide();
});

