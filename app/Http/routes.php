<?php


//All users route group

Route::group(['middleware' => 'roles', 'roles' => ['Admin','Secretary']],function(){

	Route::get('user/{id}', function ($id) {
		$id = Auth::user()->id;
    	return 'User '.$id;
	});

	Route::get('/home' , 'HomeController@index');
	Route::get('/update-time' , 'HomeController@updateTime');
	//Academic Calendar
	Route::get('/academic-calendar' , 'AcademicCalendarController@showCalendar');
	Route::post('/academic-calendar/events' , 'AcademicCalendarController@postEvents');

	//Notes
	Route::get('/notes' , 'sysController@showNotes');
});

//Admin route group
Route::group(['middleware' => 'roles', 'roles' => ['Admin']],function(){

	//User management (Admin)
	//New account
	Route::get('/user-management/admin/new-account' , 'sysController@showRegisterAdmin');
	Route::get('/user-management/admin/validate' , 'sysController@getRegisterAdmin');
	Route::post('/user-management/admin' , 'sysController@postRegisterAdmin');

	//New account (attach roles)	
	Route::get('/user-management/roles' , 'sysController@showRoles');

	Route::post('/user-management/roles/assign' , 'sysController@postAdminAssignRoles');
	//Revoke user
	Route::post('/user-management/roles/revoke' , 'sysController@postAdminRevoke');


	//Edit account
	Route::get('/profile/my_profile' , 'sysController@showEditAccount');
	Route::get('/profile/edit/check' , 'sysController@getEditAccount');
	Route::post('/profile/edit/' , 'sysController@postEditAccount');
	
	Route::post('/upload/avatar' , 'sysController@updateAvatar');

	//Change password
	Route::post('/change_password', 'sysController@changePassword');

	//Content management
	Route::get('/content-management', 'sysController@showCMSpage');

	Route::post('/content-management/save', 'sysController@postCMS');
	Route::get('/page-content/load' , 'sysController@loadContent');


	Route::get('/settings/dates/school-year' , 'sysController@showDateSettings');
	Route::get('/settings/dates/school-year/set' , 'sysController@getDateSettings');
	Route::post('/settings/dates/school-year/set' , 'sysController@postDateSettings');
	Route::post('/settings/show/school-years/' , 'sysController@showSchoolYears');

});



	//Admin and secretary route group

Route::group(['middleware' => 'roles', 'roles' => ['Admin','Secretary']],function(){

	//Courses
	Route::get('/courses' , 'sysController@showCourses');
	Route::post('/add-course' , 'sysController@postCourse');


	// violations
	Route::get('/violation', [
		'uses' => 'sysController@showViolation',
		'middleware' => 'roles',
]);



	//Import student records
	Route::get('/student-records', 'StudentRecordsController@importExport');
	Route::get('/student-records/downloadExcel/{type}', 'StudentRecordsController@downloadExcel');
	Route::post('/student-records/importExcel', 'StudentRecordsController@importExcel');
	Route::post('/student-records/list', 'StudentRecordsController@getStudentRecordsTable');

	//Import violation records
	Route::get('/violation-list', 'ViolationRecordsController@importExport');
	Route::get('/violation-list/downloadExcel/{type}', 'ViolationRecordsController@downloadExcel');
	Route::post('/violation-list/truncate' , 'ViolationRecordsController@truncateViolationRecords');
	Route::post('/violation-list/importExcel', 'ViolationRecordsController@importExcel');
	Route::post('/violation-list/all', 'ViolationRecordsController@getViolationRecordsTable');

	//Import Activity Records
	Route::get('/activity-records', 'ActivityRecordsController@importExport');
	Route::get('/activity-records/downloadExcel/{type}', 'ActivityRecordsController@downloadExcel');
	Route::post('/activity-records/importExcel', 'ActivityRecordsController@importExcel');
	Route::post('/activity-records/list', 'ActivityRecordsController@getStudentRecordsTable');
	


});


Route::group(['middleware' => 'roles', 'roles' => ['Admin','Secretary']],function(){

	// Report violation
	Route::get('/report-violation', 'ReportViolationController@showReportViolation');


	//New student
	Route::get('/report-violation/search/course/years', 'ReportViolationController@getCourseYears');
	Route::post('/report-violation/add-student', 'ReportViolationController@newStudentRecord');
	
	//New complainant
	Route::post('/report-violation/add-complainant', 'ReportViolationController@newComplainantRecord');

	//Search
	Route::get('/report-violation/search/student', [
		'as'=> 'autocompleteStudentNo',
		'uses' => 'ReportViolationController@searchStudent',
	]);
	
	Route::get('/report-violation/search/complainant', [
		'as'=> 'autocompleteComplainantID',
		'uses' => 'ReportViolationController@searchComplainant',
	]);

	Route::post('/report-violation/reports','ReportViolationController@getViolationReportsTable');
	Route::get('/report-violation/search/violation', 'ReportViolationController@searchViolation');

	//Gets the request/function, validates the fields.
	Route::get('/report-violation/report', 'ReportViolationController@getReportViolation');
	Route::post('/report-violation/report', 'ReportViolationController@postReportViolation');

	//Post

	Route::post('report-violation/serious/elevate', 'ReportViolationController@elevateToSerious');
	Route::post('/report-violation/offense-no', 'ReportViolationController@showOffenseNo');
	Route::post('/get-violation/list', 'ReportViolationController@getViolations');


	// Community Service
	//Route::get('/communityService', 'sysController@showCommunityService');
	Route::get('/community-service' , 'CommunityServiceController@showCommunityService');
	Route::post('/community-service/search/student' , 'CommunityServiceController@searchStudent');

	Route::get('/community-service/new_log' , 'CommunityServiceController@getStudentLog');
	Route::post('/community-service/new_log' , 'CommunityServiceController@postStudentLog');
	Route::get('/community-service/cs-details' , 'CommunityServiceController@getCommunityServiceDetails');


//Suspension

Route::get('/sanctions/suspend' , 'SanctionController@getSuspension');
Route::post('/sanctions/suspend' , 'SanctionController@postSuspension');

Route::post('/sanctions/suspended_students', 'SanctionController@suspensionTable');
Route::post('/sanctions/excluded_students', 'SanctionController@exclusionTable');

Route::get('/suspension-exclusions/details' , 'SanctionController@getSuspensionDetails');
Route::get('/sanctions/suspended_students/update' , 'SanctionController@getSuspensionUpdate');
Route::post('/sanctions/suspended_students/update' , 'SanctionController@postSuspensionUpdate');

Route::get('/campus', 'CampusVenueReservationController@showCampusVenueReservation');
Route::get('/reservationReports', 'CampusVenueReservationController@showCampusVenueReservationReports');
Route::get('/campus/getCVF_no', 'CampusVenueReservationController@getCVFno');
Route::post('/get-events' , 'CampusVenueReservationController@getEvents');
Route::post('/campus/add', 'CampusVenueReservationController@postCampusVenueReservationAdd');
Route::post('/campus/update', 'CampusVenueReservationController@postCampusVenueReservationUpdate');
Route::post('/campus/reports', 'CampusVenueReservationController@postCampusVenueReservationReports');
// organizations renewal
Route::get('/organizationsRenewal', 'OrganizationsRenewalController@showOrganizationsRenewal');
Route::get('/OrganizationsRenewalList', 'OrganizationsRenewalController@showOrganizationsRenewalList');
Route::get('/OrganizationsRenewalAdd', 'OrganizationsRenewalController@showOrganizationsRenewalAdd');
Route::get('/OrganizationsRenewal/Search', 'OrganizationsRenewalController@searchRequirements');
Route::post('/organizationsRenewal/requirements/all', 'OrganizationsRenewalController@getRequirementsTable');
Route::post('/organizationsRenewal/requirements/specific', 'OrganizationsRenewalController@getRequirementsByName');
Route::post('/organizationsRenewal/requirements/ByYear', 'OrganizationsRenewalController@searchRequirementsByYear');
Route::post('/organizationsRenewal/requirements/ByYearAndStatus', 'OrganizationsRenewalController@searchRequirementsByYearAndStatus');
Route::post('/organizationsRenewal/add', 'OrganizationsRenewalController@postRequirementsRenewalAdd');
Route::post('/organizationsRenewal/update', 'OrganizationsRenewalController@postRequirementsRenewalUpdate');




// monitoring of proposal activities
Route::get('/activities', 'ProposalActivitiesMonitoringController@showProposalActivities');
Route::get('/addActivity', 'ProposalActivitiesMonitoringController@showAddActivity');
// Route::get('/getActivityDetails', 'ProposalActivitiesMonitoringController@getActivityDetails');
Route::get('/activitiesReports', 'ProposalActivitiesMonitoringController@showProposalActivitiesReports');
Route::post('/postAddActivity', 'ProposalActivitiesMonitoringController@postProposalActivitiesAdd');
Route::post('/postUpdateActivity', 'ProposalActivitiesMonitoringController@postProposalActivitiesUpdate');
Route::post('/activities/ActivitiesByYear', 'ProposalActivitiesMonitoringController@getActivitiesByYear');
Route::post('/activities/ActivitiesByYearAndOrg', 'ProposalActivitiesMonitoringController@getActivitiesByYearAndOrg');
Route::post('/activities/ActivitiesByYearAndOrgAndStatus', 'ProposalActivitiesMonitoringController@getActivitiesByYearAndOrgAndStatus');
Route::post('/activities/OrganizationByYear', 'ProposalActivitiesMonitoringController@getOrganizationByYear');

Route::post('/activities/list' , 'ProposalActivitiesMonitoringController@getActivitiesTable');
Route::get('/activities/activity_details' , 'ProposalActivitiesMonitoringController@getActivityDetails');





Route::post('/violation', 'sysController@postViolation');

// Sanction Monitoring

Route::get('/sanctions', 'SanctionController@showSanctions');
Route::get('/sanctions/reports', 'SanctionController@showSanctionsReports');
Route::post('/sanctions/search/student' , 'SanctionController@searchStudent');
Route::post('/sanctions/student-violation/records' ,  'SanctionController@showStudentViolations');
Route::get('/sanctions/violation-details' , 'SanctionController@getViolationDetails');
Route::get('/sanctions/update-status' , 'SanctionController@getUpdateStatus');
Route::post('/sanctions/update-status' , 'SanctionController@postUpdateStatus');


Route::get('/sanctions/add-to-cs' , 'SanctionController@getAddToCS');
Route::post('/sanctions/add-to-cs' , 'SanctionController@postAddToCS');

// Lost and Found 
Route::get('/lost-and-found', [
	'uses' => 'LostAndFoundController@showLostAndFound'
]);

//Lost and Found Tables
Route::post('/lost-and-founds/items/all', 'LostAndFoundController@getLostAndFoundTable');
Route::post('/lost-and-founds/items/reports', 'LostAndFoundController@getLostAndFoundTableReport');
Route::post('/lost-and-founds/items/sort_by=claimed' , 'LostAndFoundController@TableFilterClaimed');
Route::post('/lost-and-founds/items/sort_by=unclaimed' , 'LostAndFoundController@TableFilterUnclaimed');
Route::post('/lost-and-founds/items/sort_by=donated' , 'LostAndFoundController@TableFilterDonated');

//Reports
Route::get('/lost-and-found/statistics', 'LostAndFoundController@showLostAndFoundStatistics');
Route::get('/lost-and-found/reports', 'LostAndFoundController@showLostAndFoundReports');
Route::post('/lost-and-found/reports/list', 'LostAndFoundController@postLostAndFoundReportsTable');

Route::post('/lost-and-found/reports/stats', 'LostAndFoundController@postLostAndFoundStatistics');

Route::get('/lost-and-found/search','LostAndFoundController@searchLostAndFound');

Route::get('/lost-and-found/report-item' , 'LostAndFoundController@getLostAndFoundAdd');
Route::post('/lost-and-found/report-item',[
	'uses' => 'LostAndFoundController@postLostAndFoundAdd',
	'as' => 'report.item'
]);

Route::get('/lost-and-found/item_details', 'LostAndFoundController@getItemDetails');


Route::get('/lostandfound/update', 'LostAndFoundController@getLostAndFoundUpdate');
Route::post('/lostandfound/update', 'LostAndFoundController@postLostAndFoundUpdate');


//Violation Reports
Route::get('/violation-reports' , 'ReportViolationController@showViolationReports');
Route::post('/violation-reports/reports' , 'ReportViolationController@postViolationReports');

//Violation Statistics
Route::get('/violation-statistics' , 'ReportViolationController@showStatistics');
Route::post('/violation-statistics/stats' , 'ReportViolationController@postViolationStatistics');




//Locker Management
Route::get('/lockers' , 'LockerManagementController@showLockers');
Route::post('lockers/add' , 'LockerManagementController@addLockers');
Route::post('/lockers/all' , 'LockerManagementController@showLockersTable');
Route::get('/locker/details' , 'LockerManagementController@getLockerDetails');
Route::post('/locker/update-status' , 'LockerManagementController@updateLocker');
Route::get('/locker-reports' , 'LockerManagementController@showLockerReports');
Route::get('/locker-statistics' , 'LockerManagementController@showLockerStatistics');

Route::post('/locker-reports/list' , 'LockerManagementController@postLockerReportsTable');
Route::post('/locker-reports/stats' , 'LockerManagementController@postLockerStatistics');

Route::get('/settings/locker-locations' , 'LockerManagementController@showLockerLocations');
Route::get('/settings/locker-locations/add' , 'LockerManagementController@getLockerLocations');
Route::post('/settings/locker-locations/add' , 'LockerManagementController@postLockerLocations');

//SMS
Route::get('/text-messaging/compose', 'sysController@showSMS');
Route::post('/text-messaging/send', 'sysController@compose');
Route::get('/text-messaging/server-status' , 'sysController@itexmoStatus');
Route::post('/text-messaging/api_code/update' , 'sysController@updateApiCode');

Route::get('/text-messaging/log' , 'sysController@showSMSLog');
/*Route::post('/getussd' , 'sysController@getussd');

Route::get('/modem-test', function(){
	$a = popen('gammu identify', 'r');  

	while($b = fgets($a, 2048)) { 
		echo $b."<br>\n"; 
		ob_flush();flush(); 
	} 
	pclose($a); 
});	
Route::post('/modem-info', function(){
	$a = popen('gammu monitor 1', 'r');  

	while($b = fgets($a, 2048)) { 
		echo $b."<br>\n"; 
		ob_flush();flush(); 
	} 
	pclose($a); 
});	*/


});




Route::group(['middleware' => 'web'],function(){

	// Authentication routes...
Route::post('/login', 'Auth\AuthController@postLogin');
Route::post('/logout', 'Auth\AuthController@logout');
Route::get('/login', 'Auth\AuthController@getLogin');

// Registration routes...
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');

});
Route::auth();

Route::get('/password_reset/success', function(){
	return view('password_reset_success');
});

