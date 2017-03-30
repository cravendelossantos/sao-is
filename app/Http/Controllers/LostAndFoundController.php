<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\User;
use App\LostAndFound;
use App\SchoolYear;
use Carbon\Carbon;
use DateTime;
use Validator;
use Auth;
use Yajra\Datatables\Facades\Datatables;
use Khill\Lavacharts\Lavacharts;
use Response;

class LostAndFoundController extends Controller
{
	public function __construct()
	{
		$this->middleware('roles');
	}

	public function showLostAndFound()
	{    
		$current_school_year = SchoolYear::currentSchoolYear();    	
		return view('lost_and_found',['current_school_year' => $current_school_year ]);
	}
	
	public function getLostAndFoundTable(Request $request)
	{	
		return LostAndFound::table($request);
	}

	public function getLostAndFoundTableReport(Request $request)
	{	
		return LostAndFound::reports($request);	
	}

	public function searchLostAndFound(Request $request)
	{
		$item = $request->input('searchBox');
		$lostandfound_table = DB::table('lost_and_founds')
		->where('item_description', 'like', '%' .$item. '%')
		->get();
		return view('tables.lost_and_founds_table', ['lostandfoundTable' => $lostandfound_table ]);
	}

	public function getItemDetails(Request $request)
	{
		$item = LostAndFound::where('id', $request['id'])->first();
		return response()->json(array('response' => $item));
	}
	
	public function getLostAndFoundAdd(Request $request)
	{
		$tomorrow = Carbon::tomorrow()->format('y-m-d');

		$messages = [
		'date_reported.before' => 'Date must be not greater than today.',
		'time_reported.date_format' => 'Invalid time format',
		];

		$validator = Validator::make($request->all(),[
			'date_reported' => 'required|date|before:' .$tomorrow,
			'time_reported' => 'required|date_format:h:ia',
			'itemName' => 'required|string|max:255',
			'distinctive_marks' => 'required|string|max:255',
			'endorserName' => 'required|string|max:255',
			'foundAt' => 'required|string',
		],$messages);

		if ($validator->fails()) {
			return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 	
		}
	}


	public function postLostAndFoundAdd(Request $request)
	{
		$now = Carbon::now();
		
		$report = new LostAndFound();
		$report->time_reported = Carbon::parse($request['time_reported'])->format('H:I');
		$report->date_reported = $request['date_reported'];
		$report->school_year = $request['school_year'];
		$report->item_description =  ucwords($request['itemName']);
		$report->distinctive_marks = ucwords($request['distinctive_marks']);
		$report->endorser_name = ucwords($request['endorserName']);
		$report->found_at = ucwords($request['foundAt']);
		$report->owner_name = ucwords($request['ownerName']);
		$report->status = '1';
		$report->reporter_id = Auth::user()->id;
		$report->disposal_date = $now->addDays(60);
		$report->save();

		return response()->json(array(
			'success' => true,
			'response' => $report
		));
	}
	
	public function getLostAndFoundUpdate(Request $request)
	{
		$validator = Validator::make($request->all(),[
			'claimer_name' => 'required|string|max:255',                   
		]);

		if ($validator->fails()) {			
			return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
		}
	}

	public function postLostAndFoundUpdate(Request $request)
	{	
		$lost_and_found = DB::table('lost_and_founds')
		->where('id', $request['claim_id'])->update([			
			'claimer_name' => ucwords($request['claimer_name']),
			'status' => 'Claimed',
			'date_claimed' => Carbon::now(),
			'claimed_reporter_id' => Auth::user()->id,
		]);

		return Response::json(['success' => true, 'response' => $lost_and_found], 200);				
	}

	public function showLostAndFoundStatistics()
	{
 	   	$current_school_year = SchoolYear::currentSchoolYear();
       	$school_year_selection = SchoolYear::schoolYearSelection();
       	$signees = User::all();

		return view('lost_and_found_statistics',['school_year_selection' => $school_year_selection],['current_school_year' => $current_school_year, 'signees' => $signees]);
	}	

	public function showLostAndFoundReports(Request $request)
	{	
		$current_school_year = SchoolYear::currentSchoolYear();
       	$school_year_selection = SchoolYear::schoolYearSelection();
       	$signees = User::all();

		return view('lost_and_found_reports',['school_year_selection' => $school_year_selection],['current_school_year' => $current_school_year, 'signees' => $signees]);
	}

	public function postLostAndFoundReportsTable(Request $request)
	{
		return LostAndFound::statisticsTable($request);		
	}

	public function postLostAndFoundStatistics(Request $request)
	{
		return LostAndFound::statisticsData($request);	
	}
		
}
