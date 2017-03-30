<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;

class LostAndFound extends Model
{
	protected $fillable = ['item_description','endorser_name','founded_at','owner_name'];
	
	public $timestamps = false;

    public function user()
	{
		return $this->belongsTo('App\User');
	}

	public static function table($request)
	{
		$today = Carbon::now();
		self::where('disposal_date','<', $today)->update(['status' => 3]);
		
		if ($request['status'] == "All"){
			$all_items = self::where('school_year', $request['school_year']);
		} 
		else {
			$all_items = self::where('school_year',$request['school_year'])
			->where('status', $request['status']);
		}
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

	public static function reports($request)
	{
		if($request['LAF_stats_from'] == "" and $request['LAF_stats_to'] == "" and $request['sort_by'] == "" ){
			$data = self::where('school_year',$request['school_year'])
			->get();
		}
		else if($request['LAF_stats_from'] == "" and $request['LAF_stats_to'] == ""  ){
			$data =  self::where('school_year',$request['school_year'])
			->where('status',$request['sort_by'])
			->get();
		
		}
		else if($request['sort_by'] == ""){
			$data = self::where('school_year',$request['school_year'])
			->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->get();
		}
		else{
			$data = self::where('school_year',$request['school_year'])
			->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->where('status',$request['sort_by'])
			->get();	
		}
		return response()->json(['data' => $data]);
	}

	public static function statisticsTable($request)
	{
		if($request['LAF_stats_from'] == "" and $request['LAF_stats_to'] == ""){
			$claimed = self::where('status', 'claimed')
			->where('school_year',$request['school_year'])
			->count();

			$unclaimed = self::where('status', 'unclaimed')
			->where('school_year',$request['school_year'])
			->count();

			$donated = self::where('status', 'donated')
			->where('school_year',$request['school_year'])
			->count();

			$total = self::where('school_year',$request['school_year'])
			->count();
		

			$data = [[
				'claimed' => $claimed, 
				'unclaimed' => $unclaimed,
				'donated' => $donated,  
				'total' => $total, 
				'from'=>$request['LAF_stats_from'], 
				'to'=>$request['LAF_stats_to']
			]];
		}
		else{
			$claimed = self::where('status', 'claimed')
			->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->where('school_year',$request['school_year'])
			->count();

			$unclaimed = self::where('status', 'unclaimed')
			->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->where('school_year',$request['school_year'])
			->count();

			$donated = self::where('status', 'donated')
			->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->where('school_year',$request['school_year'])
			->count();

			$total = self::whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->where('school_year',$request['school_year'])
			->count();
	
			$data = [[
			'claimed' => $claimed, 
			'unclaimed' => $unclaimed,
			'donated' => $donated,  
			'total' => $total, 
			'from'=>$request['LAF_stats_from'], 
			'to'=>$request['LAF_stats_to']
			]];
		}
		return response()->json(['data' => $data]);
	}

	public static function statisticsData($request)
	{
		if($request['LAF_stats_from'] == "" and $request['LAF_stats_to'] == ""){
			$claimed = self::where('status', 'claimed')
			->where('school_year',$request['school_year'])
			->count();

			$unclaimed = self::where('status', 'unclaimed')
			->where('school_year',$request['school_year'])
			->count();

			$donated = self::where('status', 'donated')
			->where('school_year',$request['school_year'])
			->count();

			$data = [	
			'claimed' => $claimed, 
			'unclaimed' => $unclaimed,
			'donated' => $donated,  
			];
		}
		else{		
			$claimed = self::where('status', 'claimed')
			->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->where('school_year',$request['school_year'])
			->count();
			
			$unclaimed = self::where('status', 'unclaimed')
			->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->where('school_year',$request['school_year'])
			->count();

			$donated = self::where('status', 'donated')
			->whereBetween('date_reported', [$request['LAF_stats_from'], $request['LAF_stats_to']])
			->where('school_year',$request['school_year'])
			->count();

			$data = [	
			'claimed' => $claimed, 
			'unclaimed' => $unclaimed,
			'donated' => $donated,  
			];
		}
		return response()->json($data); 
	}

}
