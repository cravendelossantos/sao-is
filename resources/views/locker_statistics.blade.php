@extends('layouts.master')

@section('title', 'SAO | Locker Statistics')

@section('header-page')
<div class="row">
<div class="col-lg-12">
	<h1>Locker Statistics</h1>
	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Locker Management
        </li>
        <li class="active">
            <strong>Statistics</strong>
        </li>
	</ol>
</div>
</div>
<hr/>
<div class="row">
	<div class="col-md-6">
		<div class="form-group" id="locker_reports_range">
			<output name="LAF_stats_range">Select date range:</output>

			<div class="input-daterange input-group" id="datepicker">

				<span class="input-group-addon">From</span>
				<input type="text" class="input-sm form-control" id="locker_reports_from" name="locker_reports_from" value="">

				<span class="input-group-addon">to</span>
				<input type="text" class="input-sm form-control"  id="locker_reports_to" name="locker_reports_to" value="">

			</div>
			<br>
			<button type="button" class="btn btn-w-m btn-primary" id="show_locker_reports">Show</button>
		</div>
	</div>

		     <div class="col-md-2">
        <div class="form-group" id="v_reports_range">
 <output>School Year</output>
          @if (is_null($current_school_year) || is_null($school_year_selection))
        <div class="alert alert-danger">
          School year is not set. Click <a class="alert-link" href="/settings/dates/school-year">here</a> to manage dates.
        </div>
      @else
       		<output id="school_year1" name="school_year1" class="form-control" autofocus="" 	aria-required="true" >
				{{ $current_school_year }}
			</output>
      @endif
        </div>
      </div>


</div>

@endsection


@section('content')

<div class="ibox float-e-margins">
	<div class="ibox-title">

		<h5><b>Locker Statistics</b></h5>


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

                    	<div  id="report_content">
                    		<div class="col-md-12">
                    			<div class="click2edit">
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
					<h5>Locker Availability</h5>


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
				</div>
			</div>


			<br><br>



			{!! csrf_field() !!}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">





			<div id="visualization" class="" style="width: 900px; height: 400px; display: block; margin: auto;"></div>
		


			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<center><div class="table-responsive">



						<!-- <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"> -->



						<table class="table table-striped table-bordered table-hover locker-reports-DT DataTable" id="asd" aria-describedby="DataTables_Table_0_info" role="grid" style="font-size: 10.2px; width: 100%;">

							<thead>
								<tr>
									<th>No. of Lockers</th>
									<th>Available</th>
									<th>Occupied</th>
									<th>Damaged</th>
									<th>Locked</th>
									
								</tr>

							</thead>



						</table>
<!-- 
</div> -->
</div></center>
</div>
</div>


<div class="row" style="bottom: -10; margin-left: 10px;">
	<label class="text-center" >Prepared by:</label><br><br> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br> {{ Auth::user()->roles->first()->name }} , Student Affairs Office
</div>
<br>
<div class="row"   style="bottom: -10; margin-left: 10px;">
	<label class="text-center">Noted by:</label><br><br> Ms. Lourdes C. Reyes <br>Head, Student Affairs Office 
</div>

</div>        </div>
</div>
</div>
</div>
</div>




<script src="/js/locker-statistics.js"></script>

@endsection