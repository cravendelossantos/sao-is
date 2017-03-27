@extends('layouts.passwords')

@section('title', 'SAO | Forgot Password')

@section('content')


   <div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="ibox-content">
               <h1 class="font-bold">Forgot password</h1>
               
                    
                    <p>
                        Enter your email address and your password will be reset and emailed to you.
                    </p>
                    <br>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail Address">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope"></i>&nbsp; Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    <br><br>
                        
                    </form>
                    
                       
                            <div class="pull-left">
                               <a href="/login">Back</a>

                            </div>
                <br>
                </div>
            </div>
        </div>
     
    </div>
    </div>
@endsection