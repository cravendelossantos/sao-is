@extends('layouts.master')

@section('title', 'SAO | Report Violation')

@section('header-page')
<div class="row">
<div class="col-md-12">
	<h1>Report Violation</h1>

	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Student Violations Management
        </li>
        <li class="active">
            <strong>Report Violation</strong>
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
				<output id="v_id">
					<h5>{{ $violation_id }}</h5>
				</output>

				<div class="ibox-tools"></div>

				<div class="ibox-content">
				
					<form role="form" action="" id="reportViolationForm" method="POST">
						{{ csrf_field() }}
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
								<div class="panel panel-lpu">
									<div class="panel-heading">
										<h4>Student Information</h4>
									</div>
									<div class="panel-body">

										<input type="hidden" name="student_number" id="student_number">
										<input type="hidden" name="complainant_id" id="complainant_id">
										<div class="form-group" >

											<label>Student No.</label>
											<a class="btn btn-white btn-xs" id="new" style="display:none" data-toggle="modal" data-target="#myModal" ><i class="fa fa-male"></i> New Student Record</a>
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Student No." name="student_no" id="student_no" class="form-control" maxlength="10">
												<span class="input-group-btn">
													<button class="btn btn-info" id="find_student" type="button">
														<i class="fa fa-search"></i>
													</button> </span>
											</div>

											<label id="student_number_error" class="error"></label>

										</div>

										<section id="student_info" style="">

											<div class="col-md-6">
												<div class="form-group">
													<label>Name</label>
													<output name="student_name" id="student_name" placeholder="Student Name" style="text-transform: capitalize"></output>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Year/Course</label>
													<output name="year_level" id="year_level" placeholder="Year/Course" ></output>
													<!-- <output name="course" id="course"></output> -->
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Guardian Name</label>
													<output name="guardian_name" id="guardian_name" placeholder="Guardian Name" ></output>
													<!-- <output name="course" id="course"></output> -->
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Guardian Contact No.</label>
													<output name="guardian_contact_no" id="guardian_contact_no" placeholder="Guardian Contact No." ></output>
													<!-- <output name="course" id="course"></output> -->
												</div>
											</div>

											<div class="col-md-6">

												<label>Offense Number #</label>

												<output name="committed_offense_number" id="committed_offense_number" placeholder="Offense Number" ></output>
												<input type="hidden" name="offense_number" id="offense_number">
											</div>
										</section>

									</div>
								</div>
							</div>

							<div class="col-md-12">

								<div class="panel panel-lpu">
									<div class="panel-heading">
										<h4>Violation Report Details</h4>
									</div>

									<div class="panel-body">
										<div class="col-md-3">
											<div class="form-group" id="violation_date_picker">
												<label>Date Committed</label>
												<div class="input-group date" id="data_1">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="date_committed" name="date_committed" class="form-control">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<label>Time Reported</label>
											<div class="input-group clockpicker time_reported" data-autoclose="true">
												<input type="text" class="form-control" value="" name="time_reported" id="time_reported">
												<span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
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

										<div class="col-md-12">
											<div class="form-group" >

												<label>Complainant ID</label>&nbsp;&nbsp;<a class="btn btn-white btn-xs" id="new_complainant" style="display:none" data-toggle="modal" data-target="#complainant_modal" ><i class="fa fa-male"></i> New Complainant Record</a>
												<a class="btn btn-white btn-xs" id="new" style="display:none" data-toggle="modal" data-target="#complainant_modal" ><i class="fa fa-male"></i> New Record</a>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="Complainant ID" name="complainant" id="complainant" class="form-control" maxlength="10" style="text-transform: capitalize;">
													<span class="input-group-btn">
														<button class="btn btn-info" id="find_complainant" type="button">
															<i class="fa fa-search"></i>
														</button> </span>
												</div>

												<label id="complainant_error" class="error"></label>

												<div class="form-group">
													<label>Complainant Details</label>
													<output name="first_name" id="complainant_info" placeholder="First Name" style="text-transform: capitalize"></output>
												</div>
											</div>

										</div>

										<div class="col-md-6">

											<div class="form-group">
												<label>Offense level</label>
												<input type="text" id="offense_level" name="offense_level" class="form-control" readonly="">

											</div>
										</div>

										<br>
										<div class="col-md-6">
											<div class="form-group">
												<label>Violation</label>
												<input type="hidden" name="violation_id" id="violation_id">
												<select class="form-control" id="violation_selection" name="violation">
													<option autofocus="" disabled selected >Violation</option>
													@foreach ($violations as $violation)
													<option> {{ $violation->name }} </option>
													@endforeach
												</select>

												<a href="/violation-list" id="violations_import" style="display:none">Import Violations</a>
											</div>
										</div>
										<section id="violation_details" style="display">
											<div class="col-md-12">
												<div class="form-group">
													<label>Description</label>
													<output id="violation_description"></output>

												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Sanction</label>
													<output id="violation_sanction" name="violation_sanction"></output>
													<input type="hidden" id="sanction"  name="sanction">
													</p>
												</div>
											</div>

										</section>
									</div>
								</div>
							</div>

						</div>
				</div>

				<div class="ibox-footer">
					<button class="btn btn-w-m btn-primary" id="report_btn" type="submit">
						<strong>Submit</strong>
					</button>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>


<div class="row">

	<div class="col-md-12 animated fadeInRight">

		<div id="try2" style="display:none">
			<div class="sk-spinner sk-spinner-wave">
				<div class="sk-rect1"></div>
				<div class="sk-rect2"></div>
				<div class="sk-rect3"></div>
				<div class="sk-rect4"></div>
				<div class="sk-rect5"></div>
			</div>

		</div>

		<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h2>Violation Reports</h2>
		</div>
		 
			<div class="ibox-content" id="">
		
				<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable" id="violation-reports-DT" width="100%">

							<thead>
								
								<th>Date Committed</th>
								<th>Violation ID</th>
								<th>Student No.</th>
								<th>Student Name</th>
								<th>Violation Name</th>
								<th>Violation Description</th>
								<th>Offense Level</th>
								<th>Action</th>
								<th>Offense No.</th>
								<th>Sanction</th>
								<th>Complainant</th>

							</thead>

						</table>
				</div>
				
			</div>
		</div>

	</div>
</div>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">New Student Violation Record</h4>
			</div>

			<form role="form" id="newStudentForm" method="POST">

				{!! csrf_field() !!}

				<div class="ibox-content">

					<div class="form-group">
						<label>Student No.</label>
						<input type="text" placeholder="Student No." class="form-control" id="studentNo" name="studentNo">
					</div>

					<div class="form-group">
						<label>First Name</label>
						<input type="text" placeholder="First Name" class="form-control" id="firstName" name="firstName" style="text-transform: capitalize">
					</div>

					<div class="form-group">
						<label>Last Name</label>
						<input type="text" placeholder="Last Name" class="form-control" id="lastName" name="lastName" style="text-transform: capitalize">
					</div>

					<div class="form-group">
						<label>Course</label>
						<select class="form-control" id="course" name="course">
							<option autofocus="" disabled selected >Select course</option>
							@foreach ($courses as $course)
							<option >{{$course->description}}</option>
							@endforeach

						</select>
					</div>

					<div class="form-group">
						<label>Year</label>
						<select name="yearLevel" id="yearLevel" class="form-control">
							<option disabled="" selected="">Select Year</option>
						</select>
					</div>

					<label>Contact No.</label>
					<div class="input-group m-b">
						<span class="input-group-addon">+63</span>
						<input type="text" placeholder="Contact No.	" class="form-control" id="studentContactNo" name="studentContactNo" maxlength="10">
					</div>

					<div class="form-group">
						<label>Guardian Name</label>
						<input type="text" placeholder="Guardian Name" class="form-control" id="guardianName" name="guardianName" style="text-transform: capitalize">
					</div>

					<label>Guardian Contact No.</label>
					<div class="input-group m-b">
						<span class="input-group-addon">+63</span>
						<input type="text" placeholder="Guardian Contact No." class="form-control" id="guardianContactNo" name="guardianContactNo" maxlength="10">
					</div>

					<div class="modal-footer">
						<button class="btn btn-w-m btn-primary" type="button" id="new_student_btn">
							<strong>Save</strong>
						</button>
						<button type="button" class="btn btn-w-m btn-danger" id="cancelBtn" data-dismiss="modal">
							<strong>Cancel</strong>
						</button>
					</div>

			</form>
		</div>
	</div>
</div>

<div id="complainant_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">New Complainant Record</h4>
			</div>

			<form role="form" id="new_complainant_form" method="POST">

				{!! csrf_field() !!}

				<div class="ibox-content">

					<div class="form-group">
						<label>Complainant ID</label>
						<input type="text" placeholder="Complainant ID" class="form-control" id="complainantId" name="complainantId">
					</div>

					<div class="form-group">
						<label>Name</label>
						<input type="text" placeholder="Complainant Name" class="form-control" id="complainantName" name="complainantName" style="text-transform: capitalize">
					</div>

					<div class="form-group">
						<label>Position</label>
						<select name="complainantPosition" id="complainantPosition" class="form-control">
							<option>Guard</option>
							<option>Faculty</option>
							<option>Student</option>
						</select>
					</div>

					<!-- 		<label>Contact No.</label>
					<div class="input-group m-b">
					<span class="input-group-addon">+63</span>
					<input type="text" placeholder="Contact No.	" class="form-control" id="contactNo" name="contactNo" maxlength="10">
					</div> -->

					<div class="modal-footer">
						<button class="btn btn-w-m btn-primary" type="button" id="new_complainant_btn">
							<strong>Save</strong>
						</button>
						<button type="button" class="btn btn-w-m btn-danger" id="cancelBtn" data-dismiss="modal">
							<strong>Cancel</strong>
						</button>
					</div>
</div>
			</form>
		</div>
	</div>
</div>



<div id="edit-violation-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					&times;
				</button>
				<h4 class="modal-title">Edit Violation Record</h4>
			</div>

			<form role="form" id="edit-violation-form" method="POST">

				{!! csrf_field() !!}

				<div class="ibox-content">

					<div class="form-group">
						<label>Violation ID</label>
						<input type="text" readonly="" class="form-control" id="rv_id" name="rv_id">
					</div>

					
											<div class="form-group">
												<label>Violation</label>
												<input type="hidden" name="violation_id" id="violation_id">
												<select class="form-control" id="violation_selection" name="violation">
													<option autofocus="" disabled selected >Violation</option>
													@foreach ($violations as $violation)
													<option> {{ $violation->name }} </option>
													@endforeach
												</select>

												<a href="/violation-list" id="violations_import" style="display:none">Import Violations</a>
											</div>
										

					<div class="form-group">
						<label>Position</label>
						<select name="complainantPosition" id="complainantPosition" class="form-control">
							<option>Guard</option>
							<option>Faculty</option>
							<option>Student</option>
						</select>
					</div>

					<div class="modal-footer">
						<button class="btn btn-w-m btn-primary" type="button" id="new_complainant_btn">
							<strong>Save</strong>
						</button>
						<button type="button" class="btn btn-w-m btn-danger" id="cancelBtn" data-dismiss="modal">
							<strong>Cancel</strong>
						</button>
					</div>
</div>
			</form>
		</div>
	</div>
</div>

<script src="/js/report-violation.js"></script>


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

	#try {
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
	#try2 {
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
</style>

@endsection
