
$(document).ready(function() {




  $('.i-checks').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
});

        /* initialize the external events
        -----------------------------------------------------------------*/
        /* initialize the calendar
        -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $.ajax({
          headers : {
            'X-CSRF-Token' : $('input[name="_token"]').val()
        },
        url: '/get-events',
        type: 'POST',
        data: 'type=fetch',
        async: false,
        success: function(response){

         json_events = response;

     },     
     error: function(response) { 
         json_events = response;
     }     

 });

        $.ajax({
          headers : {
            'X-CSRF-Token' : $('input[name="_token"]').val()
        },
        url: '/campus/getCVF_no',
        type: 'GET',

        success: function(response){

         cvf_no = response;

     }      

 });











        var calendar1 = $('#calendar').fullCalendar({

          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,listMonth'
            
            
        },

        selectable: true,
        editable: true,
        eventLimit: true, 
        selectHelper: true,
        eventSources: [
        json_events,   

        ],



        select: function(start, end, jsEvent, view) {

            $('input[name="time"]').daterangepicker({
              "minDate": moment(start).format('YYYY-MM-DD hh:mm A'),
              "maxDate": moment(end).format('YYYY-MM-DD hh:mm A'),



              "timePicker": true,
              "timePicker12Hour": true,
              "timePickerIncrement": 15,
              "startDate": moment(start).format('YYYY-MM-DD hh:mm A'),
              "endDate": moment(start).format('YYYY-MM-DD hh:mm A'),


              "autoApply": true,
              "locale": {

                "timePicker12Hour": true,
                "format": "YYYY-MM-DD hh:mm A",
                "separator": " - ",
            }
        });
            if (moment().diff(start, 'days') < -4) {
              $('#calendar').fullCalendar('unselect');
              $('#ModalAdd #time').val(moment(start).format('YYYY-MM-DD hh:mm A')+" - "+moment(start).format('YYYY-MM-DD hh:mm A'));
              
              $('#ModalAdd #cvf_no').val(cvf_no);

              $('#ModalAdd').modal('show');
              return false;


          }


      },
      eventRender: function(event, element) {

        if (event.status == "Banned"){
          element.css('background-color', '#9B0D0D');
          element.css('border-color', '#9B0D0D');
          element.css('color', 'white');


      }
      else if (event.status == "OnProcess")
      {
          element.css('background-color', '#04803A');
          element.css('border-color', '#04803A');
          element.css('color', 'white');
      }
      else
      {

      };

      element.bind('click', function() {

          $('input[name="time"]').daterangepicker({
            "minDate": event.start.format('YYYY-MM-DD'),



            "timePicker": true,
            "timePicker12Hour": true,
            "timePickerIncrement": 15,
            "startDate": event.start.format('YYYY-MM-DD HH:mm A'),
            "endDate": event.end.format('YYYY-MM-DD HH:mm A'),


            "autoApply": true,
            "locale": {

              "timePicker12Hour": true,
              "format": "YYYY-MM-DD HH:mm A",
              "separator": " - ",
          }
      });




          $('#ModalEdit #update_id').val(event.id);
          $('#ModalEdit #title').val(event.title);
          $('#ModalEdit #venue').val(event.venue);
          $('#ModalEdit #organization').val(event.organization);
          $('#ModalEdit #organization1').val(event.organization);
          $('#ModalEdit #status').val(event.status);
          $('#ModalEdit #time').val(event.start.format('YYYY-MM-DD HH:mm A')+" - "+event.end.format('YYYY-MM-DD HH:mm A'));
          $('#ModalEdit #cvf_no').val(event.cvf_no);

          $('#ModalEdit').modal('show');
      });
  },

            eventDrop: function(event, delta, revertFunc) { // change of position

              edit(event);

          },

            eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // event resize

              edit(event);

          },

          eventMouseover: function( event, jsEvent, view ) { 
              var start = (event.start.format("hh:mm A"));
              var end = (event.end.format("hh:mm A"));
              var back=event.backgroundColor;

              var tooltip = '<div class="tooltip-demo " style="width:230px;height:140px;color:black;background-color:white;border:2px solid black;padding-left: 10px;'+back+';position:absolute;z-index:10001;">'+'<b>Start:</b> '+ event.title +'<br>'+'<b>Venue:</b> '+event.venue+'<br>'+'<b>Organizer:</b> '+event.organization+'<br>'+'<b>status:</b> '+event.status+'<br>'+ '<b>Start:</b> '+start+'<br>'+ '<b>End: </b>'+ end  +'<br>'+'<b>cvf_no:</b> '+event.cvf_no+'<br>'+'</div>';


              $("body").append(tooltip);
              $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.tooltip-demo').fadeIn('500');
                $('.tooltip-demo').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $('.tooltip-demo').css('top', e.pageY + 10);
                $('.tooltip-demo').css('left', e.pageX + 20);
            });            
        },

        eventMouseout: function(calEvent, jsEvent) {
          $(this).css('z-index', 8);
          $('.tooltip-demo').remove();
      },

  });




function edit(event){
  start = event.start.format('YYYY-MM-DD HH:mm:ss');
  if(event.end){
    end = event.end.format('YYYY-MM-DD HH:mm:ss');
}else{
    end = start;
}

id =  event.id;

Event = {'id' : id, 'start' : start, 'end' :end};

var data =  console.log(JSON.stringify(Event));


$.ajax({
 headers : {
    'X-CSRF-Token' : $('input[name="_token"]').val()
},
url: '/campus/update',
type: "POST",
data: {Event: data},
success: function(data) {


    if(data.response == 'true'){

    }else{
      alert('Could not be saved. try again.'); 
  }
}
});
}






$('button#addEvent_btn').click(function(e) {

  e.preventDefault();

  $.ajax({
    headers : {
      'X-CSRF-Token' : $('input[name="_token"]').val()
  },
  type : "POST",
  url : "/campus/add",
  data : $('form#addEvent').serialize(),

}).done(function(data) {

    var msg = "";
    if (data.success == false) {
      $.each(data.errors, function(k, v) {
        msg = msg + v + "\n";
        swal("Oops...", msg, "warning");

    });

  } else {

      $('#ModalAdd').modal('hide');
      swal({   
        title: "Success!",  
        text: "Added Event",   
        timer: 2000, 
        type: "success",  
        showConfirmButton: false 
    });

      window.location.reload();


  }
});



});


});









$('button#updateEvent_btn').click(function(e) {

  e.preventDefault();

  $.ajax({
    headers : {
      'X-CSRF-Token' : $('input[name="_token"]').val()
  },
  type : "POST",
  url : "/campus/update",
  data : $('form#updateEvent').serialize(),

}).done(function(data) {

    var msg = "";
    if (data.success == false) {
      $.each(data.errors, function(k, v) {
        msg = msg + v + "\n";
        swal("Oops...", msg, "warning");

    });

  } else {

      $('#ModalEdit').modal('hide');
      swal({   
        title: "Success!",  
        text: "Updated Event",   
        timer: 2000, 
        type: "success",  
        showConfirmButton: false 
    });

      window.location.reload();

  }
});

});

