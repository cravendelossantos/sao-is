@extends('layouts.master')

@section('title', 'SAO | Locker Management')

@section('header-page')
<div class="row">
<div class="col-lg-8">
	<h1>Locker Assignment</h1>
	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Locker Management
        </li>
        <li class="active">
            <strong>Locker Assignment</strong>
        </li>
	</ol>
</div>

<div class="col-md-2 col-md-offset-1 title-action">
	<button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#contractModal"><i class="fa fa-print"></i>&nbsp; Print Contract Copy</button>
</div>
</div>
@endsection


@section('content')


<div id="lockers_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">Update Locker</h4>
				
			</div>

			<div class="ibox-content">
				<form class="form-horizontal" id="locker_status_update" > 
					{!! csrf_field() !!}
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="text-center">	<p>Current Status:
						<strong><output name="m_current_status" id="m_current_status">
						</output></strong></p></div>

						<div class="form-group">

							<div class="col-md-10 col-md-offset-1">
								<label class="control-label">Locker no</label>
								<input type="hidden" name="_m_locker_no" id="_m_locker_no">
								<output class="form-control" name="m_locker_no" id="m_locker_no"></output>
								<span class="help-block m-b-none text-danger"></span>
							</div>

						</div>


				<!-- 	<div class="form-group">
						
						<div class="col-md-10 col-md-offset-1">
						<label class="control-label">Location</label>
							<input class="form-control" name="m_location" id="m_location">
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div> -->

					<div class="form-group">

						<div class="col-md-10 col-md-offset-1">

							<label class="control-label">Update status</label><br>
							<select class="form-control" name="m_update_status" id="m_update_status">
								<option disabled="" selected="">Update Status</option>
								<option value="1">Available</option>
								<option value="2">Occupied</option>
								<option value="3">Damaged</option>
								<option value="4">Locked</option>

							</select>
							
							<br>
							<div id="occupancy_div">		
								<div>
									<input type="text" class="form-control" placeholder="Name of Lessee" name="m_lessee_name" id="m_lessee_name" style="text-transform: capitalize;">
								</div>
								<br>
								<div>
									<input type="text" class="form-control" placeholder="Lessee ID No." name="m_lessee_id" id="m_lessee_id">
								</div>
								<br>
								<select class="form-control" name="contract" id="contract">

									<option disabled="" selected="">Select Contract</option>
									@foreach ( $dates as $date )
									<option value="{{ $date->id }}">{{ $date->term_name }} ( S.Y - {{ $date->school_year }})</option>
									@endforeach
								</select>

								<span class="help-block m-b-none text-danger"></span>
							</div>
						</div>
					</div>





				</div>

				<div class="modal-footer">
					<button class="ladda-button btn btn-w-m btn-primary claimItem" id="locker_update" type="button">
						<strong>Save</strong>
					</button>
					<button type="button" class="btn btn-w-m btn-danger"
					data-dismiss="modal">
					<strong>Cancel</strong>
				</button>
			</form>
		</div>
	</div>

</div>
</div>


<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="contractModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Print Contract</h4>
      </div>
      <div class="modal-body">


<div id="locker_contract" style="">

	<textarea>{!! $content->value !!}</textarea>

</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<div class="row">

	<div class="col-lg-12">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h2>Add Lockers</h2>
				<div class="ibox-tools">

				</div>
			</div>
			<div class="ibox-content">

				<form role="form" id="add_locker_form" method="POST" action="/lockers/add">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group ">
								<label>No of lockers</label>
								<input type="number" placeholder="No of Lockers" name="no_of_lockers" id="no_of_lockers" class="form-control" autofocus="" aria-required="true">
							</div>
						</div>

						<div class="col-md-6">


							<div class="form-group">

								<label>Location</label>
								<select name="location" id="location" class="form-control">
									<option selected="" disabled="">Select Location</option>
									@foreach($locations as $location)

									<option value="{{ $location->id }}">{{ $location->building }} Building {{ $location->floor }} Floor </option>
									@endforeach
								</select>


							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group ">
								<label>Locker number</label>
								<input type="number" placeholder="From" name="from" id="from" class="form-control" autofocus="" aria-required="true">
							</div>
							<div class="form-group ">
								<input type="number" placeholder="To" name="to" id="to" class="form-control" autofocus="" aria-required="true" readonly="">
							</div>
						</div>






						


					</div>

				</div>

				<div class="ibox-footer">
					<button class="btn btn-w-m btn-primary" id="add_locker_btn" type="button">
						<strong>Save</strong>
					</button>
					<button class="btn btn-w-m btn-danger" id="add_locker_cancelBtn" type="button">
						<strong>Cancel</strong>
					</button>
					<input type="hidden" value="{{Session::token()}}" name="_token">
				</form>
			</div>

		</div>

	</div>
</div>


<div class="row">
	<div class="col-lg-12">
			<div class="ibox float-e-margins">

				<div class="ibox-title">
					<h2>Lockers</h2>
					
				</div>
				<div class="ibox-content" id="table-content">
				<div class="row">
						<div class="form-group">

							<div class="col-md-6">

								<output>Status</output>
								<select id="status_sort" name="status_sort"  class="form-control">
									<option value="">All</option>
									<option value="Available">Available</option>
									<option value="Occupied">Occupied</option>
									<option value="Damaged">Damaged</option>
									<option value="Locked">Locked</option>
								</select>
							</div>

							<div class="col-md-6">
								<output>Location</output>
								<select name="location_sort" id="location_sort" class="form-control">
									<option value="">All</option>
									@foreach($locations as $location)

									<option value="{{ $location->id }}">{{ $location->building }} Building {{ $location->floor }} Floor </option>
									@endforeach
								</select>
							</div>
							

					</div>
</div>
<br>
					
						<div class="table-responsive">
							
						<table class="table table-striped table-bordered table-hover dataTable" id="lockers-DT" width="100%">
									<thead>

										<th>Locker no</th>
										<th>Floor</th>
										<th>Building</th>
										<th>Status</th>
										<th>Lessee</th>
										<th>Action</th>
	


									</thead>



								</table>
							
						
					</div>
				</div>
			</div>
		</div>
	</div>	



	<script src="/js/locker-management.js"></script>
	<script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>
	<script src="/js/tinymce/js/tinymce/jquery.tinymce.min.js"></script>


    <style>
    	
    	.locker-damaged{
    		height: 120px;
    		width: 75px;
    		margin-left: 20px;
    		background-color: red;
    	}


    	.locker-available{
    		height: 120px;
    		width: 75px;
    		margin-left: 20px;
    		background-color: green;
    	}

    	.locker-occupied{
    		height: 120px;
    		width: 75px;
    		margin-left: 20px;
    		background-color: blue;
    	}

    	.text-line {
    		background-color: transparent;
    		width: 230px;
    		color: black;
    		outline: none;
    		outline-style: none;
    		border-top: none;
    		border-left: none;
    		border-right: none;
    		border-bottom: solid #eeeeee 1px;
    		padding: 3px 10px;
    	}

</style>
@endsection