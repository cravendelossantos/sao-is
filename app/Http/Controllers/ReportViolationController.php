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
    }
    
 	public function showReportViolation()
    {
        $max_violation_id = ViolationReport::maxViolationId();  
        $current_school_year = SchoolYear::currentSchoolYear();
        $courses = Course::with('college')->get();

        if (Auth::user()->roles()->first()->id == 2){
            $violations = Violation::all()
            ->where('offense_level', 'Less Serious')
            ->sortBy('name');
        } else {
            $violations = Violation::all()
            ->sortBy('name');
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
        return ViolationReport::table($request);
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
            } 
            else {
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
        }
        else {
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
        $data = Complainant::where('id_no', $term)
        ->take(5)
        ->get();
      
        $result = array();
        
            foreach ($data as $key => $value)
            {
                $result[] = [   'value' => $value->id_no, 
                                'name' => $value->complainant_name, 
                                'position' => $value->position,
                            ];
        }
        return response()->json($result);
    }
   
    public function showOffenseNo(Request $request)
    {
        return ViolationReport::offenseCount($request);    
    }

    public function searchViolation(Request $request)
    {
        $search_violation = DB::table('violations')
        ->where('name', $request['violation'])
        ->first();
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
        }
        else if ($request['offense_level'] == 'Serious' || $request['offense_level'] == 'Very Serious') {
            $student = Student::where('student_no', $request['student_number'])->first();
            $api_key = DB::table('itexmo_key')->first();
            $message_type = "Violation Notification";
            $guardian_number = $student->guardian_contact_no;

            if ($student->guardian_contact_no == ""){
                $notification[] = ['response' => "Message is not sent. Guardian number is not available"];
                $message = "";
            } 
            else {
                if (strpos($guardian_number, '+63') !== false) {
                    $guardian_number = str_replace("+63", "0", $guardian_number);          
                }
                $message = "From LPU Cavite Student Affairs Office\r\n"."\r\nWe would like to inform you that your son/daughter ".$student->first_name.' '.$student->last_name." has commited a ".$request['offense_level']." violation. Please visit our office and talk about your concerns. Thank you\r\n";
        
                $notification = app('App\Http\Controllers\sysController')->sendSMS($guardian_number,$message,$api_key->api_code,$message_type); 

                $validity = '';
            }
        }
       
        $date_committed = Carbon::parse($request['date_committed']);
        $time_reported = Carbon::parse($request['time_reported']);
        $id = ViolationReport::maxViolationId();
        $complainant = Complainant::select('id_no')
        ->where('id_no', $request['complainant_id'])
        ->first();

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
        $violation = DB::table('violations')
        ->where('name', 'LIKE', "%" .$request['name']. "%")
        ->first();
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
        $colleges = College::all()
        ->sortBy('description');
        $signees = User::all();

        return view('violation_reports',['school_year_selection' => $school_year_selection],['current_school_year' => $current_school_year, 'courses' => $courses,'colleges' => $colleges, 'signees' => $signees]);
    }

    public function postViolationStatistics(Request $request)
    {
        return ViolationReport::violationStatistics($request->all());       
    }

    public function postViolationReports(Request $request)
    {    
        return ViolationReport::ViolationReports($request);
    }

    public function getCourseYears(Request $request)
    {
        $years = Course::select('no_of_years')
        ->where('description' , $request['course'])
        ->first();
        return response($years);
    }
}
