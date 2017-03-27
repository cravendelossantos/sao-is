@extends('layouts.master')

@section('title', 'SAO | Lost and Found Reports')

@section('header-page')

<div class="row">
<div class="col-lg-12">
  <h1>Lost and Found Reports</h1>
  <ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Lost and Found
        </li>
        <li class="active">
            <strong>Reports</strong>
        </li>
  </ol>
</div>
</div>
<hr/>


<div class="row">
  <div class="col-md-6">
   <div class="form-group" id="LAF_stats_range">
    <output name="LAF_stats_range">Select date range:</output>

    <div class="input-daterange input-group" id="datepicker">

      <span class="input-group-addon">From</span>
      <input type="text" class="input-sm form-control" id="LAF_stats_from" name="LAF_stats_from" value="">

      <span class="input-group-addon">to</span>
      <input type="text" class="input-sm form-control"  id="LAF_stats_to" name="LAF_stats_to" value="">

    </div>
    <br>
    <button type="button" class="btn btn-w-m btn-primary" id="show_LAF_stats">Show</button>
  </div>
</div>

     <div class="col-md-2">


     <div class="form-group">

      
      <output name="v_reports_range">Filter</output>
        <select id="sort_by" name="sort_by"  class="form-control">
          <option value="">All</option>
          <option value="Unclaimed">Unclaimed</option>
          <option value="Claimed">Claimed</option>
          <option value="Donated">Donated</option>
        </select>

       
      
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

@endsection


@section('content')

<div class="ibox float-e-margins">
  <div class="ibox-title">

    <h5><b>Lost and Found Reports</b></h5>


    <button type="button" class="btn btn-primary btn-xs m-l-sm pull-right" id="print">Print</button>
    <button id="save" class="btn btn-primary  btn-xs m-l-sm pull-right" onclick="save()" type="button">Save</button>
    <button id="edit" class="btn btn-primary btn-xs m-l-sm pull-right" onclick="edit()" type="button">Edit</button>
                            </div>
                          </div>


                          <div class="row">
                            <div id="try" style="display:none">
                              <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                              </div>

                            </div>



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
                                        <h5>Lost and Found Reports</h5>


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

                                    <div class="row">


                                      <div class="col-sm-12 text-center">
                                        <output id="report_type"></output>
                                        
                                      </div>
                                    </div>


                                    <br><br>



                                    {!! csrf_field() !!}




    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="table-responsive">


            <table class="table table-striped table-bordered table-hover lost-and-found DataTable" id="lost-and-found" aria-describedby="DataTables_Table_0_info" role="grid" style="font-size: 10.2px; width: 100%;">

              <thead>
        
        <tr>
                  <th>Date Endorsed</th>
                  <th>Item Description</th>
                  <th>Found by</th>
                  <th>Founded at</th>
                  <th>Owner's Name</th>
                  <th>Status</th>
                  <th>Date Claimed</th>
                  <th>Claimed By</th>

          </tr> 
              </thead>

              

            </table>







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



<script src="/js/lost-and-found-reports.js"></script>



<style>
  .sk-spinner-wave.sk-spinner {
    margin: 0 auto;
    width: 50px;
    height: 30px;
    text-align: center;
    font-size: 10px;
    position: fixed;
    z-index: 999;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;

  }   

  #try{
   width: auto;
   height: auto;
   position: fixed;
   z-index: 999;
   overflow: show;
   margin: auto;
   top: 0;
   left: 0;
   bottom: 0;
   right: 0;
   background-color: #f3f3f4;
 } 
 #try2{
   width: auto;
   height: auto;
   position: fixed;
   z-index: 999;
   overflow: show;
   margin: auto;
   top: 0;
   left: 0;
   bottom: 0;
   right: 0;
   background-color:#f3f3f4;
 } 
</style>
@endsection
