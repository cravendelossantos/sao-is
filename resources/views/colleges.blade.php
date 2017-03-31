@extends('layouts.master')

@section('title', 'SAO | Colleges')

@section('header-page')
<div class="row">
<div class="col-md-12">
	<h1>Colleges</h1>

	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            Settings
        </li>
        <li class="active">
            <strong>Colleges</strong>
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
				<h2>Add College</h2>
				
			</div>
			<div class="ibox-content">
				<form role="form" id="collegeForm" method="POST" action="">
					{!! csrf_field() !!}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group ">
								<label>College</label>
								<input type="text" placeholder="College Name/Description" name="college_description" id="college_description" class="form-control" autofocus="" style="text-transform: capitalize;">
							</div>
						</div>
						

					</div>

			</div>

			<div class="ibox-footer">
				<button class="btn btn-w-m btn-primary" id="add_course" type="button">
					<strong>Save</strong>
				</button>	
			</div>
			</form>
	
		</div>

	</div>
</div>


<div class="row">
	<div class="col-md-12 animated fadeInRight">
		<div class="ibox">
			<div class="ibox float-e-margins">

				<div class="ibox-title">
					<h5>Colleges List</h5>
					
				</div>

				<div class="ibox-content">

					<div class="table-responsive">

						<table class="table table-striped table-bordered table-hover dataTables-example1" >
							<thead>
								<tr>
									<th>College Name</th>
								
								</tr>
							</thead>

							<tbody  id="tbody">
								@foreach ($colleges as $row)
							
								<tr>
									<td>{{$row->description}}</td>
										
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

<script type="text/javascript">
		$('#add_course').click(function(e){
		e.preventDefault();
		
					$.ajax({
						headers : {
				'X-CSRF-Token' : $('input[name="_token"]').val()
			},
			type : "POST",
			url : "/add/college",
			data : $('form#collegeForm').serialize(),
					}).fail(function(data){
						 var errors = $.parseJSON(data.responseText);
				var msg="";
				
				$.each(errors.errors, function(k, v) {
					msg = msg + v + "\n";
					swal("Oops...", msg, "warning");

				});

					}).done(function(data){
							 swal({   
			 			title: "Success!",  
			 	 text: data.response,   
			 	 timer: 2000, 
			 	 type: "success",  
			 	 showConfirmButton: false 

	
			 	});
				$('form#collegeForm').each(function() {
					this.reset();
				});	
				window.location.reload();
	});
				

		});

</script>
@endsection


