@extends('layouts.master')

@section('title', 'SAO | Courses')

@section('header-page')
<div class="col-md-12">
	<h1>Manage Courses</h1>
</div>

@endsection

@section('content')

<div class="row">

	<div class="col-md-6 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>Add course</h5>
				
			</div>
			<div class="ibox-content">

				<form role="form" id="violationForm" method="POST" action="/add-course">
					{!! csrf_field() !!}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group ">
								<label>Course</label>
								<input type="text" placeholder="Course Description" name="course_description" id="course_description" class="form-control" autofocus="" aria-required="true">
							</div>
						</div>

					</div>

			</div>

			<div class="ibox-footer">
				<button class="btn btn-w-m btn-primary" id="addItemBtn" type="submit">
					<strong>Add</strong>
				</button>
				</form>
			</div>

		</div>

	</div>
	<div class="col-md-6 animated fadeInRight">
		<div class="ibox">
			<div class="ibox float-e-margins">

				<div class="ibox-title">
					<h5>Course List</h5>
					
				</div>

				<div class="ibox-content">

					<div class="table-responsive">

						<table class="table table-striped table-bordered table-hover dataTables-example1" >
							<thead>
								<tr>
									<th>Description</th>
									<th>College</th>

								</tr>
							</thead>
							<tbody  id="tbody">
								@foreach ($courses as $row)
								<tr>
									<td>{{$row->course}}</td>
								</tr>
								@endforeach
							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

