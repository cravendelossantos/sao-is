@extends('layouts.master')

<!DOCTYPE html>
@section('title', 'SAO | Campus Venue Reservation')

@section('header-page')
<div class="row">
<div class="col-lg-12">
  <h1>Campus Venue Reservation</h1>
  <ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Campus Venue Reservation Monitoring
        </li>
        <li class="active">
            <strong>Reservation Form</strong>
        </li>
  </ol>
</div>
</div>


@endsection


@section('content')


<!-- <div id="wrapper">

<div class="wrapper wrapper-content">
    <div class="row animated fadeInDown">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Add Event</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                 <label for="title">Title</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                <label for="title">Venue</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                <label for="title">Organizer</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                <label for="title">Date</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                <label for="title">Day</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                <label for="title">CVF no.</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">    
                                  <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add Reservation</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

              </div>

                    
                
                
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Striped Table </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>


</div> -->
        <div class="row">

    
<div class="col-lg-12">
  <div class="ibox float-e-margins">
      <div class="ibox-title">

<!--             <div class="col-lg-12 text-center">
                <h1>Calendar</h1>
                <div id="calendar" class="col-centered">
                </div>
            </div> -->
               <div class="row">
          <div class="form-group col-xs-6">
              
               <h4 style="">Note:</h4>
              <p>Click specific date to add reservation<br>
              Click Event to update reservation<br>
              Can't Reserve 5 days before the desired date
              </p>
               </div>
                    <div class="col-lg-6">
              <h4 style="">Legend:</h4>
              
              <p> <a href="#"> <i class="fa fa-circle text-navy"></i> On Process </a>
               <br>
               <a href="#"> <i class="fa fa-circle text-danger"></i> Cancelled</a>
               <br>
               <a href="#"> <i class="fa fa-circle text-primary"></i> Reserved</a>
               </p>

               </div>
               </div>
<hr/>
               <center><h1><b>Event Calendar</b></h1></center>
            </div>
              <div class="ibox-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        </div>
        <!-- row -->
        
        <!-- Modal -->
        <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form class="form-horizontal" id="addEvent" method="POST" action="/campus/add">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">F-SAO-0001</h4>
              </div>
              <div class="modal-body">
                
                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Venue</label>
                    <div class="col-sm-10">
                      <!-- <input type="text" name="venue" class="form-control" id="venue" placeholder="Venue"> -->
                       <select name="venue" class="form-control" id="venue">
                          <option value="">Choose</option>
                     
                          <option value="Academic Resource Center">Academic Resource Center</option>
                          <option value="Lpu Auditirium">Lpu Auditirium</option>
                          <option value="AVT">AVT</option>
                          <option value="Multi-purpose Hall<">Multi-purpose Hall</option>
                          <option value="Phase II lobby">Phase II lobby</option>
                          <option value="Roofdeck">Roofdeck</option>
                          <option value="CPAD Lobby">CPAD Lobby</option>

                          
                        </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Organizer</label>
                    <div class="col-sm-10">
                      <!-- <input type="text" name="organization" class="form-control" id="organization" placeholder="Organizer"> -->
                <select name="organization" id="organization" class="form-control">
                <option autofocus="" disabled selected >Select Organization</option>
                  @foreach ($organizations as $organization)
                  <option>{{$organization->organization }}</option>
                  
              
                
                  @endforeach
                  
                </select>

                      
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="color" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                      <select name="status" class="form-control" id="status">
                          <option value="">Choose</option>
                          <option style="color:#04803A;" value="OnProcess">OnProcess</option>
                          <option style="color:#3a87ad;" value="Reserved">Reserved</option>
<!--                           <option style="color:#9B0D0D;" value="Banned">Cancelled</option> -->
                          
                        </select>
                    </div>
                  </div>


      <div class="form-group">
        <label for="time" class="col-sm-2 control-label">Time</label>
        <div class="col-sm-10">
        <div class="input-group">
          <input type="text" class="form-control" name="time" id="time" placeholder="Select your time" value="{{ old('time') }}">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div>
        </div>


      </div>


<!--                   <div class="form-group">
                    <label for="start" class="col-sm-2 control-label">Start date</label>
                    <div class="col-sm-10">
                      <input type="text" name="start" class="form-control" id="start" > -->

                      <!-- readonly -->



<!--                     </div>
                  </div>

 -->


<!--                   <div class="form-group">
                    <label for="end" class="col-sm-2 control-label">End date</label>
                    <div class="col-sm-10">
                      <input type="text" name="end" class="form-control" id="end">
                    </div>
                  </div> -->



<!--                     <div class="form-group">
                    <label for="color" class="col-sm-2 control-label">Remark Status</label>
                    <div class="col-sm-10">
                      <select name="remark_status" class="form-control" id="remark_status">
                          <option value="">Choose</option>
                     
                          <option style="color:#FF0000;" value="Approved">&#9724; Approved</option>
                          <option style="color:#000;" value="#isapproved">&#9724; Disapproved</option>
                          
                        </select>
                    </div>
                  </div> -->

                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">CVF No.</label>
                    <div class="col-sm-10">
                      <input type="text" name="cvf_no" class="form-control" id="cvf_no" placeholder="CVF No." readonly>
                    </div>
                  </div>
                  <div class="form-group">

                               <label for="color" class="col-sm-2 control-label">S.Y.</label>
                               <div class="col-sm-10">
                                <select  name="school_year" id="school_year" class="form-control" readonly>
                                    @foreach ($schoolyear as $schoolyear)
                                    <option>{{$schoolyear->school_year }}</option>
                                    @endforeach

                                    @foreach ($schoolyears as $schoolyear)
                                    <option hidden>{{$schoolyear->school_year }}</option>
                                    @endforeach
                            
                                </select>
                  </div>          
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="addEvent_btn" id="addEvent_btn" class="btn btn-primary">Add Event</button>
              </div>
            </form>
            </div>
          </div>
        </div>
   
    </div>
     
        
        
        <!-- Modal -->
        <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form class="form-horizontal" id="updateEvent" method="POST" action="/campus/update">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="update_id" id="update_id">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Event</h4>
              </div>
              <div class="modal-body">
                
                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                    </div>
                  </div>

                  
                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Venue</label>
                    <div class="col-sm-10">
                      <!-- <input type="text" name="venue" class="form-control" id="venue" placeholder="Venue"> -->
                       <select name="venue" class="form-control" id="venue">
                          <option value="">Choose</option>
                     
                          <option value="Academic Resource Center">Academic Resource Center</option>
                          <option value="Lpu Auditirium">Lpu Auditirium</option>
                          <option value="AVT">AVT</option>
                          <option value="Multi-purpose Hall<">Multi-purpose Hall</option>
                          <option value="Phase II lobby">Phase II lobby</option>
                          <option value="Roofdeck">Roofdeck</option>
                          <option value="CPAD Lobby">CPAD Lobby</option>

                          
                        </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Organizer</label>
                    <div class="col-sm-10">
                      <!-- <input type="text" name="organization" class="form-control" id="organization" placeholder="Organizer"> -->
<!--                 <select name="organization" id="organization" class="form-control" readonly>
                <option autofocus="" disabled selected >Select Organization</option>
                  @foreach ($organizations as $organization)
                  <option>{{$organization->organization }}</option>
                  
              
                
                  @endforeach
                  
                </select> -->

                      <input type="hidden" id="organization" name="organization" class="form-control" autofocus="" aria-required="true">
                      <output type="text" name="organization1" class="form-control" id="organization1"></output>

                    
                    



                      
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="color" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                      <select name="status" class="form-control" id="status">
                          <option value="">Choose</option>
                          <option style="color:#04803A;" value="OnProcess">OnProcess</option>
                          <option style="color:#3a87ad;" value="Reserved">Reserved</option>
                          <option style="color:#9B0D0D;" value="Banned">Cancelled</option>
                          
                        </select>
                    </div>
                  </div>


      <div class="form-group">
        <label  class="col-sm-2 control-label">Time</label>
        <div class="col-sm-10">
        <div class="input-group">
          <input type="text" class="form-control" name="time" id="time" placeholder="Select your time" value="{{ old('time') }}">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div>
        </div>


      </div>

                  <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">CVF No.</label>
                    <div class="col-sm-10">
                      <output type="text" name="cvf_no" class="form-control" id="cvf_no" placeholder="CVF No." ></output>
                    </div>
                  </div>


<!--                     <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-10">
                          <div class="checkbox">
                            <label class="text-danger"><input type="checkbox"  name="delete"> Delete event</label>
                          </div>
                        </div>
                    </div> -->
                  
                  <input type="hidden" name="id" class="form-control" id="id">
                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="updateEvent_btn">Save changes</button>

              </div>
            </form>
            </div>
          </div>
        </div>

<!-- Mainly scripts -->
<!-- <script src="js/plugins/fullcalendar/moment.min.js"></script>
 -->

<!-- iCheck -->
<!-- <script src="js/plugins/iCheck/icheck.min.js"></script> -->

<!-- Full Calendar -->
<script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>

<script>

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

     console.log (json_events);
    
   },     error: function(response) { 
                     json_events = response;

     console.log (json_events);
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

     console.log (cvf_no);
    
   }      

});











        var calendar1 = $('#calendar').fullCalendar({
        
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,listMonth'
                // right: 'month,agendaWeek,agendaDay'
                
            },

            selectable: true,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectHelper: true,
            // events: json_events,
                eventSources: [
        json_events,   

        // [{
                    
        //              title: "Exam",
        //              venue: "Academic Resource Center",
        //               organization: "LYCESGO",
        //               remark_status:"Approved",
        //               start:"2016-10-19 22:01:41",
        //               status:"Available",
        //               title:"Research Day",
        //               venue:"Academic Resource Center",
        //         },]
        
    ],







         

// 			select: function(start, end) {
        
      


//     var check = start._d.toJSON().slice(0,10); 
//     var today = new Date().toJSON().slice(0,10);
//     if(check < today)
//     {
// alert("hello");
//     }
//     else
//     {
//   $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
//         $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
//         $('#ModalAdd').modal('show');
//     }

 // "maxDate": moment(start).add(1, 'day'),


     select: function(start, end, jsEvent, view) {

        $('input[name="time"]').daterangepicker({
    "minDate": moment(start).format('YYYY-MM-DD HH:mm A'),
    "maxDate": moment(end).format('YYYY-MM-DD HH:mm A'),



    "timePicker": true,
    "timePicker12Hour": true,
    "timePickerIncrement": 15,
    "startDate": moment(start).format('YYYY-MM-DD HH:mm A'),
    "endDate": moment(start).format('YYYY-MM-DD HH:mm A'),

    
    "autoApply": true,
    "locale": {

      "timePicker12Hour": true,
      "format": "YYYY-MM-DD HH:mm A",
      "separator": " - ",
    }
  });
            if (moment().diff(start, 'days') < -4) {
                $('#calendar').fullCalendar('unselect');
                $('#ModalAdd #time').val(moment(start).format('YYYY-MM-DD HH:mm A')+" - "+moment(start).format('YYYY-MM-DD HH:mm A'));
                  // $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm A'));
                  // $('#ModalAdd #end').val(moment(start).format('YYYY-MM-DD HH:mm: A'));
                   // $('#ModalAdd #cvf_no').val(moment(start).format('YYYY')+"-"+cvf_no);
                    $('#ModalAdd #cvf_no').val(cvf_no);

                  $('#ModalAdd').modal('show');
                   return false;


            }

//                 else
//     {
// $(this).css('backgroundColor','red');
//     }


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
        var start = (event.start.format("HH:mm A"));
        var end = event.end.format("HH:mm A");
        var back=event.backgroundColor;

        var tooltip = '<div class="tooltip-demo " style="width:230px;height:140px;color:black;background-color:white;border:2px solid black;padding-left: 10px;'+back+';position:absolute;z-index:10001;">'+'<b>Start:</b> '+ event.title +'<br>'+'<b>Venue:</b> '+event.venue+'<br>'+'<b>Organizer:</b> '+event.organization+'<br>'+'<b>status:</b> '+event.status+'<br>'+ '<b>Start:</b> '+start+'<br>'+ '<b>End: </b>'+ end  +'<br>'+'<b>cvf_no:</b> '+event.cvf_no+'<br>'+'</div>';


// '<b>Remark Status: </b>'+event.remark_status+'<br>'+
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
     /* id = id;
      start = start;
      end = end;*/
      var data =  console.log(JSON.stringify(Event));
    

      $.ajax({
         headers : {
        'X-CSRF-Token' : $('input[name="_token"]').val()
      },
       url: '/campus/update',
       type: "POST",
       data: {Event: data},
       success: function(data) {
 //calendar1.fullCalendar('updateEvent', Event);
 console.log(Event);
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
      // $('#calendar').fullCalendar().ajax.reload();
      // $('#calendar').fullCalendar().ajax.url('/get-events').load();

         // $('#calendar').fullCalendar( 'refetchEventsources'); 


       
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

         // $('#calendar').fullCalendar().ajax.reload();

  

      }
    });

 });







</script>
<style type = "text/css">

.fc-day.fc-widget-content.fc-sun { visibility: visible;
  opacity: 0.2;  background-color: gray !important;
}
.fc-day.fc-widget-content.fc-sun.fc-today.fc-state-highlight { visibility: visible;
  opacity: 0.2;  background-color: blue !important;
}




</style>


<link href="{{ url('_asset/css') }}/daterangepicker.css" rel="stylesheet">

<script src="{{ url('_asset/js') }}/daterangepicker.js"></script>
<!-- <script type="text/javascript">
$(function () {
  $('input[name="start"]').daterangepicker({
    "minDate": moment('<?php echo date('Y-m-d G')?>'),
    "timePicker": true,
    "timePicker12Hour": true,
    "timePickerIncrement": 15,

    
    
    "autoApply": true,
    "locale": {

      "timePicker12Hour": true,
      "format": "DD/MM/YYYY HH:mm A",
      "separator": " to ",
    }
  });
});
</script>
		 -->
<!-- HH:mm:ss -->

<!-- HH:mm A -->
 
@endsection


