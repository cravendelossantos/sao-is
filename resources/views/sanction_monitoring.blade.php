@extends('layouts.master')

@section('title', 'SAO | Sanction Monitoring')

@section('header-page')
<div class="row">
	<div class="col-md-12">
		<h1>Sanction Monitoring</h1>
		<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Sanctions
        </li>
        <li class="active">
            <strong>Sanctions Monitoring</strong>
        </li>
	</ol>
	</div>
</div>
@endsection

@section('content')


<div class="row">
	<div class="col-md-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-content">

				<div class="row">
					<div class="col-md-6">
						{!! csrf_field() !!}
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

					</div>
				</div>
				<div class="panel blank-panel">

					<div class="panel-heading">

						<div class="panel-title m-b-md">

						</div>
						<div class="panel-options">

							<ul class="nav nav-tabs">
								<li class="active">
									<a data-toggle="tab" href="#tab-1">Manage Sanctions</a>
								</li>
								<li class="">
									<a data-toggle="tab" href="#tab-2">Community Service</a>
								</li>
								<li class="">
									<a data-toggle="tab" href="#tab-3">Suspensions</a>
								</li>
								<li class="">
									<a data-toggle="tab" href="#tab-4">Exclusions</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="panel-body">

						<div class="tab-content">
							<div id="tab-1" class="tab-pane active">

								<form id="sanctions_form">
									<label>Enter Student Number</label>

									<div class="input-group">

										<input type="text" id="sanction_student_no" name="sanction_student_no" class="form-control">
										<span class="input-group-btn">
											<button type="button" id="sanction_find_student" class="btn btn-info">
												<i class="fa fa-search"></i>
											</button> </span>
									</div>
									<div class="table-responsive">
										<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

											<table class="table table-striped table-bordered table-hover sanctions-DT dataTable" id="sanctions-DT" aria-describedby="DataTables_Table_0_info" role="grid">
												<thead>
													<tr>
														<th colspan="10">
														<center>
															Click the row to update its sanction
														</center></th>
													</tr>
													<tr>

														<th>Date Committed</th>
														<th>Student No.</th>
														<th>Student Name</th>
														<th>Violation ID</th>
														<th>Violation Description</th>
														<th>Offense Level</th>
														<th>Offense Number</th>
														<th>Sanction</th>
														<th>Status</th>
													</tr>
												</thead>

											</table>
										</div>
									</div>
								</form>
							</div>

							<div id="tab-2" class="tab-pane">
								<div class="tab-content">
								<label>Enter Student Number</label>

								<div class="input-group">

									<input type="text" name="cs_student_no" class="form-control">
									<span class="input-group-btn">
										<button type="button" id="cs_find_student" class="btn btn-info">
											<i class="fa fa-search"></i>
										</button> </span>
								</div>

								<br>

								<div class="panel panel-primary">
									<div class="panel-heading">
										<h4>Time Log</h4>
									</div>
									<div class="panel-body">
										<form id="time_log">

											<div class="col-md-6">
												<div class="form-group">
													<label>Student No.</label>
													<output name="time_log_student_no" id="time_log_student_no" placeholder="" ></output>
													<input type="hidden" name="_time_log_student_no" id="_time_log_student_no">
													<!-- <output name="course" id="course"></output> -->
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Name</label>
													<output name="time_log_student_name" id="time_log_student_name" placeholder="" ></output>
													<!-- <output name="course" id="course"></output> -->
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Violation ID</label>
													<output name="time_log_violation_id" id="time_log_violation_id" placeholder="" ></output>
													<input type="hidden" name="_time_log_violation_id" id="_time_log_violation_id">
													<!-- <output name="course" id="course"></output> -->
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Community Service ID</label>
													<input type="hidden" name="_time_log_cs_id" id="_time_log_cs_id">
													<output name="time_log_cs_id" id="time_log_cs_id" placeholder="" ></output>
													<!-- <output name="course" id="course"></output> -->
												</div>
											</div>

											<div class="col-md-6">
												<label>Date</label>
												<div class="input-group date" id="time_log">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="log_date" name="log_date" class="form-control">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Required Hours</label>
													<input type="text" class="form-control" name="time_log_required_hours" id="time_log_required_hours" placeholder="" style="font-size: 12px;" disabled="">
													<!-- <output name="course" id="course"></output> -->
												</div>
											</div>

											<div class="col-md-6">
												<label>Time in</label>
												<div class="input-group clockpicker time_in" data-autoclose="true">
													<input type="text" class="form-control" value="" name="time_in" id="time_in">
													<span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
												</div>

											</div>

											<div class="col-md-6">
												<label>Time out</label>
												<div class="input-group clockpicker time_out" data-autoclose="true">
													<input type="text" class="form-control" value="" name="time_out" id="time_out">
													<span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
												</div>

											</div>
									</div>

									<div class="panel-footer">
										<button class="btn btn-primary " name="time_log_btn" id="time_log_btn" type="button">
											<i class="fa fa-check"></i>&nbsp;Submit
										</button>
									</div>

								</div>
								</form>
								
									<div class="table-responsive">

										<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

											<table class="table table-striped table-bordered table-hover CS-DT dataTable" id="CS-DT" aria-describedby="DataTables_Table_0_info" role="grid">
												<thead>

													<tr>
														<th>Student No.</th>
														<th>Violation ID</th>
														<th>Number of Days</th>
														<th>Number of Hours</th>
														<th>Status</th>

													</tr>
												</thead>

											</table>
										</div>
									</div>
								</div>
							</div>

							<div id="tab-3" class="tab-pane">
								<div class="tab-content">
									<div class="table-responsive center">
										<label>Enter Student Number</label>

										<div class="input-group">

											<input type="text" name="suspensions_student_no" class="form-control">
											<span class="input-group-btn">
												<button type="button" id="suspensions_student_find" class="btn btn-info">
													<i class="fa fa-search"></i>
												</button> </span>
										</div>
										<br>
										<div class="panel panel-primary">
											<div class="panel-heading">
												<h4>Suspension Log</h4>
											</div>

											<div class="panel-body">

												<form id="suspension_log">

													<div class="col-md-6">
														<div class="form-group">
															<label>Student No.</label>
															<output name="suspension_log_student_no" id="suspension_log_student_no" placeholder="" ></output>
															<input type="hidden" name="_suspension_log_student_no" id="_suspension_log_student_no">

														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label>Name</label>
															<output name="suspension_log_student_name" id="suspension_log_student_name" placeholder="" ></output>

														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label>Violation ID</label>
															<output name="suspension_log_violation_id" id="suspension_log_violation_id" placeholder="" ></output>
															<input type="hidden" name="_suspension_log_violation_id" id="_suspension_log_violation_id">

														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label>Status</label>
															<output name="suspension_log_status" id="suspension_log_status" placeholder="" ></output>

														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label>Suspension ID</label>
															<output name="suspension_log_suspension_id" id="suspension_log_suspension_id" placeholder="" ></output>
															<input type="hidden" name="_suspension_log_suspension_id" id="_suspension_log_suspension_id">
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label>Required Days</label>
															<output name="suspension_log_required_days" id="suspension_log_required_days" placeholder="" ></output>

														</div>
													</div>

													<div class="col-md-12">
														<div class="form-group">
															<label>Suspension Days</label>
															<input type="text" id="all_suspension_dates" name="all_suspension_dates" class="form-control">

														</div>
													</div>

											</div>

											<div class="panel-footer">
												<button class="btn btn-primary " name="suspension_log_btn" id="suspension_log_btn" type="button">
													<i class="fa fa-check"></i>&nbsp;Submit
												</button>
											</div>
											</form>
										</div>

										<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

											<table class="table table-striped table-bordered table-hover suspensions-DT dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
												<thead>
													<tr>
														<th colspan="4">
														<center>
															List of Suspended Students
														</center></th>
													</tr>
													<tr>
														<th>Student No.</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Status</th>
													</tr>

												</thead>

											</table>

										</div>
									
									</div>
								</div>

							</div>

							<div id="tab-4" class="tab-pane">
								<div class="tab-content">
									<div class="table-responsive center">
										<label>Enter Student Number</label>

										<div class="input-group">

											<input type="text" name="suspensions_student_no" class="form-control">
											<span class="input-group-btn">
												<button type="button" id="suspensions_student_find" class="btn btn-info">
													<i class="fa fa-search"></i>
												</button> </span>
										</div>
										<br>

										<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

											<table class="table table-striped table-bordered table-hover exclusion-DT dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
												<thead>

													<tr>
														<th colspan="4">
														<center>
															List of Excluded Students
														</center></th>
													</tr>
													<tr>
														<th>Student No.</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Status</th>
													</tr>

												</thead>

											</table>
										</div>
									</div>
								</div>

							</div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Sanctions Modal -->

<div id="sanction_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">Update Sanction Status</h4>
			</div>

			<div class="ibox-content">
				<form class="form-horizontal suggestTopic" id="violation_status_update">
					{!! csrf_field() !!}
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="sanction_violation_id" id="sanction_violation_id">

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">
							<label class="control-label">Student No</label>
							<output class="form-control" name="m_student_no" id="m_student_no"></output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">
							<label class="control-label">Status</label>
							<select class="form-control" name="sanction_status" id="sanction_status">
								<option disabled="" selected=""></option>
								<option value="2">Completed</option>

							</select>
						</div>

					</div>

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">
							<label class="control-label">Updated by</label>
							<output class="form-control" name="m_updated_by" id="m_updated_by">
								{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
							</output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>

			</div>

			<div class="modal-footer">
				<button class="ladda-button btn btn-w-m btn-primary claimItem" id="sanction_update_btn" type="button">
					<strong>Update</strong>
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

<!-- CS Modal -->

<div id="cs_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">Add to Community Service</h4>
			</div>

			<div class="ibox-content">
				<form class="form-horizontal suggestTopic" id="add_to_cs">
					{!! csrf_field() !!}
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="cs_violation_id" id="cs_violation_id">

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">
							<label class="control-label">Student No</label>
							<input type="hidden" name="cs_modal_student_id" id="cs_modal_student_id">
							<output class="form-control" name="cs_modal_student_no" id="cs_modal_student_no"></output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">

							<div class="row">
								<div class="col-md-6">
									<label>Days of Community Work</label>
									<input type="number" class="form-control" name="cs_days" id="cs_days">
								</div>
								<label >Total Number of Hours</label>
								<div class="col-md-6">

									<input type="text" class="form-control" name="cs_hours" id="cs_hours" readonly="">
								</div>
							</div>
						</div>
					</div>

					<!-- 	<div class="form-group claimItem">

					<div class="col-md-10 col-md-offset-1">
					<label class="control-label">Updated by</label>
					<output class="form-control" name="m_updated_by" id="m_updated_by">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</output>
					<span class="help-block m-b-none text-danger"></span>
					</div>

					</div> -->

			</div>
			<div class="modal-footer">
				<button class="ladda-button btn btn-w-m btn-primary claimItem" id="add_to_cs_btn" type="button">
					<strong>Add</strong>
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

<!-- Suspension Modal -->

<div id="suspension_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">Suspend/Exclude Student</h4>
			</div>

			<div class="ibox-content">
				<form class="form-horizontal suggestTopic" id="add_suspension">
					{!! csrf_field() !!}
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="suspension_violation_id" id="suspension_violation_id">

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">
							<label class="control-label">Student No</label>
							<input type="hidden" name="_suspension_student_no" id="_suspension_student_no">
							<output class="form-control" name="suspension_student_no" id="suspension_student_no"></output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>

					<div class="form-group">
						<div class="col-md-10 col-md-offset-1">
							<input type="radio"  name="suspension_exclusion" value="Suspend">
							Suspend
							<br>
							<br>
							<input type="number" placeholder="No. of days" class="form-control" id="suspension_days" name="suspension_days">
							<br>
							<input type="radio" 	name="suspension_exclusion" value="Exclude">
							Exclude
							<br>
						</div>
					</div>

					<!-- 	<div class="form-group claimItem">

					<div class="col-md-10 col-md-offset-1">
					<label class="control-label">Status</label>
					<select class="form-control" name="suspension_status" id="suspension_status">
					<option disabled="" selected=""></option>
					<option value="2">Completed</option>

					</select>
					</div>

					</div>
					-->

					<!-- <div class="form-group claimItem">

					<div class="col-md-10 col-md-offset-1">
					<label class="control-label">Added by</label>
					<output class="form-control" name="m_updated_by" id="m_updated_by">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</output>
					<span class="help-block m-b-none text-danger"></span>
					</div>

					</div>
					-->

			</div>

			<div class="modal-footer">
				<button class="ladda-button btn btn-w-m btn-primary claimItem" id="suspension_btn" type="button">
					<strong>Submit</strong>
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

<!-- Suspension update Modal -->

<div id="suspension_update_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">Update Suspension Status</h4>
			</div>

			<div class="ibox-content">
				<form class="form-horizontal suggestTopic" id="suspension_update_status">
					{!! csrf_field() !!}
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="suspension_id" id="suspension_id">

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">
							<label class="control-label">Student No</label>
							<output class="form-control" name="suspended_student_no" id="suspended_student_no"></output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">
							<label class="control-label">Dates</label>
							<div class="date">
								<input type="text" name="">
							</div>
						</div>

					</div>

					<div class="form-group claimItem">

						<div class="col-md-10 col-md-offset-1">
							<label class="control-label">Updated by</label>
							<output class="form-control" name="m_updated_by" id="m_updated_by">
								{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
							</output>
							<span class="help-block m-b-none text-danger"></span>
						</div>

					</div>

			</div>

			<div class="modal-footer">
				<button class="ladda-button btn btn-w-m btn-primary claimItem" id="suspension_update_btn" type="button">
					<strong>Update</strong>
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

<script src="/js/sanctions.js"></script>
@endsection
