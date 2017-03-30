<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sanction extends Model
{
    public static function findStudent($request)
    {
    	$sanctions_student = ViolationReport::select('*')
            ->join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('violations', 'violation_reports.violation_id', '=', 'violations.id');
                                               
        return Datatables::of($sanctions_student)
            ->editColumn('status', function($violation_status){
                if ($violation_status->status == "Pending"){
                    $badge = '<center><span class="label label-warning"><big>Pending</big></span></center>';
                } elseif ($violation_status->status == "On Going") {
                    $badge = '<center><span class="label label-info"><big>On Going</big></span></center>';
                } else {
                    $badge = '<center><span class="label label-success"><big>Completed</big></span></center>';
                }
                    return $badge;
            })
            ->editColumn('rv_id', function($data){
                return '<p>'. $data->rv_id .'</p>';
            })
            ->editColumn('offense_no', function($data){
                return '<center>'. $data->offense_no .'</center>';
            })
            ->editColumn('student_details', function($student){
                return '<p>'. $student->first_name. " " .$student->last_name. ' ('. $student->current_status . ') <br>'. $student->student_no. '<br>' . $student->year_level .' Year / '. $student->course .'</p>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('sanction_student_no') and $request->has('v_reports_offense_level')){
                    $query->where('student_id', 'like', "%{$request->get('sanction_student_no')}%")->where('violation_reports.offense_level' , $request['v_reports_offense_level']);
                }else{
                    $query->where('student_id', 'like', "%{$request->get('sanction_student_no')}%");
                }
                

            })
            ->make(true);
    }
}
