<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use DB;
use App\User;
use App\LostAndFound;
use App\Student;
use App\Violation;
use App\ViolationReport;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;
use DateTime;
use Response;
use App\SchoolYear;
use App\College;
use App\Course;
use App\Complainant;
use App\Role;
use Auth;


class ReportViolationController extends Controller
{
    public function __construct()
    {
   	    $this->middleware('roles');
        $this->middleware('auth');
    }
    
 	public function showReportViolation()
    {

        $max_violation_id = ViolationReport::maxViolationId();  
        $current_school_year = SchoolYear::currentSchoolYear();
        $courses = Course::with('college')->get();

        if (Auth::user()->roles()->first()->id == 2){
            $violations = Violation::all()->where('offense_level', 'Less Serious')->sortBy('name');
        } else {
            $violations = Violation::all()->sortBy('name');
        }    
        
        return view('report_violation', ['violations' => $violations , 'courses' => $courses, 'violation_id' => $max_violation_id],['current_school_year' => $current_school_year]);
    }
	
    public function getViolations(Request $request)
    {
        $violations = Violation::where('offense_level', $request['offense_level'])->get();
        return response(array('violations' => $violations));
    }   

    public function getViolationReportsTable(Request $request)
    {
        $violations = ViolationReport::join('students', 'violation_reports.student_id', '=', 'students.student_no')
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
         /*   ->editColumn('student_name', function($student){
                return $student->first_name. " " .$student->last_name;
            })*/
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



    public function newStudentRecord(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'studentNo' => array('required', 'regex:/^[0-9\s-]+$/', 'unique:students,student_no'),
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'yearLevel' => 'required',
            'course' => 'required',            
        ]);
     
        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray()));   
        } else {

            if ($request['guardianContactNo'] == ""){
                $guardian_contact = "";
            } else {
                $guardian_contact = "+63".$request['guardianContactNo'];
            }

            $new_student_record = new Student();
            $new_student_record->student_no = $request['studentNo'];
            $new_student_record->first_name = ucwords($request['firstName']);
            $new_student_record->last_name = ucwords($request['lastName']);
            $new_student_record->year_level = $request['yearLevel'];
            $new_student_record->course = $request['course'];
            $new_student_record->student_contact_no = "+63".$request['studentContactNo'];
            $new_student_record->guardian_name = ucwords($request['guardianName']);
            $new_student_record->guardian_contact_no = $guardian_contact;
            $new_student_record->date_created = Carbon::now();
            $new_student_record-> save();
            
            return response()->json(array(['success' => true, 'response' => $new_student_record]));
        }
    }


    public function newComplainantRecord(Request $request)
    {
        $messages = [
            'complainantNo.required.taken' => 'The Complainant ID is already taken',
        ];

        $validator = Validator::make($request->all(),[
            'complainantId' => array('required', 'regex:/^[0-9a-zA-Z\s-]+$/', 'unique:complainants,id_no'),
            'complainantName' => 'required|string',
            'complainantPosition' => 'required',
        ]);
     
        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray()));           
        } else {
           
            $new_complainant_record = new Complainant();
            $new_complainant_record->id_no = $request['complainantId'];
            $new_complainant_record->complainant_name = ucwords($request['complainantName']);
            $new_complainant_record->position = $request['complainantPosition'];
            $new_complainant_record-> save();
            
            return response()->json(array(['success' => true, 'response' => $new_complainant_record]));  
        }
    }

    public function searchStudent(Request $request)
    {
        $term = $request->term;
    
        $data = Student::where('student_no', $term)->get();
     
        $result = array();
        
        foreach ($data as $key => $value)
        {
            $result[] = [   'value' => $value->student_no, 
                            'l_name' => $value->last_name, 
                            'f_name' => $value->first_name,
                            'course' => $value->course,
                            'year_level' =>$value->year_level,
                            'current_status' => $value->current_status,
                            'guardian_name' =>$value->guardian_name,
                            'guardian_contact_no' => $value->guardian_contact_no,
                        ];

        }
        
        return response()->json($result);
    }

    public function searchComplainant(Request $request)
    {
      
        $term = $request->term;
    
        $data = Complainant::where('id_no', $term)->take(5)->get();
      
        $result=array();
        
        foreach ($data as $key => $value)
        {
            $result[]=[ 'value' => $value->id_no, 
                        'name' => $value->complainant_name, 
                        'position' => $value->position,
                     
                      ];

        }

        return response()->json($result);

    }
   
   public function showOffenseNo(Request $request)
   {
        $student_number = $request['student_number'];
        $violation_id = $request['violation_id'];

   
        $same_violation = DB::table('violation_reports')
            ->where('student_id', $student_number)->where('violation_id', $violation_id)->where('violation_id', $violation_id)->max('offense_no');


        $different_violations = DB::table('violation_reports')
            ->where('student_id', $student_number)
            ->where('offense_level', $request['offense_level'])->count(DB::raw('DISTINCT violation_id'));

      
        $total_serious_offense_no = DB::table('violation_reports')
            ->where('student_id', $student_number)
            ->where('offense_level', 'Serious')->count();//consider the whole sem


        if ($same_violation == null) {
            $offense_number = $same_violation +=1;
            $sanction = DB::table('violations')->select('first_offense_sanction as sanction')->where('id', $violation_id)->first(); 
        } else if ($same_violation == 1) {
            $offense_number = $same_violation +=1;
            $sanction = DB::table('violations')->select('second_offense_sanction as sanction')->where('id', $violation_id)->first(); 
        } else if ($same_violation == 2) {
            $offense_number = $same_violation +=1;
            $sanction = DB::table('violations')->select('third_offense_sanction as sanction')->where('id', $violation_id)->first(); 
        } else if ($same_violation == 3) {
            $offense_number = $same_violation +=1;// pang 4th na
            $sanction = DB::table('violations')->select('third_offense_sanction as sanction')->where('id', $violation_id)->first(); 
        } else {
            $sanction = array('sanction' => 'Please check the sanction(s) of the selected student in Sanctions Monitoring Menu');
        }

        if ($different_violations == 1)
        {
            $different_violations = $different_violations;
            // 2 + 1 = 3rd diff type
        }

        return response(array('offense_no' => $same_violation , 'sanction' => $sanction, 'diff_type_offense' => $different_violations, 'total_serious_offense_no' => $total_serious_offense_no));
    
    }

    public function searchViolation(Request $request)
    {
        $search_violation = DB::table('violations')->where('name', $request['violation'])->first();
    
        return response()->json(['response' => $search_violation]);

    }
 	
    public function getReportViolation(Request $request)
    {
        $tomorrow = Carbon::tomorrow()->format('y-m-d');
     
        $messages = [
            'student_number.required' => 'The student number and information is required.',
            'violation.required' => 'Please check violation details.',
            'date_committed.before' => 'Date must be not greater than today.',
            'complainant_id.required' => 'The complainant details is required.',
            'time_reported.date_format' => 'Invalid time format',
        ];

        $validator = Validator::make($request->all(),[
            'student_number' => 'required|alpha_dash|max:255',
            'violation' => 'required|string|max:255',
            'date_committed' => 'required|date|before:' .$tomorrow,
            'complainant_id' => 'required',
            'time_reported' => 'required|date_format:h:ia'

        ],$messages);
     
        if ($validator->fails()) {
            return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400);   
        }
    }


	public function postReportViolation(Request $request)
	{            
        if ($request['offense_level'] == 'Less Serious'){
            $from = SchoolYear::select('end')
                ->where('term_name' , 'School Year')
                ->first();
            $to = SchoolYear::select('start')
                ->where('term_name' , 'School Year')
                ->first();

            $validity = $from . " " . $to;
            $notification = "No message request";
            $message = "";
        } else if ($request['offense_level'] == 'Serious' || $request['offense_level'] == 'Very Serious') {
            //SEND NOTIF
            $student = Student::where('student_no', $request['student_number'])->first();
            $api_key = DB::table('itexmo_key')->first();
            $message_type = "Violation Notification";
            $guardian_number = $student->guardian_contact_no;

            if ($student->guardian_contact_no == ""){
                $notification[] = ['response' => "Message is not sent. Guardian number is not available"];
                $message = "";
            } else {
    
                if (strpos($guardian_number, '+63') !== false) {
                    $guardian_number = str_replace("+63", "0", $guardian_number);          
                }
                
                $message = "From LPU Cavite Student Affairs Office\r\n"."\r\nWe would like to inform you that your son/daughter ".$student->first_name.' '.$student->last_name." has commited a ".$request['offense_level']." violation. Please visit our office and talk about your concerns. Thank you\r\n";
        
                $notification = app('App\Http\Controllers\sysController')->sendSMS($guardian_number,$message,$api_key->api_code,$message_type);
              
                $validity = '';
            }
        }//end of else/ guardian has number, will send..
       
            $date_committed = Carbon::parse($request['date_committed']);

            $time_reported = Carbon::parse($request['time_reported']);

            $id = ViolationReport::maxViolationId();

            $complainant = Complainant::select('id_no')->where('id_no', $request['complainant_id'])->first();

            $student_violation = new ViolationReport();
            $student_violation->rv_id = $id;
            $student_violation->student_id = $request['student_number'];
            $student_violation->violation_id = $request['violation_id'];
            $student_violation->status = 1;
            $student_violation->complainant_id = $complainant->id_no;
            $student_violation->sanction = $request['sanction'];
            $student_violation->offense_level = $request['offense_level'];
            $student_violation->offense_no = $request['offense_number'];
            $student_violation->date_reported = $date_committed;
            $student_violation->time_reported = $time_reported;
            $student_violation->sanction = $request['sanction'];
            $student_violation->school_year = $request['school_year'];
            $student_violation->reporter_id = Auth::user()->id;
            $student_violation->save();


        return Response::json(['success' => true, 'response' => ++$id, 'notification' => $notification, 'message' => $message], 200);
	}

    public function elevateToSerious(Request $request)
    {
        $violation = DB::table('violations')->where('name', 'LIKE', "%" .$request['name']. "%")->first();
        return Response::json(['violation' => $violation]);
    }

    public function showStatistics()
    {
        $current_school_year = SchoolYear::currentSchoolYear();
        $school_year_selection = SchoolYear::schoolYearSelection();
        $signees = User::all();

        return view('violation_statistics',['school_year_selection' => $school_year_selection],['current_school_year' => $current_school_year, 'signees' => $signees]);
    }
	 

    public function showViolationReports()
    {
        $current_school_year = SchoolYear::currentSchoolYear();
        $school_year_selection = SchoolYear::schoolYearSelection();
        $courses = Course::with('college')->get();
        $colleges = College::all()->sortBy('description');
        $signees = User::all();

        return view('violation_reports',['school_year_selection' => $school_year_selection],['current_school_year' => $current_school_year, 'courses' => $courses,'colleges' => $colleges, 'signees' => $signees]);
    }

    public function postViolationStatistics(Request $request)
    {

    if($request['v_stats_from'] == "" and $request['v_stats_to'] == ""){
        //get violations with depts
        $cams = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 1)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();  

        $cas = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 2)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count(); 

        $cba = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 3)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();                                 

        $coecsa = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 4)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();  

        $cithm = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
            ->join('courses' , 'students.course', '=' , 'courses.description')
            ->join('colleges', 'courses.college_id', '=', 'colleges.id')
            ->where('college_id', 5)
            ->where('violation_reports.school_year',$request['school_year'])
            ->count();   

        $data = [
            [   'cams' => $cams, 
                'cas' => $cas,
                'cba' => $cba,
                'coecsa' => $coecsa,
                'cithm' => $cithm,

            ]
        ];
        
        $stats = [
            ['1' ,$cams], 
            ['2', $cas],
            ['3' , $cba],
            ['4' , $coecsa],
        ];

    }




        else
        {

      //get violations with depts
      $cams = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
                                ->join('courses' , 'students.course', '=' , 'courses.description')
                                ->join('colleges', 'courses.college_id', '=', 'colleges.id')
                                ->where('college_id', 1)
                                ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
                                ->where('violation_reports.school_year',$request['school_year'])
                                ->count();  

    $cas = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
                                ->join('courses' , 'students.course', '=' , 'courses.description')
                                ->join('colleges', 'courses.college_id', '=', 'colleges.id')
                                ->where('college_id', 2)
                                ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
                                ->where('violation_reports.school_year',$request['school_year'])
                                ->count(); 

    $cba = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
                                ->join('courses' , 'students.course', '=' , 'courses.description')
                                ->join('colleges', 'courses.college_id', '=', 'colleges.id')
                                ->where('college_id', 3)
                                ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
                                ->where('violation_reports.school_year',$request['school_year'])
                                ->count();                                 

    $coecsa = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
                                ->join('courses' , 'students.course', '=' , 'courses.description')
                                ->join('colleges', 'courses.college_id', '=', 'colleges.id')
                                ->where('college_id', 4)
                                ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
                                ->where('violation_reports.school_year',$request['school_year'])
                                ->count();  

    $cithm = ViolationReport::join('students', 'violation_reports.student_id' , '=' , 'students.student_no')
                                ->join('courses' , 'students.course', '=' , 'courses.description')
                                ->join('colleges', 'courses.college_id', '=', 'colleges.id')
                                ->where('college_id', 5)
                                ->whereBetween('date_reported', [$request['v_stats_from'], $request['v_stats_to']])
                                ->where('violation_reports.school_year',$request['school_year'])
                                ->count();   

            $data = [
            [ 'cams' => $cams, 
              'cas' => $cas,
              'cba' => $cba,
              'coecsa' => $coecsa,
              'cithm' => $cithm,

            ]
          ];
        
              $stats = [
              ['1' ,$cams], 
              ['2', $cas],
              ['3' , $cba],
              ['4' , $coecsa],
          

            
          ];
}


      return response()->json(['data' => $data, 'stats' => $stats]);    
  }

  public function postViolationReports(Request $request)
  {    
//school year only
    if ($request['v_reports_offense_level'] == "" and $request['v_reports_course'] == "" and $request['v_reports_college'] == "" and $request['v_reports_from'] == "" and $request['v_reports_to'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->where('violation_reports.school_year',$request['school_year'])->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
//school year and offense_level
        elseif ($request['v_reports_course'] == "" and $request['v_reports_college'] == "" and $request['v_reports_from'] == "" and $request['v_reports_to'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->where('violation_reports.school_year',$request['school_year'])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
    // school year and course
            elseif ($request['v_reports_college'] == "" and $request['v_reports_from'] == "" and $request['v_reports_to'] == "" and $request['v_reports_offense_level'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->where('violation_reports.school_year',$request['school_year'])->where('courses.description',$request['v_reports_course'])->select('violations.*','violation_reports.*','students.*')->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
        // school year and college
            elseif ($request['v_reports_course'] == ""  and $request['v_reports_from'] == "" and $request['v_reports_to'] == "" and $request['v_reports_offense_level'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->where('violation_reports.school_year',$request['school_year'])->where('colleges.id',$request['v_reports_college'])->select('violations.*','violation_reports.*','students.*')->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
            // school year and college and offense
            elseif ($request['v_reports_course'] == ""  and $request['v_reports_from'] == "" and $request['v_reports_to'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->where('violation_reports.school_year',$request['school_year'])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->where('colleges.id',$request['v_reports_college'])->select('violations.*','violation_reports.*','students.*')->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
                // school year and course and offense
            elseif ($request['v_reports_college'] == ""  and $request['v_reports_from'] == "" and $request['v_reports_to'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->where('violation_reports.school_year',$request['school_year'])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->where('courses.description',$request['v_reports_course'])->select('violations.*','violation_reports.*','students.*')->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
                    // school year and course and college
            elseif ($request['v_reports_from'] == "" and $request['v_reports_to'] == "" and $request['v_reports_offense_level'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->where('violation_reports.school_year',$request['school_year'])->where('courses.description',$request['v_reports_course'])->where('colleges.id',$request['v_reports_college'])->select('violations.*','violation_reports.*','students.*')->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
                        // school year and course and offense and course and offense
            elseif ($request['v_reports_from'] == "" and $request['v_reports_to'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->where('violation_reports.school_year',$request['school_year'])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->where('courses.description',$request['v_reports_course'])->where('colleges.id',$request['v_reports_college'])->select('violations.*','violation_reports.*','students.*')->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
//range  and school year
    elseif ($request['v_reports_offense_level'] == "" and $request['v_reports_course'] == "" and $request['v_reports_college'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('violation_reports.school_year',$request['school_year'])->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
    //range and college and school year
        elseif ($request['v_reports_offense_level'] == "" and $request['v_reports_course'] == "")
    {
$data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('colleges.id',$request['v_reports_college'])->where('violation_reports.school_year',$request['school_year'])->select('violations.*','violation_reports.*','students.*')->get();

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }

    //range and course and school year
           elseif ($request['v_reports_offense_level'] == "" and $request['v_reports_college'] == "")
    {
$data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('courses.description',$request['v_reports_course'])->where('violation_reports.school_year',$request['school_year'])->select('violations.*','violation_reports.*','students.*')->get();

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }

    //range and offense and school year
        elseif ($request['v_reports_college'] == "" and $request['v_reports_course'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->where('violation_reports.school_year',$request['school_year'])->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }

    //range and college and course and school year
                elseif ($request['v_reports_offense_level'] == "")
    {
           $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('courses.description',$request['v_reports_course'])->where('colleges.id',$request['v_reports_college'])->where('violation_reports.school_year',$request['school_year'])->select('violations.*','violation_reports.*','students.*')->get();

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }

    //range and course and offense and school year
            elseif ($request['v_reports_college'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->where('courses.description',$request['v_reports_course'])->where('violation_reports.school_year',$request['school_year'])->select('violations.*','violation_reports.*','students.*')->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }
    // range and college and offense and school year
                elseif ($request['v_reports_course'] == "")
    {
          $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->where('colleges.id',$request['v_reports_college'])->where('violation_reports.school_year',$request['school_year'])->select('violations.*','violation_reports.*','students.*')->get();  

       foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }
    }

    // all
    else
    {


    $data = ViolationReport::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->join('courses', 'students.course' , '=' , 'courses.description')->join('colleges', 'courses.college_id' , '=' , 'colleges.id')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->where('courses.description',$request['v_reports_course'])->where('colleges.id',$request['v_reports_college'])->where('violation_reports.school_year',$request['school_year'])->select('violations.*','violation_reports.*','students.*')->get();

    foreach ($data as $key => $value) {
        $report[] = ['name' => $value->first_name. " ".$value->last_name,
                      'course' => $value->course,
                      'date_reported' => $value->date_reported,
                      'offense' => $value->name,
                      'offense_no' => $value->offense_no,
                      'description' => $value->description,
        ];
    }

   
    }
      return response()->json(['data' => $data]);
/*
    return Datatables::eloquent(ViolationReport::query()->join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id'))->make(true);*/
  
  }

  public function getCourseYears(Request $request)
  {
    $years = Course::select('no_of_years')->where('description' , $request['course'])->first();
    return response($years);
  }

}
