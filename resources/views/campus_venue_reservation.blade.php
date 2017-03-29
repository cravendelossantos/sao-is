@extends('layouts.master')


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


<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">

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


          <div class="form-group">
            <label for="title" class="col-sm-2 control-label">CVF No.</label>
            <div class="col-sm-10">
              <input type="text" name="cvf_no" class="form-control" id="cvf_no" placeholder="CVF No." readonly>
            </div>
          </div>
          <div class="form-group">

           <label for="color" class="col-sm-2 control-label">S.Y.</label>
           <div class="col-sm-10">



            @if (is_null($current_school_year))

            <div class="alert alert-danger">
              School year is not set. Click <a class="alert-link" href="/settings/dates/school-year">here</a> to manage dates.
            </div>

            @else

            <output id="school_year" name="school_year" class="form-control" autofocus=""   aria-required="true" >
              {{ $current_school_year }}
            </output>

            <input type="hidden" id="school_year" name="school_year" class="form-control" autofocus="" aria-required="true" value="{{ $current_school_year }}">
            @endif

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

<script src="/js/campus-venue-reservation.js"></script>

<style type = "text/css">

  .fc-day.fc-widget-content.fc-sun { visibility: visible;
    opacity: 0.2;  background-color: gray !important;
  }
  .fc-day.fc-widget-content.fc-sun.fc-today.fc-state-highlight { visibility: visible;
    opacity: 0.2;  background-color: blue !important;
  }




</style> 
@endsection


