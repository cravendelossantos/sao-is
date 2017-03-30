<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class Requirements extends Model
{
    protected $table="requirements";

    public static function filterYear($request)
    {
    	return Datatables::eloquent(self::query()
        ->where('school_year',$request['school_year']))
        ->addColumn('action', function ($req) {
        return '<center><a href="#edit-'.$req->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
        <a href="#delete-'.$req->id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Edit</a></center>';
        })
        ->make(true);
    }

    public static function filterYearAndStatus($request)
    {
    	if ($request['sort_by'] == "All"){
            $data = DB::table('requirements')
            ->where('school_year',$request['school_year'])
            ->get();
        }
        else if ($request['sort_by'] == "Submitted All Requirements"){
            $data = DB::table('requirements')
            ->where('school_year',$request['school_year'])
            ->where('requirement1',1)
            ->where('requirement2',1)
            ->where('requirement3',1)
            ->where('requirement4',1)
            ->where('requirement5',1)
            ->where('requirement6',1)
            ->where('requirement7',1)
            ->where('requirement8',1)
            ->where('requirement9',1)->get();
        }
        else if ($request['sort_by'] == "Not Submitted All Requirements"){
            $data = DB::table('requirements')
            ->where('school_year',$request['school_year'])
            ->where('requirement1',0)
            ->orWhere('requirement1',0)
            ->where('requirement2',1)
            ->orWhere('requirement2',0)
            ->where('requirement3',1)
            ->orWhere('requirement3',0)
            ->where('requirement4',1)
            ->orWhere('requirement4',0)
            ->where('requirement5',1)
            ->orWhere('requirement5',0)
            ->where('requirement6',1)
            ->orWhere('requirement6',0)
            ->where('requirement7',1)
            ->orWhere('requirement7',0)
            ->where('requirement8',1)
            ->orWhere('requirement8',0)
            ->where('requirement9',1)
            ->orWhere('requirement9',0)
            ->get();
        }
        return response()->json(['data' => $data]);
    }
}
