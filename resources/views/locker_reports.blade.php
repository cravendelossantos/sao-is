@extends('layouts.master')

@section('title', 'SAO | Locker Reports')

@section('header-page')

<div class="row">
<div class="col-lg-12">
	<h1>Locker Reports</h1>
	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Locker Management
        </li>
        <li class="active">
            <strong>Reports</strong>
        </li>
	</ol>
</div>
</div>
<hr/>
<div class="row">


      							<div class="col-md-2">

								<output>Status</output>
								<select id="status_sort" name="status_sort"  class="form-control">
									<option value="">All</option>
									<option value="Available">Available</option>
									<option value="Occupied">Occupied</option>
									<option value="Damaged">Damaged</option>
									<option value="Locked">Locked</option>
								</select>
							</div>
							<div class="col-md-2">
								<output>Location</output>
								<select name="location_sort" id="location_sort" class="form-control">
									<option value="">All</option>
									@foreach($locations as $location)

									<option value="{{ $location->id }}">{{ $location->building }} Building {{ $location->floor }} Floor </option>
									@endforeach
								</select>
							</div>
										     <div class="col-md-2">
        <div class="form-group" id="v_reports_range">
 <output>School Year</output>
          @if (is_null($current_school_year) || is_null($school_year_selection))
        <div class="alert alert-danger">
          School year is not set. Click <a class="alert-link" href="/settings/dates/school-year">here</a> to manage dates.
        </div>
      	@else
       		<output id="school_year1" name="school_year1" class="form-control" autofocus="" aria-required="true" >
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

		<h5><b>Locker Report</b></h5>


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
<!-- 			<div class="row">
				<button class="btn btn-outline btn-info  dim" id="print" type="button"><i class="fa fa-print"></i> </button>
				<div class="col-sm-12 text-center">
					<h1>Locker Reports and Statistics</h1>


				</div>

			</div> -->


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
					<output id="schoolyear"></output>    
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 text-center">
                    <output id="report_type"></output>
                                        
     		</div>


			<br><br>



			{!! csrf_field() !!}




			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<center><div class="table-responsive">


							<!-- <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"> -->

								<table class="table table-striped table-bordered table-hover lockers1-DT dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid" style="font-size: 10.2px; width: 100%;">
									<thead>

										<th>Locker no</th>
										<th>Floor</th>
										<th>Building</th>
										<th>Lessee</th>
										<th>Status</th>




									</thead>



								</table>
						<!-- 	</div> -->
</div></center>
</div>
</div>
<br><br><br>

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

<script src="/js/locker-reports.js"></script>

@endsection