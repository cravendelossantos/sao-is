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
		$today = Carbon::now();
		LostAndFound::where('disposal_date','<', $today)->update(['status' => 3]);
		
		$all_items = LostAndFound::all()->where('school_year',$request['school_year']);
		
		return Datatables::of($all_items)
			->editColumn('status', function($item){
				if ($item->status == "Unclaimed"){
                	$badge = '<center><span class="label label-warning"><big>Unclaimed</big></span></center>';
                } elseif ($item->status == "Claimed") {
                	$badge = '<center><span class="label label-primary"><big>Claimed</big></span></center>';
                } else {
                	$badge = '<center><span class="label label-info"><big>Donated</big></span></center>';
                }
                return $badge;
                	
			 
			})
			->make(true);
	}

		public function getLostAndFoundTableReport(Request $request)
	{	
		
		if($request['LAF_stats_from'] == "" and $request['LAF_stats_to'] == "" and $request['sort_by'] == "" )
		{
		$data = LostAndFound::where('school_year',$request['school_year'])->get();
		}
		elseif($request['LAF_stats_from'] == "" and $request['LAF_stats_to'] == ""  )
		{
		$data =  LostAndFound::where('school_year',$request['school_year'])->where('status',$request['sort_by'])->get();
		}
		elseif($request['sort_by'] == "")
		{
		$data = LostAndFound::where('school_year',$request['school_year'])->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->get();
		}
		else
		{
		$data = LostAndFound::where('school_year',$request['school_year'])->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->where('status',$request['sort_by'])->get();	
		}
		return response()->json(['data' => $data]);
	}

	public function TableFilterClaimed(Request $request)
	{
		return Datatables::eloquent(LostAndFound::query()->where('school_year',$request['school_year'])->where('status', 'claimed'))->make(true);	
	}

	public function TableFilterUnclaimed(Request $request)
	{
		return Datatables::eloquent(LostAndFound::query()->where('school_year',$request['school_year'])->where('status', 'unclaimed'))->make(true);	
	}

	public function TableFilterDonated(Request $request)
	{
		return Datatables::eloquent(LostAndFound::query()->where('school_year',$request['school_year'])->where('status', 'donated'))->make(true);	
	}

	public function searchLostAndFound(Request $request)
	{
		$item = $request->input('searchBox');
		$lostandfound_table = DB::table('lost_and_founds')->where('item_description', 'like', '%' .$item. '%')->get();
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


		$lost_and_found = DB::table('lost_and_founds')->where('id', $request['claim_id'])->update([			
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
		
		/*$requested_date = $request['month'];
		$date_start = Carbon::parse($requested_date)->startOfMonth();
		$date_end = Carbon::parse($requested_date)->endOfMonth();  */
if($request['LAF_stats_from'] == "" and $request['LAF_stats_to'] == ""){
			$claimed = LostAndFound::where('status', 'claimed')
		->where('school_year',$request['school_year'])
		->count();

		$unclaimed = LostAndFound::where('status', 'unclaimed')
		->where('school_year',$request['school_year'])
		->count();

		$donated = LostAndFound::where('status', 'donated')
		->where('school_year',$request['school_year'])
		->count();


		$total = LostAndFound::where('school_year',$request['school_year'])
		->count();
		

		

			//into objects..
		$data = [
		[	'claimed' => $claimed, 
		'unclaimed' => $unclaimed,
		'donated' => $donated,  
		'total' => $total, 
		'from'=>$request['LAF_stats_from'], 
		'to'=>$request['LAF_stats_to']
		]
		];

}
		
else{

	$claimed = LostAndFound::where('status', 'claimed')
		->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->where('school_year',$request['school_year'])
		->count();

		$unclaimed = LostAndFound::where('status', 'unclaimed')
		->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->where('school_year',$request['school_year'])
		->count();

		$donated = LostAndFound::where('status', 'donated')
		->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->where('school_year',$request['school_year'])
		->count();


		$total = LostAndFound::whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->where('school_year',$request['school_year'])
		->count();
		

		

			//into objects..
		$data = [
		[	'claimed' => $claimed, 
		'unclaimed' => $unclaimed,
		'donated' => $donated,  
		'total' => $total, 
		'from'=>$request['LAF_stats_from'], 
		'to'=>$request['LAF_stats_to']
		]
		];

}
		
		

		return response()->json(['data' => $data]);


	}

	public function postLostAndFoundStatistics(Request $request)
	{

			/*$claimed = LostAndFound::where('status', 'claimed')
					->whereBetween('created_at', [$date_start, $date_end])
					->count();

			$unclaimed = LostAndFound::where('status', 'unclaimed')
					->whereBetween('created_at', [$date_start, $date_end])
					->count();

			$total = LostAndFound::whereBetween('created_at', [$date_start, $date_end])
			->count();*/

			/*$requested_date = $request['month'];
			$date_start = Carbon::parse($requested_date)->startOfMonth();
			$date_end = Carbon::parse($requested_date)->endOfMonth();  */

if($request['LAF_stats_from'] == "" and $request['LAF_stats_to'] == "")
		{
					$claimed = LostAndFound::where('status', 'claimed')
		->where('school_year',$request['school_year'])
		->count();

		$unclaimed = LostAndFound::where('status', 'unclaimed')
		->where('school_year',$request['school_year'])
		->count();

		$donated = LostAndFound::where('status', 'donated')
		->where('school_year',$request['school_year'])
		->count();


			$data= 
			[	'claimed' => $claimed, 
		'unclaimed' => $unclaimed,
		'donated' => $donated,  

		];
		

		}
else
		{		
	$claimed = LostAndFound::where('status', 'claimed')
		->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->where('school_year',$request['school_year'])
		->count();

		$unclaimed = LostAndFound::where('status', 'unclaimed')
		->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->where('school_year',$request['school_year'])
		->count();

		$donated = LostAndFound::where('status', 'donated')
		->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])->where('school_year',$request['school_year'])
		->count();


			$data= 
			[	'claimed' => $claimed, 
		'unclaimed' => $unclaimed,
		'donated' => $donated,  

		];}

			

			return response()->json($data); 

		}
		
		
	}
