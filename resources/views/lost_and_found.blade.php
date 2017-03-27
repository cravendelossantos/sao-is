@extends('layouts.master')

@section('title', 'SAO | Add or Claim Items')

@section('header-page')
<div class="row">

	<div class="col-md-12">
		<h1>Lost and Found</h1>

		<ol class="breadcrumb">
        	<li>
            	 <a href="/home">Home</a>
        	</li>
        	<li>
            	Lost and Found
        	</li>
        	<li class="active">
            	<strong>Add or Claim Items</strong>
        	</li>
		</ol>
	</div>

</div>

@endsection

@section('content')
<div id="LAF_Modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">Claim Item</h4>
			</div>

			<div class="ibox-content">
				<form class="form-horizontal suggestTopic" id="claim_item">
					{!! csrf_field() !!}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="claim_id" id="claim_id">


					<div class="form-group claimItem">
						
						<div class="col-md-10 col-md-offset-1">
						<label class="control-label">Date Reported</label>
							<output class="form-control" name="_date-reported" id="_date-reported"></output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>


					<div class="form-group claimItem">
						
						<div class="col-md-10 col-md-offset-1">
						<label class="control-label">Item</label>
							<output class="form-control" name="item_description" id="item_description"></output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>

					<div class="form-group claimItem">
						
						<div class="col-md-10 col-md-offset-1">
						<label class="control-label">Owner Name</label>
							<output class="form-control" name="owner_name" id="owner_name"></output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>


					<div class="form-group claimItem">
						
						<div class="col-md-10 col-md-offset-1">
						<label class="control-label">Endorsed by</label>
							<input type="text" class="form-control" name="endorser_name" id="endorser_name">
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>


					<div class="form-group claimItem">
						
						<div class="col-md-10 col-md-offset-1">
						<label class="control-label">Claimer Name</label>
								<input type="text" placeholder="Claimer Name" name="claimer_name" id="claimer_name" class="form-control" autocomplete="off" style="text-transform: capitalize;">
							<label id="claimer_name_error" class="error"></label>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>

	
							
			</div>

			<div class="modal-footer">
				<button class="ladda-button btn btn-w-m btn-primary claimItem" id="claim_btn" type="button">
					<strong>Claim</strong>
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

<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h2>Report Lost Item</h2>
				<div class="ibox-tools">

				</div>
			</div>
			<div class="ibox-content">

				<form role="form" id="reportLostItem">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group ">
								<label>Item Description</label>
								<input type="text" placeholder="Item Description" name="itemName" class="form-control" autofocus="" aria-required="true" style="text-transform: capitalize;">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Name's Found,if any</label>
								<input type="text" placeholder="Name's Found" name="ownerName" class="form-control" style="text-transform: capitalize;">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Endorsed by</label>
								<input type="text" autocomplete="off"  placeholder="Endorser's name" name="endorserName" class="form-control" style="text-transform: capitalize;">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Found at</label>
								<input type="text" placeholder="Found at" name="foundAt" class="form-control" style="text-transform: capitalize;">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Distinctive Marks</label>
								<textarea  style="text-transform: capitalize;" name="distinctive_marks" id="distinctive_marks" placeholder="Item Distinctive Marks" class="form-control"></textarea>
							</div>
						</div>

						<div class="col-md-6">
<div class="form-group">

								<label>School Year</label>

									@if (is_null($current_school_year))

									<div class="alert alert-danger">
                                		School year is not set. Click <a class="alert-link" href="/settings/dates/school-year">here</a> to manage dates.
                           			</div>

									@else
									
									<output id="school_year1" name="school_year1" class="form-control" autofocus="" 	aria-required="true" >
									{{ $current_school_year }}
									</output>
									
									<input type="hidden" id="school_year" name="school_year" class="form-control" autofocus="" aria-required="true" value="{{ $current_school_year }}">
									@endif

						</div>
						</div>

						<div class="col-md-3">
						<div class="form-group" id="LAF_date_picker">
								<label>Date Reported</label>
								<div class="input-group date" id="data_1">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" id="date_reported" name="date_reported" class="form-control">
								</div>
							</div>
						</div>

				

						<div class="col-md-3">
							<div class="form-group">
								<label>Time Reported</label>
								<div class="input-group clockpicker time_reported" data-autoclose="true">
									<input type="text" class="form-control" value="" name="time_reported" id="time_reported">
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							</div>
						</div>

						


					</div>

			</div>

			<div class="ibox-footer">
				<button class="btn btn-w-m btn-primary" id="lost_and_found_reportBtn" type="button">
					<strong>Save</strong>
				</button>
				<button class="btn btn-w-m btn-danger" id="lost_and_found_cancelBtn" type="button">
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

				<h2>Lost and Founds</h2>

			</div>


			<div class="ibox-content" id="table-content">
												<div class="form-group">
				<select id="sort_by" name="sort_by"  class="form-control">
					<option>All</option>
					<option>Unclaimed</option>
					<option>Claimed</option>
					<option>Donated</option>
				</select>




</div>

				<div class="table-responsive">



					<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">



						<table class="table table-striped table-bordered table-hover lost-and-found-DT dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">

							<thead>
				<tr><th colspan="10"><center>Claiming Period: Within 60 days from the date of endorsement to SAO</center></th></tr>
				<tr>
									<th>Date Endorsed</th>
									<th>Time</th>
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
		</div>
	</div>
</div>

<script src="/js/lost-and-found.js"></script>

<style>
#distinctive_marks { 
   resize: none;
   height: 107px;
}

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>
@endsection

