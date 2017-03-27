@extends('layouts.master')

@section('title', 'SAO | Home')

@section('header-page')

<div class="row">
	<div class="col-md-12">
        <div class="widget style1">
            <div class="row">
                <div class="col-md-1 col-xs-2">
                    {!! $icon !!}
                </div>
                <div class="col-md-11 col-xs-10 text-left">
                    <h2> {{ $greeting }}, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</h2>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('content')



<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content animated fadeInUp">
			
			@if (empty($content->value))
			<a href="/content-management">Edit page content</a>
			
			@else
			{!! $content->value !!}

			@endif
			</div>
		</div>
	</div>
</div>		


@endsection

