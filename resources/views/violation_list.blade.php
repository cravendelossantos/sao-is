@extends('layouts.master')

@section('title', 'SAO | Violation List')

@section('header-page')
<div class="row">
	<div class="col-lg-12">
		<h1>Violation List</h1>
	
	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Records Management
        </li>
        <li class="active">
            <strong>Violation List</strong>
        </li>
	</ol>
</div>
</div>
@endsection




@section('content')





<div class="row animated fadeInRight">
<div class="col-md-12">
		<div class="ibox float-e-margins">
<div class="ibox-content">
<h2>Import or Export</h2>
		  <div class="panel-body">

		  			@if ($message = Session::get('success'))
					<div class="alert alert-success" role="alert">
						{{ Session::get('success') }}
					</div>
				@endif

     @if (count($errors) > 0)
    <div class="alert alert-danger">
      
            @foreach ($errors as $error)
              {{ $error }}<br>
            @endforeach
        
    </div>
@endif
<!--  -->

				<h3>Import file from:</h3>


				<form action="/violation-list/importExcel"  method="POST" id="violation_records" class="form-horizontal"  enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="file" name="import_file" id="import_file" />


					<!-- <input type="hidden" value="{{Session::token()}}" name="_token"> -->
			<!-- 		{{ csrf_field() }} -->
					<br/>


			


					<input type="submit" class="btn btn-primary" id="import_btn" value="Import CSV or Excel File">

				</form>
				<br/>

		    	
		    	<h3>Export file from Violations Table:</h3>
		    	<div> 		
			   <!--  	<a href="{{ url('/violation-records/downloadExcel/xls') }}"><button class="btn btn-w-m btn-info">Download Excel xls</button></a>
					<a href="{{ url('/violation-records/downloadExcel/xlsx') }}"><button class="btn btn-w-m btn-info">Download Excel xlsx</button></a> -->
					<a href="{{ url('/violation-list/downloadExcel/csv') }}"><button class="btn btn-w-m btn-info">Download Excel File</button></a>
		    	</div>
  </div>

    </div>

		  </div>
		      	</div>
     	</div>

<div class="row animated fadeInRight">
<div class="col-md-12">

		<div class="ibox float-e-margins">


<div class="ibox-content">

<!-- <a class="btn btn-danger btn-rounded" href="{{ url('/violation-list/truncate') }}" id="truncate_btn">Truncate table</a>	 -->
<h2>Violation List</h2>


    			<div class="table-responsive">



					<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">



						<table class="table table-striped table-bordered table-hover violation-records-DT dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">

							<thead>
				
				<tr>
									<th>Name</th>
									<th>Description</th>
									<th>Offense Level</th>
									<th>First Offense</th>
									<th>Second Offense</th>
									<th>Third Offense</th>
							

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

<script>
	

</script>