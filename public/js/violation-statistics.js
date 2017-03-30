
$(document).ready(function(){
  $('#schoolyear').val("S.Y." + $('#school_year').val());

  $('#v_stats_range .input-daterange').datepicker({
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    format: 'yyyy-mm-dd',
  });
 


  var v_stats_table = $('#violation-stats-DT').DataTable({
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
    
  },
  "columns" : [
  {data : 'cams'},
  {data : 'cas'},
  {data : 'cba'},
  {data : 'coecsa'},
  {data : 'cithm'},

  ],


});




$('#show_v_stats').click(function (e){


  if($('#v_stats_from').val() == ""  && $('#v_stats_to').val() == "")
  {
    $('#report_from').val("");
    $('#report_to').val("");
    drawVisualization();
    v_stats_table.ajax.reload();  
  }
  else 
  {
    $('#report_from').val("From: " + $('#v_stats_from').val());
    $('#report_to').val("To: " + $('#v_stats_to').val());
    drawVisualization();
   v_stats_table.ajax.reload();
  }
  });
  drawVisualization();

        
        function drawVisualization() {
          var options = {
       is3D: true,
             annotations: {
      
    textStyle: {
      fontName: 'Times-Roman',
      fontSize: 14,
      bold: true,
      italic: true,
      // The color of the text.
      color: 'white',

      // The color of the text outline.
      auraColor: 'black',
      // The transparency of the text.
            
    }
  },
  chartArea: {
   top: 100,
   height: '40%' 
},
            bar: {
              groupWidth: "80%"
            },
            legend: { position: "none" },
             width: 800,
            backgroundColor: { fill:'transparent' },
            hAxis : {title:'Colleges', titleTextStyle:{color:'blue'}},
            vAxis : {title:'Number of Students', titleTextStyle:{color:'red'}},
                        
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
                  var c_data = google.visualization.arrayToDataTable([
         ['Department', { role: 'annotation' }, 'Number of Students', { role: 'style' }],
         ['College of Allied Medical Sciences', 'CAMS', items[0].cams, 'blue'],      
         ['College of Arts and Sciences', 'CAS', items[0].cas, 'green'],       
         ['College of Engineering, Computer Studies and Architecture', 'COECSA', items[0].coecsa, 'orange'],   
         ['College of International Tourism and Hospitality Management', 'CITHM', items[0].cithm ,'red'],   
      ]);



          var violation_stats_chart = new google.visualization.ColumnChart(document.getElementById('visualization'));
          violation_stats_chart.draw(c_data, options);


        });
         google.setOnLoadCallback(drawVisualization);
       }

     });
