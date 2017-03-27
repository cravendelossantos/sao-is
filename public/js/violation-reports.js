
$(document).ready(function(){

  $('#v_reports_range .input-daterange').datepicker({
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    format: 'yyyy-mm-dd',
  });

});

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



$('#show_v_reports').click(function (e){
  e.preventDefault();


  if($('#v_reports_from').val() == ""  && $('#v_reports_to').val() == "")
  {
    $('#report_from').val("");
    $('#report_to').val("");
    $('#report_type').val("List of "+$('select#v_reports_offense_level').val() +  " Offenses ");
    if($('#course').val() != "")
    {
      $('#report_group').val($('select#course').val());
    }
    else if($('#college').val() != "")
    {
      $('#report_group').val($("select#college option:selected").text());
    }
    else if($('#college').val() == "")
    {
      $('#report_group').val("");
    }
    else if($('#course').val() == "")
    {
      $('#report_group').val("");
    }
    getReports();

  }

  else
  {
    $('#report_from').val("From: " + $('#v_reports_from').val());
    $('#report_to').val("To: " + $('#v_reports_to').val());
    $('#report_type').val("List of "+$('select#v_reports_offense_level').val() +  " Offenses ");
    if($('#course').val() != "")
    {
      $('#report_group').val($('select#course').val());
    }
    else if($('#college').val() != "")
    {
      $('#report_group').val($("select#college option:selected").text());
    }
    else if($('#college').val() == "")
    {
      $('#report_group').val("");
    }
    else if($('#course').val() == "")
    {
      $('#report_group').val("");
    }
    getReports();
  }





});

$('#course').change(function (e){
  e.preventDefault();

});

$('#college').change(function (e){
  e.preventDefault();

});


/*
$('#v_reports_offense_level').change(function(e){
	e.preventDefault();
getReports();
})*/


