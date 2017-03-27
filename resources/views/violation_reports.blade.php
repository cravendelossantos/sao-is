@extends('layouts.master')

@section('title', 'SAO | Violation Reports')

@section('header-page')

<div class="row">
  <div class="col-md-12">

  <h1>Violation Reports</h1>
    <ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Student Violations Management
        </li>
        <li class="active">
            <strong>Reports</strong>
        </li>
    </ol>  

    <hr/>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{ csrf_field() }}


    <div class="col-md-6">


    <div class="form-group" id="v_stats_range">
      <output name="v_stats_range">Select date range:</output>

      <div class="input-daterange input-group" id="datepicker">

        <span class="input-group-addon">From</span>
        <input type="text" class="input-sm form-control" id="v_reports_from" name="v_reports_from" value="">

        <span class="input-group-addon">to</span>
        <input type="text" class="input-sm form-control"  id="v_reports_to" name="v_reports_to" value="">

      </div>
      <br>
      <button type="button" class="btn btn-w-m btn-primary" id="show_v_reports">Show</button>
    </div>
  </div>

      <div class="col-md-2">
        <output name="v_reports_range">Offense level:</output>
        <select class="form-control" name="v_reports_offense_level" id="v_reports_offense_level">
          <option value="">All</option>
          <option value="Less Serious">Less Serious Offenses</option>
          <option value="Serious">Serious Offenses</option>
          <option value="Very Serious">Very Serious Offenses</option>
        </select>

          <output name="v_reports_range">College:</output>
            <select class="form-control" id="college" name="college">
              <option autofocus="" selected value="">Select course</option>
              @foreach ($colleges as $college)
              <option value="{{ $college->id }}">{{$college->description}}</option>
              @endforeach

            </select>

      </div>

             <div class="col-md-2">
              <output name="v_reports_range">Course</output>
            <select class="form-control" id="course" name="course">
              <option autofocus="" selected value="">Select course</option>
              @foreach ($courses as $course)
              <option value="{{ $course->description }}" >{{$course->description}}</option>
              @endforeach

            </select>

            <div class="form-group">

              <output name="v_reports_range">School Year:</output>
                @if (is_null($current_school_year) || is_null($school_year_selection))
                  <div class="alert alert-danger">
                    School year is not set. Click <a class="alert-link" href="/settings/dates/school-year">here</a> to manage dates.
                  </div>
                @else
                  <select name="school_year" id="school_year" class="form-control">
                    
                      <option>{{ $current_school_year }}</option>
                    

                    @foreach ($school_year_selection as $selection)
                      <option>{{ $selection->school_year }}</option>
                    @endforeach
                  </select> 
                @endif
      
          </div>
      </div>


    
    

  


  </div>
</div>

@endsection


@section('content')

<div class="ibox float-e-margins">
  <div class="ibox-title">

    <h5><b>Violation Reports</b></h5>


    <button type="button" class="btn btn-primary btn-xs m-l-sm pull-right" id="print">Print</button>
    <button id="save" class="btn btn-primary  btn-xs m-l-sm pull-right" onclick="save()" type="button">Save</button>
    <button id="edit" class="btn btn-primary btn-xs m-l-sm pull-right" onclick="edit()" type="button">Edit</button>

                        </div>
                    </div>


<div class="row" id="report_content">
  <div class="col-lg-12">


<div class="click2edit">
    <div class="ibox float-e-margins">
      <div class="ibox-content p-xl">

      <div class="row">
        <div class="col-sm-12 text-center">
          <img src="/img/officialseal1.png"  class="pic1">

        </div>
      </div>
      <div class="row">

        <br><br>
        <div class="col-sm-12 text-center">
          <h5>Student Affair's Office</h5>
          <h5>Student Violation Reports</h5>


        </div>


        <br>
      </div>




         <div class="row">
          <div class="form-group col-xs-6 text-left">
       
          <output id="report_from"></output>         
          <output id="report_to"></output>      
           
            </div>
        <div class="form-group col-xs-6 text-right">   
          <output id="date"></output>
          <output id="schoolyear"></output>  
        </div>




            </div>
            <div class="row">


              <div class="col-sm-12 text-center">
                <output id="report_type"></output>
                <output id="report_group"></output>

              </div>
            </div>


        
        <div class="row">

          <div class="col-md-10 col-md-offset-1">
            <div class="table-responsive">


<!-- 
          <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

 -->
            <br>
            <table class="table table-striped table-bordered table-hover violation-reports-reports-DT DataTable" id="violation-reports-reports-DT" aria-describedby="DataTables_Table_0_info" role="grid" style="font-size: 10.2px; width: 100%;">

              <thead>
                <tr>
                  <th>Name</th>
<!--                   <th>Last Name</th> -->
                  <th>Course</th>
<!--                   <th>Complainant</th> -->
                  <th>Date Reported</th>
                  <th>Offense</th>
                  <th>Offense No</th>
                  <th>Description</th>  
                </tr>

              </thead>



            </table>

        </div>
        </div>
        </div>
        <br><br>
<div class="row" style="bottom: -10; margin-left: 10px;">
  <label class="text-center" >Prepared by:</label><br><br> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br> {{ Auth::user()->roles->first()->description }} , Student Affairs Office
</div>
<br>

@foreach ($signees as $signee)
  @if ($signee->hasRole('Admin') and $signee->id != Auth::user()->id)
<div class="row"   style="bottom: -10; margin-left: 10px;">
  <label class="text-center">Noted by:</label><br><br>
  
  {{ $signee->first_name }} {{ $signee->last_name }}
  <br>
  {{ $signee->roles->first()->description }}, Student Affairs Office
</div>
<br>
@else
@endif

@endforeach


      </div>
    </div>
  </div>
</div>
</div>
  

    <script src="/js/violation-reports.js"></script>

@endsection