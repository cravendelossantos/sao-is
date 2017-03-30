<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class ViolationReport extends Model
{
	public $timestamps = false;
	
    public function students()
    {
    	return $this->belongsToMany('App\Student');
    }

    public function violations()
    {
    	return $this->hasMany('App\Violation');
    }

    public static function maxViolationId()
    {
        $id = self::select(DB::raw('max(cast((substring(rv_id, 8)) as UNSIGNED)) as max_id'))->first();
            
            if ($id == null){
                $id = 'SAO_VR-1';
            }
            else{
                $id = $id->max_id;
                $id = 'SAO_VR-'.++$id;
            } 

        return $id;
    }

    public static function violationReports($request)
    {
        $violations = self::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')
            ->join('courses', 'students.course' , '=' , 'courses.description')
            ->join('colleges', 'courses.college_id' , '=' , 'colleges.id');
            
            
        return Datatables::of($violations)
        ->filter(function ($query) use ($request) {
            if ($request->has('v_reports_from') && $request->has('v_reports_to')) {
                $query->whereBetween('date_reported', [$request->get('v_reports_from'), $request->get('v_reports_to')]);
            }
            if ($request->has('v_reports_offense_level')) {
                $query->where('violation_reports.offense_level', $request->get('v_reports_offense_level'));
            }
            if ($request->has('v_reports_college')) {
                $query->where('colleges.id', $request->get('v_reports_college'));
            }
            if ($request->has('v_reports_course')) {
                $query->where('courses.description', $request->get('v_reports_course'));
            }
            if ($request->has('school_year')) {
                $query->where('violation_reports.school_year', $request->get('school_year'));
            }
        })
        ->make(true);
    }

    public static function violationStatistics($request)
    {
        if($request['v_stats_from'] == "" and $request['v_stats_to'] == ""){
            $cams = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 1)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();  

            $cas = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 2)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count(); 

            $cba = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 3)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();                                 

            $coecsa = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 4)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();  

            $cithm = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 5)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();   

            $data = [[   
            'cams' => $cams, 
            'cas' => $cas,
            'cba' => $cba,
            'coecsa' => $coecsa,
            'cithm' => $cithm,
            ]];
        
            $stats = [  
                ['1' ,$cams], 
                ['2', $cas],
                ['3' , $cba],
                ['4' , $coecsa],
            ];
        }
        else{
            $cams = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 1)
            ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();  

            $cas = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 2)
            ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
            ->where('violation_reports.school_year',$request['school_year'])
            ->count(); 

            $cba = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 3)
            ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();                                 

            $coecsa = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 4)
            ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();  

            $cithm = self::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 5)
            ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();   

            $data = [[ 
            'cams' => $cams, 
            'cas' => $cas,
            'cba' => $cba,
            'coecsa' => $coecsa,
            'cithm' => $cithm,
            ]];
        
            $stats = [
            ['1' ,$cams], 
            ['2', $cas],
            ['3' , $cba],
            ['4' , $coecsa],
            ];
        }
        return response()->json(['data' => $data, 'stats' => $stats]);    
    }

    public static function table($request)
    {
        $violations = self::join('students', 'violation_reports.student_id', '=', 'students.student_no')
            ->join('violations', 'violation_reports.violation_id', '=', 'violations.id')
            ->Join('complainants', 'violation_reports.complainant_id', '=', 'complainants.id_no')
            ->select(['violation_reports.rv_id' , 'violation_reports.student_id', 'violation_reports.offense_no', 'violation_reports.offense_level', 'violation_reports.date_reported', 'violation_reports.status', 'violations.name', 'violations.description', 'violations..sanction', 'complainants.complainant_name', 'complainants.id_no', 'complainants.position',
                DB::raw("CONCAT(students.first_name,' ',students.last_name)  AS student_name")]);
        
        return Datatables::of($violations) 
            ->editColumn('offense_level', function($violation){
                if ($violation->offense_level == "Less Serious"){
                    $badge = '<center><span class="label label-info"><big>Less Serious</big></span></center>';
                } elseif ($violation->offense_level == "Serious") {
                    $badge = '<center><span class="label label-warning"><big>Serious</big></span></center>';
                } else {
                    $badge = '<center><span class="label label-danger"><big>Very Serious</big></span></center>';
                }
                    return $badge;
            })
            ->editColumn('description', function($violation){
                return '<p>'. $violation->description .'</p>';
            })
            ->editColumn('sanction', function($violation){
                return '<p>'. $violation->sanction .'</p>';
            })
            ->editColumn('complainant_details', function($complainant){
                return '<p>'. $complainant->complainant_name. "<br>".$complainant->id_no. " (". $complainant->position.')</p>';
            })
            ->editColumn('offense_no', function($violation){
                return '<center>'. $violation->offense_no .'</center>';
            })
            ->addColumn('action', function ($students) {
                return '<center><a href="#edit-'.$students->rv_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                    <a href="#delete-'.$students->rv_id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Edit</a></center>';
            })
            ->filterColumn('student_name', function($query, $keyword) {
                $query->whereRaw("CONCAT(students.first_name,' ',students.last_name) like ?", ["%{$keyword}%"]);
            })
            ->make(true);
    }

    public static function offenseCount($request)
    {
        $student_number = $request['student_number'];
        $violation_id = $request['violation_id'];
   
        $same_violation = DB::table('violation_reports')
            ->where('student_id', $student_number)
            ->where('violation_id', $violation_id)
            ->where('violation_id', $violation_id)
            ->max('offense_no');

        $different_violations = DB::table('violation_reports')
            ->where('student_id', $student_number)
            ->where('offense_level', $request['offense_level'])
            ->count(DB::raw('DISTINCT violation_id'));

        $total_serious_offense_no = DB::table('violation_reports')
            ->where('student_id', $student_number)
            ->where('offense_level', 'Serious')
            ->count();

        if ($same_violation == null) {
            $offense_number = $same_violation +=1;
            $sanction = DB::table('violations')
            ->select('first_offense_sanction as sanction')
            ->where('id', $violation_id)
            ->first(); 
        }
        else if ($same_violation == 1) {
            $offense_number = $same_violation +=1;
            $sanction = DB::table('violations')
            ->select('second_offense_sanction as sanction')
            ->where('id', $violation_id)
            ->first(); 
        } 
        else if ($same_violation == 2) {
            $offense_number = $same_violation +=1;
            $sanction = DB::table('violations')
            ->select('third_offense_sanction as sanction')
            ->where('id', $violation_id)
            ->first(); 
        } 
        else if ($same_violation == 3) {
            $offense_number = $same_violation +=1;
            $sanction = DB::table('violations')
            ->select('third_offense_sanction as sanction')
            ->where('id', $violation_id)
            ->first(); 
        } 
        else {
            $sanction = array('sanction' => 'Please check the sanction(s) of the selected student in Sanctions Monitoring Menu');
        }

        if ($different_violations == 1){
            $different_violations = $different_violations;
        }

        return response(array('offense_no' => $same_violation , 'sanction' => $sanction, 'diff_type_offense' => $different_violations, 'total_serious_offense_no' => $total_serious_offense_no));
    }
}
