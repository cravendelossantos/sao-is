<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Http\Requests;
use Yajra\Datatables\Facades\Datatables;
use App\ViolationReport;
use Response;
use Validator;
use App\CommunityService;
use Carbon\Carbon;
use App\Suspension;
use App\Exclusion;
use App\SuspensionLog;
use App\SchoolYear;
use App\User;
use DB;

class SanctionController extends Controller
{
    public function __construct()
    {
        $this->middleware('roles');
    }
    public function showSanctions()
    {
    	return view('sanction_monitoring');
    }

    public function showSanctionsReports()
    {

        $current_school_year = SchoolYear::currentSchoolYear();
        $school_year_selection = SchoolYear::schoolYearSelection();
        $signees = User::all();

        return view('sanction_reports', ['school_year_selection' => $school_year_selection,'current_school_year' => $current_school_year, 'signees' => $signees]);
    }

    public function searchStudent(Request $request)
    {
        return Sanction::findStudent($request);
    }

    public function getViolationDetails(Request $request)
    {
        $violation_details = ViolationReport::where('rv_id', $request['id'])->first();
        return response()->json(array('response' => $violation_details));
    }

    public function getUpdateStatus(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'sanction_status' => 'required',                   
        ]);

        if ($validator->fails()) {
            return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
          
        }
    }

    public function postUpdateStatus(Request $request)
    {
        $status = ViolationReport::where('id' , $request['sanction_violation_id'])
                                    ->update(['status' => $request['sanction_status'],
                                              'updated_by' => $request['m_updated_by'],
                                            ]);

        return Response::json(['success' => true, 'response' => $status], 200);
    }


    public function getAddToCS(Request $request)
    {

        $messages = [
            'cs_days.required.numeric' => 'The days of community work is required and must be a number',
             'cs_modal_student_id.unique' => 'This student is already excluded',
            'cs_violation_id.unique' => 'The violation already added in Community Serivce',
        ];

        $validator = Validator::make($request->all(),[
            'cs_days' => 'required|numeric|min:3',
            'cs_violation_id' => 'required|unique:community_services,violation_id',
            'cs_modal_student_id' => 'unique:exclusions,student_id',

        ],$messages);

        if ($validator->fails()) {
            return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
          
        }

    }

    public function postAddToCS(Request $request)
    {   
        
        $new_cs = new CommunityService();
        $new_cs->violation_id = $request['cs_violation_id'];
        $new_cs->date = Carbon::now();
        $new_cs->no_of_days = $request['cs_days'];
        $new_cs->required_hours = ($request['cs_hours']*3600);
        $new_cs->student_id = $request['cs_modal_student_id'];
        $new_cs->save();
        

        ViolationReport::where('id',$request['suspension_violation_id'])->update(['status' => 'On Going']);
        return Response::json(['success' => true, 'response' => $new_cs], 200);
    }

    public function getSuspension(Request $request)
    {

        if ($request['suspension_exclusion'] == 'Suspend'){
            $messages = [
            'suspension_days.required' => 'The no of suspension days is required',
            '_suspension_student_no.unique' => 'This student is already excluded',
            'suspension_violation_id.unique' => 'The violation already added in Suspensions',

            ];

            $validator = Validator::make($request->all(),[
                'suspension_days' => 'required|numeric|min:5',
                'suspension_violation_id' => 'required|unique:suspensions,violation_id',
                '_suspension_student_no' => 'unique:exclusions,student_id',


                ],$messages);
            if ($validator->fails()) {
                return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 

            }
        }


        else if ($request['suspension_exclusion'] == 'Exclude'){
            $messages = [

            'suspension_violation_id.unique' => 'The violation already added in Suspensions',
            '_suspension_student_no.unique' => 'This student is already excluded',
            ];

            $validator = Validator::make($request->all(),[

                'suspension_violation_id' => 'required|unique:suspensions,violation_id',
                '_suspension_student_no' => 'unique:exclusions,student_id',

                ],$messages);
            if ($validator->fails()) {
                return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 

            }
        }

        else{
            $message[] = 'Please select the sanction (suspension or exclusion)';
            return Response::json(['success'=> false, 'errors' => $message],400);
        }      
    }

    public function postSuspension(Request $request)
    {
        if ($request['suspension_exclusion'] == 'Suspend')
        {
            $suspend = new Suspension(); 
            $suspend->violation_id = $request['suspension_violation_id'];
            $suspend->suspension_days = $request['suspension_days'];
            $suspend->status = 1;
            $suspend->student_id = $request['_suspension_student_no'];
            $suspend->save();

            ViolationReport::where('rv_id',$request['suspension_violation_id'])->update(['status' => 'On Going']);
            return Response::json(['success' => true, 'response' => $suspend], 200);
        }
        else if ($request['suspension_exclusion'] == 'Exclude'){
            $exclusion = new Exclusion();
            $exclusion->student_id = $request['_suspension_student_no'];
            $exclusion->save();

            $up_student_status = DB::table('students')->where('student_no', $request['_suspension_student_no'])->update(['current_status' => 'Excluded']);

            return Response::json(['success' => true, 'response' => $exclusion], 200);
        }        
    }

    public function suspensionTable(Request $request)
    {
        return Suspension::table($request);
    }

    public function exclusionTable(Request $request)
    {
        return Exclusion::table($request);
    }

    public function getSuspensionDetails(Request $request)
    {
        $suspension_details = Suspension::where('id', $request['id'])->join('students' , 'suspensions.student_id' , '=' ,'students.student_no')->first();
        return response()->json(array('response' => $suspension_details));
    }


    public function getSuspensionUpdate(Request $request)
    { 
        $dates = explode("," , $request['all_suspension_dates']);
        $validator = Validator::make($request->all(),[                   
            '_suspension_log_suspension_id' => 'required',


            ]);

        if ($validator->fails()) {
            return Response::json(['success'=> false, 'dates' => $dates, 'errors' =>$validator->getMessageBag()->toArray()],400);           
        }
        else
        {
            $old_records = SuspensionLog::select('day')->where('suspension_id', $request['_suspension_log_suspension_id'])->get();

            if ($old_records->isEmpty()) {     
            } 
            else {

                foreach ($old_records as $old_record) {
                //from db
                   $old_dates[] =  $old_record->day;

               }


               foreach ($dates as $date) {
                $days[] = $date; 
                if ($date > Carbon::now()) {
                    $message = ['msg' => 'Please select dates before '.Carbon::tomorrow()->format('Y-m-d')]; 
                    return Response::json(['success'=> false, 'errors' => $message],400); 
                }        
            }

            $result = array_intersect($days, $old_dates);

            foreach ($result as $each_result) {
                $same_days[] = $each_result;
            }

            if (count($result) > 0){
                //parehas lahat
                $message = ['msg' => 'Dates already exist in the selected suspension:', 'dates' => $same_days, ]; 
                return Response::json(['success'=> false, 'result' => $result, 'errors' => $message],400); 

            } 
        }
    }
}


public function postSuspensionUpdate(Request $request)
{
    $dates = explode("," , $request['all_suspension_dates']);
    $days_count = count($dates);

    $old_records = SuspensionLog::select('day')->where('suspension_id', $request['_suspension_log_suspension_id'])->get();

    if ($old_records->isEmpty()) {
                //insert with new dates, walang existing eh

        foreach ($dates as $date) {

            $new_dates[] = $date;
            $new_suspension_log = new SuspensionLog();
            $new_suspension_log->day = Carbon::parse($date)->format('Y-m-d');
            $new_suspension_log->suspension_id = $request['_suspension_log_suspension_id'];
            $new_suspension_log->student_id = $request['_suspension_log_student_no'];
            $new_suspension_log->save();
        }
    } 
    else {
        foreach ($old_records as $old_record) {
            $old_dates[] =  $old_record->day;
        }

        foreach ($dates as $date) {
            $days[] = $date;
        }

        $result = array_intersect($days, $old_dates);
        $different_days = array_diff($days, $old_dates);

        foreach ($result as $each_result) {
            $same_days[] = $each_result;
        }

        if (count($result) > 0){
                //parehas lahat
            $message = ['msg' => 'Dates already exist in the selected suspension:', 'dates' => $same_days, ]; 
            return Response::json(['success'=> false, 'result' => $result, 'errors' => $message],400); 

        } 
        else
        {
            foreach ($different_days as $different_day) {

                $new_dates[] = $different_day;
                $new_suspension_log = new SuspensionLog();
                $new_suspension_log->day = Carbon::parse($different_day)->format('Y-m-d');
                $new_suspension_log->suspension_id = $request['_suspension_log_suspension_id'];
                $new_suspension_log->student_id = $request['_suspension_log_student_no'];
                $new_suspension_log->save();
            }
        }
    }

    $today = Carbon::now();        

    $total_dates = Suspension::select('suspension_days')
    ->where('id', $request['_suspension_log_suspension_id'])->first();

    $days_update = $total_dates['suspension_days'] - count($new_dates);

    if ($days_update  <= 0){
        $update_status = Suspension::where('id', $request['_suspension_log_suspension_id'])
        ->update(['status' => 'Completed', 'suspension_days' => 0]);
        ViolationReport::where('rv_id' , $request['_suspension_log_violation_id'])
        ->update(['status' => 'Completed']);

    } else {
        $update_status = Suspension::where('id', $request['_suspension_log_suspension_id'])
        ->update(['status' => 'On Going', 'suspension_days' => $days_update]);
    }

    return Response::json(['success' => true, 'response' => $new_suspension_log], 200);        

    }

}
