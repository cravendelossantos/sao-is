@extends('layouts.master')

@section('title', 'SAO | Violation Statistics')

@section('header-page')
<div class="row">
  <div class="col-md-12">
   <h1>Violation Statistics</h1>
   <ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Student Violations Management
        </li>
        <li class="active">
            <strong>Statistics</strong>
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
        <input type="text" class="input-sm form-control" id="v_stats_from" name="v_stats_from" value="">

        <span class="input-group-addon">to</span>
        <input type="text" class="input-sm form-control"  id="v_stats_to" name="v_stats_to" value="">

      </div>
      <br>
      <button type="button" class="btn btn-w-m btn-primary" id="show_v_stats">Show</button>
    </div>
  </div>

  <div class="col-md-2">
    <div class="form-group">

      <output>School Year</output>
     
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
<!-- <button class="btn btn-outline btn-info  dim" id="print" type="button"><i class="fa fa-print"></i> </button> -->

<div class="ibox float-e-margins">
  <div class="ibox-title">

    <h5><b>Violation Statistics</b></h5>


    <button type="button" class="btn btn-primary btn-xs m-l-sm pull-right" id="print">Print</button>
    <button id="save" class="btn btn-primary  btn-xs m-l-sm pull-right" onclick="save()" type="button">Save</button>
    <button id="edit" class="btn btn-primary btn-xs m-l-sm pull-right" onclick="edit()" type="button">Edit</button>
<!--                             <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>

                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                              </div> -->
                            </div>
                          </div>






                          <div class="row">                         
                              <div class="col-md-12">
                              <div class="click2edit">
                              <div id="report_content">    
                                <div class="ibox float-e-margins">
                                  <div class="ibox-content">
                                    <div class="row">
                                      <div class="col-sm-12 text-center">
                                        <img src="/img/officialseal1.png"  class="pic1">

                                      </div>
                                    </div>
                                    <div class="row">

                                      <br><br>
                                      <div class="col-sm-12 text-center">
                                        <h5>Student Affair's Office</h5>
                                        <h5>Violation Statistics</h5>


                                      </div>


                                      <br>
                                    </div>


                                    <div class="row">
                                      <div class="form-group col-xs-6 text-left" id="report_ranges">

                                        <output id="report_from"></output>         
                                        <output id="report_to"></output>      

                                      </div>


                                      <div class="form-group col-xs-6 text-right">   
                                       <output id="date"></output>
                                       <output id="schoolyear"></output>  
                                     </div>
                                   </div>

              <br><br>


              <div class="row">

               <div class="col-md-10 col-md-offset-1">
                 <div id="visualization" class="" style="width: 900px; height: 400px; display: block; margin: auto;"></div>
                 <div class="table-responsive">



                  <!--                 <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"> -->



                  <table class="table table-striped table-bordered table-hover violation-stats-DT DataTable" id="violation-stats-DT" aria-describedby="DataTables_Table_0_info" role="grid" style="font-size: 10.2px; width: 100%;">
                           
                    <thead>

                      <th>CAMS</th>
                      <th>CAS</th>
                      <th>CBA</th>
                      <th>COECSA</th>
                      <th>CITHM</th>                              

                    </thead>



                  </table>
                  <!--       </div> -->
                </div>
              </div>
            </div>


            <br><br>
            <div class="row" style="bottom: -10; margin-left: 10px;">
              <label class="text-center" >Prepared by:</label><br><br> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br> {{ Auth::user()->roles->first()->name }} , Student Affairs Office
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

          </div>        </div>
        </div>
      </div>
  </div>
</div>
  

        <script src="/js/violation-statistics.js"></script>
        

@endsection

