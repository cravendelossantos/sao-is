@extends('layouts.master')

@section('title', 'SAO | Content Management')

@section('header-page')
<div class="row">
<div class="col-lg-12">
	<h1>Content Management</h1>
	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li class="active">
            <strong>Content Management</strong>
        </li>
    </ol>
    </div>
</div>


@endsection

@section('content')



<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content animated fadeInUp">
			<h2>Edit Page Contents</h2><br>
				<div class="row">
					<div class="col-lg-2">	
						<div class="panel panel-primary">
  							<div class="panel-heading">
   							 <h2>Pages</h2>
 							 </div>
							
							<ul class="list-group">				
								@foreach ($pages as $page)
								<a href="#" name="page_id" value="{{ $page->id }}" class="list-group-item"><i class="fa fa-file-code-o"></i>&nbsp;&nbsp;{{ $page->page }}</a>
								@endforeach 
							</ul>
						</div>
					</div>	




					<div class="col-lg-10">

						<form method="POST" action="/content-management/save" id="cms-form"> 

							<input type="hidden" name="selected-page-id" id="selected-page-id">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							
							
							<textarea name="content-value" id="content-value"></textarea>	

							<br><br>
							<button class="btn btn-w-m btn-primary" id="save_btn" type="button">
								<strong>Save</strong>
							</button>

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>		
</div>





<script src="/js/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/js/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script>

	tinymce.init({
		selector: "textarea",
		plugins: [
			"advlist lists textcolor colorpicker autoresize",
		],
		toolbar: [ "undo redo | styleselect | fontselect | forecolor | fontsizeselect",
			"bold italic underline | alignleft aligncenter alignright alignjustify | indent outdent | bullist numlist",
		],
		fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt 40pt',
		menubar: false
	});


$('.list-group a').click(function(e){
	var load = $(this).attr("value");

	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		type : "GET",
		url : "/page-content/load",
		data : { page_id : load},

	}).fail(function(data){
		var errors = $.parseJSON(data.responseText);
		var msg="";
				
		$.each(errors.errors, function(k, v) {
			msg = msg + v + "\n";
			swal("Oops...", msg, "warning");
		});

	}).done(function(data){
		$('#selected-page-id').val(data['id']);
		if (data['value'] == "" ){
			tinyMCE.get('content-value').setContent("The selected page has empty content");
		} else {
			tinyMCE.get('content-value').setContent(data['value']);
		}
	});

});


$('#save_btn').click(function(e){

	var content = tinymce.get('content-value').getContent();
	var selected_page = $('#selected-page-id').val();
	
	$.ajax({
		headers : {
			'X-CSRF-Token' : $('input[name="_token"]').val()
		},
		type : "POST",
		url : "/content-management/save",
		data : { new_content : content, page_id : selected_page },
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
			text: "Page content updated",   
			timer: 1000, 
			type: "success",  
			showConfirmButton: false 
		});
		
		$('form#cms-form').each(function() {
			this.reset();
		});	

		$('#selected-page-id').val("");

	});

});
</script>

<style type="text/css">
	.page-list{
		min-height: 400px;
	}
</style>
@endsection