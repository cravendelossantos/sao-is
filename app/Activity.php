<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class Activity extends Model
{
    protected $table="activities";

    public static function filterYear($request)
    {
    	return Datatables::eloquent(self::query()
        ->where('school_year',$request['school_year']))
        ->editColumn('status', function($act){
            if ($act == true){
                $badge = '<center><span class="label label-primary"><big>Submitted</big></span></center>';
            }  
            else {
                $badge = '<center><span class="label label-danger"><big>Not Submitted</big></span></center>';
            }   
            return $badge;
        })
        ->addColumn('action', function ($students) {
        return '<center><a href="#edit-'.$students->rv_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
    <a href="#delete-'.$students->rv_id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Edit</a></center>';
        })
        ->make(true);
    }

    public static function filterYearAndOrganization($request)
    {
    	return Datatables::eloquent(self::query()
        ->where('school_year',$request['school_year'])
        ->where('organization',$request['organization']))
        ->editColumn('status', function($act){
            if ($act == true){
                $badge = '<center><span class="label label-primary"><big>Submitted</big></span></center>';
            }  
            else{
                $badge = '<center><span class="label label-danger"><big>Not Submitted</big></span></center>';
            }
            return $badge;
        })
        ->addColumn('action', function ($students) {
        return '<center><a href="#edit-'.$students->rv_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
    <a href="#delete-'.$students->rv_id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Edit</a></center>';
        })
        ->make(true);
    }

    public static function filterYearOrganizationAndStatus($request)
    {
    	if ($request['sort_by'] == ""){
            $data = self::where('school_year',$request['school_year'])->get();
        }
        else if ($request['organizationName'] == 0){
            $data = self::where('school_year',$request['school_year'])
            ->where('status',$request['sort_by'])
            ->get();
        }
        else{
            $data = self::where('school_year',$request['school_year'])
            ->where('organization',$request['organization'])
            ->where('status',$request['sort_by'])
            ->get();
        }
        return response()->json(['data' => $data]);
    }
}
