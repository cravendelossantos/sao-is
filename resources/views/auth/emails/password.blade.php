@extends('layouts.passwords')

@section('content')

<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <table  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                    	<img src="{{ $message->embed(public_path() . '/img/lpu.png') }}" alt="" />
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <h3>Reset your password</h3>
                                    </td>
                                </tr>
                                  <tr>
                                    <td class="content-block">
                                       We've received a request to reset your password.

                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                    	To reset your password please click the link below (link expires in 60 minutes):
                                    	<br><br>
                                       <a class="btn-primary" href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">Reset my password
                                       </a>
                                    </td>
                                    <br><br><br>
                                </tr>
                        
                              </table>
                        </td>
                    </tr>
                </table>
          	
		
					
                </div>
        </td>

    </tr>
</table>


@endsection

