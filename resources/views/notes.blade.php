@extends('layouts.master')

@section('title', 'SAO | Notes')

@section('header-page')

<div class="row">
<div class="col-md-12">
	<h1>My Notes</h1>

	<ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li class="active">
            <strong>Notes</strong>
        </li>
	</ol>
</div>
</div>

@endsection


@section('content')


<div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <ul class="notes">
                        <li>
                            <div>
                                <small>12:03:28 12-04-2014</small>
                                <h4>Long established fact</h4>
                                <p>The years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                <a href="#"><i class="fa fa-trash-o "></i></a>
                            </div>
                        </li>
                        <li>
                            <div>
                                <small>11:08:33 16-04-2014</small>
                                <h4>Latin professor at Hampden-Sydney </h4>
                                <p>The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                                <a href="#"><i class="fa fa-trash-o "></i></a>
                            </div>
                        </li>
					</ul>
				</div>	
			</div>	
</div>

@endsection

