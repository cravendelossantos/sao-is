@extends('layouts.master')

@section('title', 'SAO | Activities')

@section('header-page')
<div class="row">
	<div class="col-lg-8">
		<h1>Activities</h1>
	
	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Records Management
        </li>
        <li class="active">
            <strong>Activities</strong>
        </li>
	</ol>

</div>
<div class="col-lg-4">
	<div class="title-action">
		    		
		<a class="btn btn-default btn-lg" href="{{ url('/activities') }}"><i class="fa fa-list-ul"></i>&nbsp;View Records</a>
	</div>
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


				<form action="/activity-records/importExcel"  method="POST" id="activity-records" class="form-horizontal"  enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="file" name="import_file" id="import_file" />


					<!-- <input type="hidden" value="{{Session::token()}}" name="_token"> -->
			<!-- 		{{ csrf_field() }} -->
					<br/>


			


					<input type="submit" class="btn btn-primary" id="import_btn" value="Import CSV or Excel File">

				</form>
				<br/>

		    	
		    	<h3>Export file from Activities Table:</h3>
		    	<div> 		
			   <!--  	<a href="{{ url('/violation-records/downloadExcel/xls') }}"><button class="btn btn-w-m btn-info">Download Excel xls</button></a>
					<a href="{{ url('/violation-records/downloadExcel/xlsx') }}"><button class="btn btn-w-m btn-info">Download Excel xlsx</button></a> -->
					<a href="{{ url('/activity-records/downloadExcel/csv') }}"><button class="btn btn-w-m btn-info">Download Excel File</button></a>
		    	</div>
		    	
  </div>

    </div>

		  </div>
		      	</div>
     	</div>


@endsection

<script>
	

</script>