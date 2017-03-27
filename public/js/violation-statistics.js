
$(document).ready(function(){
  $('#schoolyear').val("S.Y." + $('#school_year').val());

  $('#v_stats_range .input-daterange').datepicker({
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    format: 'yyyy-mm-dd',
  });
 




});

function getStats(){
  var v_stats_table = $('.violation-stats-DT').DataTable({
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
      url : "/violation-statistics/stats",
      type: "POST",
      data: function (d) {
        d.v_stats_from = $('#v_stats_from').val();
        d.v_stats_to = $('#v_stats_to').val();
        d.school_year = $('#school_year').val();
      },
    // data : {month : current_date},
  },
  "columns" : [
  {data : 'cams'},
  {data : 'cas'},
  {data : 'cba'},
  {data : 'coecsa'},
  {data : 'cithm'},

  ],


});

}


$('#show_v_stats').click(function (e){


  if($('#v_stats_from').val() == ""  && $('#v_stats_to').val() == "")
  {
    $('#report_from').val("");
    $('#report_to').val("");
    getStats();
  }
  else 
  {
    $('#report_from').val("From: " + $('#v_stats_from').val());
    $('#report_to').val("To: " + $('#v_stats_to').val());
    getStats();
  }
  
        // getData();

        drawVisualization();
        function drawVisualization() {
          var options = {

            is3D: true,

            bar: {
              groupWidth: "90%"
            },
            legend: { 
              position: "right" 
            },
            backgroundColor: { fill:'transparent' },
            hAxis : {title:'Colleges', titleTextStyle:{color:'blue'}},
            vAxis : {title:'Students', titleTextStyle:{color:'red'}},
            
          };


          $.ajax({
            headers : {
              'X-CSRF-Token' : $('input[name="_token"]').val()
            },
            url: '/violation-statistics/stats',
            type:'POST',
            
            data: {
             v_stats_from : $('#v_stats_from').val(),
             v_stats_to : $('#v_stats_to').val(),
             school_year : $('#school_year').val(),

           },
         }).done(function(response){
          var items = (response.data);


          var c_data = new google.visualization.DataTable();
          c_data.addColumn('string', 'Department');
          c_data.addColumn({type:'string', role:'annotation'});
          c_data.addColumn('number', 'Number of Students');
          c_data.addRows([['College of Allied Medicine', 'CAMS', items[0].cams],
            ['College of Arts and Sciences', 'CAS', items[0].cas],
            ['College of Engineering, Computer Studies and Architecture', 'COECSA', items[0].coecsa],
            ['College of International Tourism and Hospitality Managemet', 'CITHM', items[0].cithm],
            ['College of Business Administration', 'CBA', items[0].cba],
            ]);



          var violation_stats_chart = new google.visualization.ColumnChart(document.getElementById('visualization'));
          violation_stats_chart.draw(c_data, options);


        });
         google.setOnLoadCallback(drawVisualization);
       }

     });
