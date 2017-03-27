@extends('index')

@section('title', 'SAO | Violations')

@section('header-page')
<div class="col-md-12">
	<h1>Violations</h1>
</div>

@endsection



@section('content')

<div class="row">

	<div class="col-md-12 animated fadeInRight">
		<div class="ibox float-e-margins">

			<div class="ibox-title">
				<h5>Add violation</h5>
				<div class="ibox-tools">
					<a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
					<a class="close-link"> <i class="fa fa-times"></i> </a>
				</div>
			</div>
			<div class="ibox-content">

				<form role="form" id="violationForm" method="POST" action="/violation">
					{!! csrf_field() !!}
					<div class="row">
							<div class="col-md-6">
							<div class="form-group">
								<label>Violation Name</label>
								<input type="text" placeholder="Violation name" name="violationName" class="form-control">
							</div>
						</div>

	<div class="col-md-6">
							<div class="form-group">
								<label>First Offense</label>
								<input type="text" placeholder="Sanction" name="first_offense_sanction" class="form-control">
							</div>
						</div>
					
						<div class="col-md-6">
							<div class="form-group">
								<label>Description</label>
								<input type="text" placeholder="Description" name="violationDescription" class="form-control">
							</div>
						</div>


							<div class="col-md-6">
							<div class="form-group">
								<label>Second Offense</label>
								<input type="text" placeholder="Sanction" name="second_offense_sanction" class="form-control">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label> Offense Level</label>
								<!--	<input type="text" placeholder="Company" name="" class="form-control" name="">-->
								<select class="form-control" name="offense_level">
									<option value="1"> Less Serious</option>
									<option value="2">Serious</option>
									<option value="3">Very Serious</option>

								</select>
							</div>
						</div>

					

							<div class="col-md-6">
							<div class="form-group">
								<label>Third Offense</label>
								<input type="text" placeholder="Sanction" name="third_offense_sanction" class="form-control">
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
			
		

		<div class="ibox">
			<div class="ibox float-e-margins">

				<div class="ibox-title">
					<h5>List</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a>
						<a class="close-link"> <i class="fa fa-times"></i> </a>
					</div>
				</div>

				<div class="ibox-content">

					<div class="table-responsive">

						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>Violation Name</th>
									<th>Offense Level</th>
									<th>Description</th>
									<th>Sanction</th>
									<th>Date</th>
	
								</tr>
							</thead>
							<tbody  id="tbody">
							@foreach ($violationTable as $row)
								<tr>
									<td>{{$row->name}}</td>
									<td>{{$row->offense_level}}</td>
									<td>{{$row->description}}</td>
									<!-- <td></td> -->
									<td>{{$row->created_at}}</td>

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

