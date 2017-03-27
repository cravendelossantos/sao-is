@extends('layouts.master')

@section('title', 'SAO | Message Log')

@section('header-page')
<div class="col-lg-12">
	<h1>Message Log</h1>
</div>

@endsection


@section('content')



<div class="row">

	<div class="col-md-12 animated fadeInRight">
        <div class="ibox float-e-margins">

        <div class="ibox-title">
        List
        </div>
		<div class="ibox">


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

                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <table class="table table-striped table-bordered table-hover dataTable" id="sms-log-DT" aria-describedby="DataTables_Table_0_info" role="grid">

                        <thead>
                            <th>Date Sent</th>
                            <th>Time Sent</th>
                            <th>Type</th>
                            <th>Recipient</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>

                    <tbody>
                        @foreach($messages as $message)

                       
                        <tr>
                            <form action="/sms-log/delete" method="post">

                                <td>{{ $message->date_sent }}</td>
                                <td>{{ $message->time_sent }}</td>

                                <td>{{ $message->type }}</td>
                                <td>{{ $message->recipient }}</td>	

                                {{ csrf_field() }}

                                <td>{{ $message->message }} <input type="hidden" name="message_id" value="{{ $message->id }}"></td>

                                @if ($message->sent == false)

                                <td>Failed</td>
                                @else
                                <td>Sent</td>
                                @endif

                                <td>
                                @if ($message->sent == false)
                                    <button class="btn btn-sm btn-primary" type="submit">Retry</button>
                                @endif
                                    <button type="submit" formaction="/user-management/roles/revoke" class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </td>

                                </form>
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
</div>


<script>
    var sms_log_table = $('#sms-log-DT').DataTable({
        "bPaginate" : true,
        "bInfo" :  false,
        "bFilter" : true,
        "processing": true,
        "serverSide": false,
        /*"ajax": {
            headers : {
                'X-CSRF-Token' : $('input[name="_token"]').val(),
            },
            url : "/sanctions/excluded_students",
            type: 'POST',
            data: function (d) {
                d.suspensions_student_no = $('input[name=suspensions_student_no]').val();
            }
        },*/

        "bSort" : true,
        "bFilter" : true,

    });

</script>
@endsection

