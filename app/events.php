<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class events extends Model
{
    protected $table="events";

    public static function reports($request)
    {
    	if ($request['v_reports_offense_level'] == "" and $request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['venue']=="" and $request['month']==""){
            $data = self::where('school_year',$request['school_year'])
            ->get();
        }
        elseif ($request['v_reports_offense_level'] == "" and $request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['venue']==""){
            $data = self::where('school_year',$request['school_year'])
            ->whereMonth('start', '=',$request['month'])
            ->get();
        }
        elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['venue'] =="" and $request['month']=="" ){
            $data = self::where('school_year',$request['school_year'])
            ->where('status',$request['v_reports_offense_level'])
            ->get();
        }
        elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['venue'] ==""  ){
            $data = self::where('school_year',$request['school_year'])
            ->where('status',$request['v_reports_offense_level'])
            ->whereMonth('start', '=',$request['month'])
            ->get();    
        }
        elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['v_reports_offense_level'] =="" and $request['month']=="" ){
            $data = self::where('school_year',$request['school_year'])
            ->where('venue',$request['venue'])
            ->get();
        }
        elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['v_reports_offense_level'] =="" ){
            $data = self::where('school_year',$request['school_year'])
            ->where('venue',$request['venue'])
            ->whereMonth('start', '=',$request['month'])
            ->get();
        }

        elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['month']==""){
            $data = self::where('school_year',$request['school_year'])
            ->where('venue',$request['venue'])
            ->where('status',$request['v_reports_offense_level'])
            ->get();
        }
        elseif ($request['v_reports_from'] =="" and $request['v_reports_to']==""){
            $data = self::where('school_year',$request['school_year'])
            ->where('venue',$request['venue'])
            ->where('status',$request['v_reports_offense_level'])
            ->whereMonth('start', '=',$request['month'])
            ->get();
        }

        elseif ($request['v_reports_offense_level'] == "" and $request['venue'] =="" ){
            $data = self::whereBetween('start', [$request['v_reports_from'], $request['v_reports_to']])
            ->where('school_year',$request['school_year'])
            ->get();  
        }
        elseif ($request['venue'] ==""){
            $data = self::whereBetween('start', [$request['v_reports_from'], $request['v_reports_to']])
            ->where('school_year',$request['school_year'])
            ->where('status',$request['v_reports_offense_level'])
            ->get();  
        }
        elseif ($request['v_reports_offense_level'] ==""){
            $data = self::whereBetween('start', [$request['v_reports_from'], $request['v_reports_to']])
            ->where('school_year',$request['school_year'])
            ->where('venue',$request['venue'])
            ->get();  
        }
        else{
            $data = self::whereBetween('start', [$request['v_reports_from'], $request['v_reports_to']])
            ->where('status',$request['v_reports_offense_level'])
            ->where('school_year',$request['school_year'])
            ->where('venue',$request['venue'])
            ->get();  

        }    
        return response()->json(['data' => $data]);
    }
}
