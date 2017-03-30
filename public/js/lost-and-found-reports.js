
$(document).ready(function(){
	 $('#report_type').val("List of "+$('select#sort_by').val() + " Items");


    $('select#sort_by').change(function(e){   
    $('#report_type').val("List of "+$('select#sort_by').val() + " Items");


  });

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
    },
    async: false,
    success: function(response){
     items = response;


   }
 });


    }





 var lost_and_found = $('.lost-and-found').DataTable({
  "processing": true,
  "serverSide": true,
  "ajax": {
    headers : {
      'X-CSRF-Token' : $('input[name="_token"]').val()
    },
    url : "/lost-and-founds/items/reports",
    type: "POST",
          data: function (d) {
          d.LAF_stats_from = $('#LAF_stats_from').val();
          d.LAF_stats_to = $('#LAF_stats_to').val();
          d.sort_by = $('#sort_by').val();
          d.school_year = $('#school_year').val();
        },
  },
      "bPaginate" : false,
      "bInfo" :false,
      "bSort" : false,
      "bFilter" : false,
      
  "order": [[ 0, "desc" ]],
  "rowId" : 'id', 
  "columns" : [
  {data : 'date_reported'},
  {data : 'item_description'},
  {data : 'endorser_name'},
  {data : 'found_at'},
  {data : 'owner_name'},
  {data : 'status'},
  {data : 'date_claimed'},
  {data : 'claimer_name'},
  ],
  
});




 $('#show_LAF_stats').on('click', function(){


lost_and_found.ajax.reload();



    if ($('#LAF_stats_from').val() != ""  || $('#LAF_stats_to').val() != ""){
    // swal("Ooops!", "Please the select dates range", "warning");
    $('#report_from').val("From: " + $('#LAF_stats_from').val());
    $('#report_to').val("To: " + $('#LAF_stats_to').val());
  }




});

});



