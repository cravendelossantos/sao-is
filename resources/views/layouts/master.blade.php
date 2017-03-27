<!DOCTYPE html>
<html>
<head>

	<!-- Metadata -->
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<title>@yield('title')</title>

	<!-- Mainly scripts -->
	<script src="/js/jquery-2.1.1.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- Custom and plugin javascript -->
	<script src="/js/inspinia.js"></script>
	<script src="/js/plugins/pace/pace.min.js"></script>

	<!-- jQuery UI -->
	<script src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>

	@section('css')
	
	<!-- CSS Files -->
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="/css/animate.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
	<link href="/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
	<link href="/css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>
	<link href="/css/weather-icons/weather-icons.min.css" rel="stylesheet">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >
	<link rel="stylesheet" type="text/css" href="/css/plugins/jQueryUI/jquery-ui.css" />
	<link href="/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
	<link href="/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
	<link href="/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
	<link href="/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
	<link href="/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/datepick/jquery.datepick.css">
	<link href="/css/note-style.css" rel="stylesheet">

	@show

</head>

<body class="md-skin" id="sao-is-body">

	<div id="wrapper">

		<nav class="navbar-default navbar-static-side" id="nav" role="navigation">
			<div class="fixed-nav">

				<ul side-navigation="" class="nav metismenu" id="side-menu" style="display: block;">
					<li class="nav-header">

						<div class="dropdown profile-element" dropdown="">
							<img alt="profile_picture" class="img-circle" style="border-radius: 50%;"  height="60px" width="60px" src="/img/avatars/{{ Auth::user()->avatar }}">

							<a data-toggle="dropdown" class="dropdown-toggle" href="#"> <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold" style="font-weight: 800;">
								{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} 
							</strong> </span> <span class="text-muted-ins text-xs block">
							{{ Auth::user()->roles->first()->name }}

							<b class="caret"></b> </span> </a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								<li>
									<a href="/profile/my_profile"><i class="fa fa-btn fa-user"></i>&nbsp;&nbsp;Profile</a>
								</li>
								<li>
									<a href="#" data-toggle="modal" data-target="#change_pass"><i class="fa fa-btn fa-cog"></i>&nbsp;&nbsp;Change password</a>
								</li>

								<li class="divider"></li>
								<li>
									<a href="/logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Log Out</a>
								</li>
							</ul>
						</div>
						<div class="logo-element">
							SAO
						</div>
					</li>

					@section('side-bar')

					<li class="{{ Request::is('home') ? 'active' : null }}">
						<a href="/home"><i class="fa fa-home"></i> <span class="nav-label ng-binding">Home</span> </a>
					</li>
					<li class="{{ Request::is('violation*' , 'report-violation') ? 'active' : 'null' }}">
						<a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label ng-binding" > Student Violations Management</span><span class="fa arrow"></span></a>
							
							
						<ul class="nav nav-second-level collapse">
							
							<li ui-sref-active="active" class="{{ Request::is('report-violation') ? 'active' : 'null' }}">
								<a href="{{ url('/report-violation') }}"><i class=""></i> <span class="nav-label ng-binding">Report Violation</span> </a>
							</li>
							<li ui-sref-active="active" class="{{ Request::is('violation-statistics') ? 'active' : 'null' }}">
								<a href="/violation-statistics"><i class=""></i> <span class="nav-label ng-binding">Statistics </span> </a>
							</li>
							<li ui-sref-active="active" class="{{ Request::is('violation-reports') ? 'active' : 'null' }}">
								<a href="/violation-reports"><i class=""></i> <span class="nav-label ng-binding">Reports</span> </a>
							</li>

						</ul>

					</li>



					<li class="{{ Request::is('sanctions/*' , 'sanctions') ? 'active' : 'null' }}">
						<a href="/sanctions"><i class="fa fa-desktop"></i> <span class="nav-label ng-binding" >Sanctions</span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li ui-sref-active="active" class="{{ Request::is('sanctions') ? 'active' : 'null' }}">
									<a href="/sanctions"><i class=""></i> <span class="nav-label ng-binding"> Sanctions Monitoring</span> </a>
								</li>
								<li ui-sref-active="active" class="{{ Request::is('sanctions/reports') ? 'active' : 'null' }}">
									<a href="/sanctions/reports"><i class=""></i> <span class="nav-label ng-binding"> Reports</span> </a>
								</li>
							</ul>
					</li>


						<li class="{{ Request::is('locker-*' , 'lockers') ? 'active' : 'null' }}">
							<a href="#"><i class="fa fa-lock"></i> <span class="nav-label ng-binding">Locker Management</span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								
								<li ui-sref-active="active" class="{{ Request::is('lockers') ? 'active' : 'null' }}">
									<a href="/lockers"> <i class=""></i> <span class="nav-label ng-binding">Locker Assignment</span> </a>
								</li>
								<li ui-sref-active="active" class="{{ Request::is('locker-statistics') ? 'active' : 'null' }}">
									<a href="/locker-statistics"> <i class=""></i> <span class="nav-label ng-binding">Statistics</span> </a>
								</li>
								<li ui-sref-active="active" class="{{ Request::is('locker-reports') ? 'active' : 'null' }}">
									<a href="/locker-reports"> <i class=""></i> <span class="nav-label ng-binding">Reports</span> </a>
								</li>

							</ul>
						</li>
						<li class="{{ Request::is('lost-and-found/*' , 'lost-and-found') ? 'active' : 'null' }}">
							<a href="#"><i class="fa fa-book"></i> <span class="nav-label ng-binding">Lost and Found</span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
						 		
							
							<li ui-sref-active="active" class="{{ Request::is('lost-and-found') ? 'active' : 'null' }}">
								<a href="/lost-and-found"><i class=""></i> <span class="nav-label ng-binding">Add / Claim Items</span> </a>
							</li>
							<li ui-sref-active="active" class="{{ Request::is('lost-and-found/statistics') ? 'active' : 'null' }}">
									<a href="/lost-and-found/statistics"> <i class=""></i> <span class="nav-label ng-binding">Statistics</span> </a>
							</li>
							<li ui-sref-active="active" class="{{ Request::is('lost-and-found/reports') ? 'active' : 'null' }}">
								<a href="/lost-and-found/reports"> <i class=""></i> <span class="nav-label ng-binding">Reports</span> </a>
							</li>

						</ul>
					</li>

					<li class="{{ Request::is('campus', 'reservationReports') ? 'active' : 'null' }}">
						<a href="#"><i class="fa fa-calendar"></i> <span class="nav-label ng-binding">Campus Venue Reservation Monitoring</font></span><span class="fa arrow"></span></a>
						<ul class="nav nav-second-level collapse">

							<li ui-sref-active="active" class="{{ Request::is('campus') ? 'active' : 'null' }}">
								<a href="/campus"> <i class=""></i> <span class="nav-label ng-binding">Reservation Form</span> </a>
							</li>
						</li>
 						<li ui-sref-active="active" class="{{ Request::is('reservationReports') ? 'active' : 'null' }}">
							<a href="/reservationReports"> <i class=""></i> <span class="nav-label ng-binding">Reports</span> </a>
						</li> 

					</ul>
				</li>

				<li class="{{ Request::is('addActivity' , 'activities' , 'activitiesReports') ? 'active' : 'null' }}">
					<a href="#"><i class="fa fa-list"></i> <span class="nav-label ng-binding">Monitoring of Proposal of Activities</span><span class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<li ui-sref-active="active" class="{{ Request::is('addActivity') ? 'active' : 'null' }}">
							<a href="/addActivity"><i class=""></i> <span class="nav-label ng-binding">Add Activity</span> </a>

						</li>
						<li ui-sref-active="active" class="{{ Request::is('activities') ? 'active' : 'null' }}">
							<a href="/activities"> <i class=""></i> <span class="nav-label ng-binding">Monitoring of Activities</span> </a>
						</li>

					</li>
					<li ui-sref-active="active" class="{{ Request::is('activitiesReports') ? 'active' : 'null' }}">
						<a href="/activitiesReports"> <i class=""></i> <span class="nav-label ng-binding">Reports</span> </a>
					</li>

				</ul>
			</li>

			<li class="{{ Request::is('OrganizationsRenewal*' , 'organizationsRenewal') ? 'active' : 'null' }}">
				<a href="#"><i class="fa fa-file"></i> <span class="nav-label ng-binding">Organizations Renewal Management</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">


					<li ui-sref-active="active" class="{{ Request::is('OrganizationsRenewalAdd') ? 'active' : 'null' }}">
						<a href="/OrganizationsRenewalAdd"><i class=""></i> <span class="nav-label ng-binding">Add Organization</span> </a>

					</li>

					<li ui-sref-active="active" class="{{ Request::is('OrganizationsRenewalList') ? 'active' : 'null' }}">
						<a href="/OrganizationsRenewalList"><i class=""></i> <span class="nav-label ng-binding">List of Organizations</span> </a>

					</li>
					<li ui-sref-active="active" class="{{ Request::is('organizationsRenewal') ? 'active' : 'null' }}">
						<a href="/organizationsRenewal"> <i class=""></i> <span class="nav-label ng-binding">Requirements Checklist</span> </a>
					</li>

				</ul>
			</li>

			<li class="{{ Request::is('text-messaging/*') ? 'active' : 'null' }}">
				<a href="#"><i class="fa fa-mobile"></i> <span class="nav-label ng-binding">Text Messaging</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">


					<li ui-sref-active="active" class="{{ Request::is('text-messaging/compose') ? 'active' : 'null' }}">
						<a href="/text-messaging/compose"><i class=""></i> <span class="nav-label ng-binding">Compose Text Message</span> </a>

					</li>

					<!-- <li ui-sref-active="active" class="{{ Request::is('text-messaging/log') ? 'active' : 'null' }}">
						<a href="/text-messaging/log"><i class=""></i> <span class="nav-label ng-binding"></span>Message Log</a>

					</li> -->
					
				</ul>
			</li>

						
							@if ( Auth::user()->roles->first()->name == 'Admin')
							<li class="{{ Request::is('student-records' , 'violation-list' , 'activity-records') ? 'active' : 'null' }}">
								<a href="#"><i class="fa fa-exchange"></i> <span class="nav-label ng-binding">Records Management</span><span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse">
									<li ui-sref-active="active" class="{{ Request::is('student-records') ? 'active' : 'null' }}">
										<a href="/student-records"><span class="nav-label ng-binding">Student Records</span> </a>

									</li>
									<li ui-sref-active="active" class="{{ Request::is('violation-list') ? 'active' : 'null' }}">
										<a href="/violation-list"><span class="nav-label ng-binding">Violation List</span> </a>
									</li>

									<li ui-sref-active="active" class="{{ Request::is('activity-records') ? 'active' : 'null' }}">
										<a href="/activity-records"><span class="nav-label ng-binding">Activities</span> </a>
									</li>

								</ul>
							</li>

							
							
							

							<li class="{{ Request::is('user-management/*') ? 'active' : 'null' }}">
								<a href="#"><i class="fa fa-users"></i> <span class="nav-label ng-binding">User Management</span><span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse">
									<li ui-sref-active="active" class="{{ Request::is('user-management/admin') ? 'active' : 'null' }}">
										<a href="/user-management/admin/new-account"><span class="nav-label ng-binding">Create new account</span> </a>

									</li>
									<li ui-sref-active="active" class="{{ Request::is('user-management/roles') ? 'active' : 'null' }}">
										<a href="/user-management/roles"><span class="nav-label ng-binding">User Roles</span> </a>
									</li>

								</ul>
							</li>


							<li ui-sref-active="active" class="{{ Request::is('content-management') ? 'active' : 'null' }}">
								<a href="/content-management"><i class="fa fa-edit"></i> <span class="nav-label ng-binding">Content Management</span> </a>
							</li>
							@else
							


							@endif


							<li ui-sref-active="active" class="{{ Request::is('notes') ? 'active' : 'null' }}">
								<a href="/notes"><i class="fa fa-clipboard"></i> <span class="nav-label ng-binding">Notes</span> </a>
							</li>

							@if ( Auth::user()->roles->first()->name == 'Admin')
							<li class="{{ Request::is('settings/*') ? 'active' : 'null' }}">
								<a href="#"><i class="fa fa-cog"></i> <span class="nav-label ng-binding">Settings</span><span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse">
						<!-- 	<li ui-sref-active="active">
								<a href="/violation"><i class="fa fa-plus"></i> <span class="nav-label ng-binding">Violations</span> </a>

							</li> -->
							<li ui-sref-active="active" >
								<a href="/courses"><span class="nav-label ng-binding">Courses</span> </a>
							</li>

							<li ui-sref-active="active" class="{{ Request::is('settings/locker-locations') ? 'active' : 'null' }}">
								<a href="/settings/locker-locations"><span class="nav-label ng-binding">Locker Locations</span> </a>
							</li>

							<li ui-sref-active="active" class="{{ Request::is('settings/dates/school-year') ? 'active' : 'null' }}">
								<a href="/settings/dates/school-year"><span class="nav-label ng-binding">Date Settings</span> </a>
							</li>

						</ul>
					</li>
					
					@endif



				</ul>

			</div>
			@show
		</nav>

		<div id="page-wrapper" class="gray-bg dashbard-1">


			<div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">

             <!-- <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> -->
            
        </div>
        	<ul class="nav navbar-top-links navbar-left">
        	<li>
            		<img src="/img/lpu-cavite.png" class="" height="55px;" style="margin-top: 2px; margin-left: 10px;">
            	</li>
            	</ul>
            <ul class="nav navbar-top-links navbar-right">
            	
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome to Student Affairs Office Information System</span>
                </li>
      

                <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle">
                		<img alt="profile_picture" class="img-circle" style="border-radius: 50%;"  height="25px" width="25px" src="/img/avatars/{{ Auth::user()->avatar }}">
                		{{ Auth::user()->email }} &nbsp;<i class="caret"></i>
                	</a>
                	<ul class="dropdown-menu">
                		<li><a href="/profile/my_profile"><i class="fa fa-user"></i>&nbsp;&nbsp;Profile</a></li>
                		<li class="divider"></li>
                		<li><a href="/logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Log Out</a></li>
                	</ul>
                </li>
            </ul>

        </nav>
        </div>


			<div class="row  border-bottom white-bg dashboard-header">
				@yield('header-page')
			</div>

			<div class="wrapper wrapper-content">
				@yield('content')

			</div>

			<div class="footer fixed">
				<div class="pull-right">
					<strong id="time"></strong>
				</div>
				<div>
					<strong>Copyright</strong> Lyceum of the Philippines University - Cavite. &copy; 2016 - {{ Carbon\Carbon::now()->format('Y') }}
				</div>
			</div>

		</div>

	</div>




	<!-- Modal -->
	<div id="change_pass" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Change your password</h4>
				</div>
				<div class="modal-body">

					<form id="change_password_form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label>Your Old Password</label>
							<input type="password" class="form-control"  placeholder="Old password" name="old_password" autocomplete="off" required autofocus>
						</div>

						<div class="form-group">
							<label>New Password</label>
							<input type="password" class="form-control"  placeholder="New password" name="password" autocomplete="off" required autofocus>
						</div>

						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" class="form-control"  placeholder="Re-type your password" name="password_confirmation" autocomplete="off" required autofocus>
						</div>
					</form>

					<button type="button" class="btn btn-md btn-primary pull-left" id="change_pass_btn">Save</button>

				</div>
				<div class="modal-footer">

				</div>
			</div>

		</div>
	</div>


	@yield('scripts')

	<!-- Data Tables -->
    <script src="/js/plugins/dataTables/datatables.min.js"></script>
    <script src="/js/plugins/dataTables/dataTables.responsive.js"></script>

	<!-- Idle Timer plugin -->
    <script src="/js/plugins/idle-timer/idle-timer.min.js"></script>

	<!-- GITTER -->
	<script src="/js/plugins/gritter/jquery.gritter.min.js"></script>

	<!-- Custom and plugin javascript -->
	<script src="/js/inspinia.js"></script>
	<script src="/js/plugins/pace/pace.min.js"></script>
	<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- SUMMERNOTE -->
	<script src="/js/plugins/summernote/summernote.min.js"></script>


	<!-- Chosen -->
	<script src="/js/plugins/chosen/chosen.jquery.js"></script>
	<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>

	<!-- Data picker -->
	<script type="text/javascript" src="/js/jquery.plugin.datepick.js"></script>
	<script type="text/javascript" src="/js/jquery.datepick.js"></script>
	<script src="/js/plugins/datapicker/bootstrap-datepicker.js"></script>

	<!-- MENU -->
	<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>

	<!-- Color picker -->
	<script src="/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

	<!-- Clock picker -->
	<script src="/js/plugins/clockpicker/clockpicker.js"></script>

	<!-- Date range use moment.js same as full calendar plugin -->
	<script src="/js/plugins/fullcalendar/moment.min.js"></script>

	<!-- Date range picker -->
	<script src="/js/plugins/daterangepicker/daterangepicker.js"></script>

	<!-- Select2 -->
	<script src="/js/plugins/select2/select2.full.min.js"></script>

	<!-- Sweet Alert -->
	<script src="/js/plugins/sweetalert/sweetalert.min.js"></script>
	<script src="/js/plugins/chartJs/Chart.min.js"></script>


	<!-- Page Scripts -->
	<script src="/js/app.js"></script>
	<script src="/js/home.js"></script>
	<script src="/js/moment.js"></script>
	
	<!-- Register --> 
	<script src="/js/register.js"></script>

	<!-- G-Charts -->
	<script type="text/javascript" src="/js/jsapi.js"></script>
	<script type="text/javascript" src="/js/uds_api_contents.js"></script>

	@show

</body>
</html>