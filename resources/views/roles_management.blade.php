@extends('layouts.master')

@section('title', 'SAO | User Roles')

@section('header-page')
<div class="row">
<div class="col-lg-12">
    <h1>User Roles</h1>
    <ol class="breadcrumb">
        <li>
             <a href="/home">Home</a>
        </li>
        <li>
            User Management
        </li>
        <li class="active">
            <strong>User Roles</strong>
        </li>
    </ol>
    </div>
</div>


@endsection


@section('content')



<div class="row">

	<div class="col-md-12 animated fadeInRight">

		<div class="ibox">


			<div class="ibox float-e-margins">
                 <div class="ibox-title">
                <h2>Manage Roles</h2>
                </div>
                </hr>
<div class="ibox-content">
	@if ($message = Session::get('success'))
					<div class="alert alert-success" role="alert">
						{{ Session::get('success') }}
					</div>
				@endif

				@if ($message = Session::get('error'))
					<div class="alert alert-danger" role="alert">
						{{ Session::get('error') }}
					</div>
				@endif


			<div class="table-responsive">

<table class="table table-striped">

		        <thead>
        <th>Name</th>
		<th>E-Mail</th>
        <th>Admin</th>
        <th>Secretary</th>
        <th>Action</th>

        </thead>

        <tbody>
        @foreach($users as $user)

        @if ($user->hasRole('Admin'))

        @else
            <tr>
                <form action="/user-management/roles/assign" method="post">
                <td>{{ $user->first_name }} {{ $user->last_name }}</td>	
                    <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                    
                    	
			
                  

                              <td><input type="checkbox" class="checkbox-info" {{ $user->hasRole('Admin') ? 'checked' : '' }} name="role_admin"></td>

                    <td><input type="checkbox" class="checkbox-info" {{ $user->hasRole('Secretary') ? 'checked' : '' }} name="role_secretary"></td>
               

                    
                    {{ csrf_field() }}

                    <td><button class="btn btn-sm btn-primary" type="submit">Assign Roles</button>
                    <button type="submit" formaction="/user-management/roles/revoke" class="btn btn-sm btn-danger" type="submit">Revoke</button></td>
                </form>
            </tr>

            @endif

        @endforeach
        </tbody>
    </table>




		</div>
	</div>
</div>
</div>
</div>
</div>


<div class="row animated fadeInRight">

@foreach($users as $user)
            <div class="col-lg-6">
                <div class="contact-box">
                    
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/avatars/{{ $user->avatar }}">
                            <div class="m-t-xs font-bold">{{ $user->roles->first()->description }}</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                    @if ($user->id == Auth::user()->id)
                        <h3><strong>{{ $user->first_name }} {{ $user->last_name }}</strong>  (You)</h3>
                    @else
                        <h3><strong>{{ $user->first_name }} {{ $user->last_name }}</strong></h3>
                    @endif
                        
                        
                        <br>
                        <p><i class="fa fa-map-marker"></i> {{ $user->address }}</p>
                        <address>
                            <strong>Student Affairs Office</strong><br>
                            Lyceum of the Philippines University - Cavite<br>
                            General Trias, Cavite<br>
                            {{ $user->email }}<br>
                            <abbr title="Phone">P:</abbr> {{ $user->contact_no }}
                        </address>
                    </div>
                    <div class="clearfix"></div>
                        

                </div>
</div>
                @endforeach
            </div>


    <script>
        $(document).ready(function(){
            $('.contact-box').each(function() {
                animationHover(this, 'pulse');
            });
        });
    </script>


@endsection

