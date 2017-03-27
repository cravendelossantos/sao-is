@extends('layouts.master')

@section('title', 'SAO | Date Settings')

@section('header-page')
<div class="row">
<div class="col-lg-12">
    <h1>Date Settings</h1>
    <ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Settings
        </li>
        <li class="active">
            <strong>Date Settings</strong>
        </li>
    </ol>
    </div>
</div>
@endsection


@section('content')
<div class="row">

	<div class="col-md-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h2>Set School Year</h2>
			
			</div>
			<div class="ibox-content">
			<form id="sy_form">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					{{ csrf_field() }}

			<div class="form-group" id="first_sem_range">



                 <output>School Year (ex. 2016-2017)</output>  
				<input type="text" class="form-control" id="school_year" name="school_year">
        <!--         <output>Starting Year (ex. 2016)</output>  
                
                <input type="text" class="form-control " id="year" name="year"> -->

                                <output name="first_sem">First Semester</output>
                                <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">From</span>
                                    <input type="text" class="input-sm form-control" name="first_semester_start_date" value="">
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name="first_semester_end_date" value="">
                                </div>
                            </div>



                            	<div class="form-group" id="second_sem_range">
                                <output name="second_sem">Second Semester</output>
                                <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">From</span>
                                    <input type="text" class="input-sm form-control" name="second_semester_start_date" value="">
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name="second_semester_end_date" value="">
                                </div>
                            </div>


                                <div class="form-group" id="summer_range">
                                 <output name="summer">Summer</output>
                                <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">From</span>
                                    <input type="text" class="input-sm form-control" name="summer_start_date" value="">
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name="summer_end_date" value="">
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary" id="sy_date_btn">Set</button>
</form>
                                </div>
                            </div>
                                </div>
                            </div>




<div class="row"> 
<div class="col-md-12 animated fadeInRight"> 
<div class="ibox float-e-margins">
<div class="ibox-title">
    <h5>School Years</h5>
</div>
<div class="ibox-content">

                            <div class="table-responsive">



                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">



                        <table class="table table-striped table-bordered table-hover school-year-DT dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">

                            <thead>
 
                <tr>
                                    <th>School Year</th>
                                    <th>Description</th>
                                    <th>Start</th>
                                    <th>End</th>

                    </tr>   
                            </thead>

                            

                        </table>

                    </div>
                </div>
                </div>
</div>
</div>
</div>


@endsection

