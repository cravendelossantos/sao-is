<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Auth;
use Yajra\Datatables\Facades\Datatables;

class Locker extends Model
{

	public $timestamps = false;

    public function location()
    {
    	return $this->belongsTo('App\LockerLocation', 'id' , 'location_id');
    }

    public static function table($request)
    {
    	self::where('status', 'Occupied')
        ->where('end_of_contract', '<', Carbon::now()->format('Y-m-d'))
        ->update(['status' => 'Available', 'updated_by' => Auth::user()->id,
            'lessee_id' => null, 'lessee_name' => null, 'start_of_contract' => null, 'end_of_contract' => null]);

        if ( $request['status_sort'] ==  "" && $request['location_sort'] == ""){
            $lockers = DB::table('lockers')
            ->join('locker_locations' , 'lockers.location_id', '=', 'locker_locations.id');
        }
        else if ( $request['status_sort'] ==  ""){
            $lockers = DB::table('lockers')
            ->join('locker_locations' , 'lockers.location_id', '=', 'locker_locations.id')
            ->where('location_id' ,$request['location_sort']);
        } 
        else if ($request['location_sort'] == ""){
            $lockers = DB::table('lockers')->join('locker_locations' , 'lockers.location_id', '=', 'locker_locations.id')
            ->where('status', $request['status_sort']);
        }
        else{
            $lockers = DB::table('lockers')
            ->join('locker_locations' , 'lockers.location_id', '=', 'locker_locations.id')
            ->where('status', $request['status_sort'])
            ->where('location_id' ,$request['location_sort']);
        }

        return Datatables::of($lockers)
            ->editColumn('status', function($locker){
                if ($locker->status == "Occupied"){
                    $badge = '<center><span class="label label-info"><big>Occupied</big></span></center>';
                } 
                if ($locker->status == "Available") {
                    $badge = '<center><span class="label label-primary"><big>Available</big></span></center>';
                } 
                if ($locker->status == "Locked") {
                    $badge = '<center><span class="label label-warning"><big>Locked</big></span></center>';
                }  
                if ($locker->status == "Damaged") {
                    $badge = '<center><span class="label label-danger"><big>Damaged</big></span></center>';
                }
                return $badge;
            })
            ->addColumn('action', function ($locker) {
                return '<center><a href="#edit-'.$locker->locker_no.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
        <a href="#delete-'.$locker->locker_no.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Edit</a></center>';
            })
            ->make(true);
    }

    public static function reports($request)
    {
    	$total = DB::table('lockers')->select('status')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->count();

        $available = DB::table('lockers')->select('status')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->where('status' , 'Available')
        ->count();

        $occupied = DB::table('lockers')->select('status')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->where('status' , 'occupied')
        ->count();

        $locked = DB::table('lockers')->select('status')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->where('status' , 'locked')
        ->count();

        $damaged = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->where('status' , 'damaged')
        ->count();

        $data = [
        [ 'total' => $total, 
        'available' => $available,
        'occupied' =>$occupied,
        'locked' => $locked,
        'damaged' => $damaged ]
        ];

        return response()->json(['data' => $data]);
    }

    public static function statistics($request)
    {
    	$total = DB::table('lockers')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->count();

        $available = DB::table('lockers')->select('status')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->where('status' , 'Available')
        ->count();

        $occupied = DB::table('lockers')->select('status')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->where('status' , 'occupied')
        ->count();
    
        $locked = DB::table('lockers')->select('status')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->where('status' , 'locked')
        ->count();

        $damaged = DB::table('lockers')->select('status')
        ->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
        ->where('status' , 'damaged')
        ->count();

        $data = [
        'total' => $total, 
        'available' => $available,
        'occupied' =>$occupied,
        'locked' => $locked,
        'damaged' => $damaged,
        ];

        return response()->json($data); 
    }

}
