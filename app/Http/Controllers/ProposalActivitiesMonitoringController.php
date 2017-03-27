<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use DB;
use App\User;
use App\Activity;
use Carbon\Carbon;
use DateTime;
use Auth;
use Yajra\Datatables\Facades\Datatables;

class ProposalActivitiesMonitoringController extends Controller
{
    public function __construct()
    {
    	$this->middleware('roles');
    }


    public function showProposalActivities()
    {

 $current_time = Carbon::now()->format('Y-m-d');


      $schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();

       $selected_year = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->pluck('school_year');


      $schoolyears = DB::table('school_years')->select('school_year')->where('term_name', 'School Year')->where('school_year', '<>', $selected_year)->get();

$organizations = DB::table('requirements')->where('school_year',$selected_year)->get();

       
        return view('proposal_activities_monitoring',['organizations' => $organizations,'schoolyears' => $schoolyears,'schoolyear' => $schoolyear]);

       

       

    }


       public function getActivitiesByYear(Request $request)
    {

    return Datatables::eloquent(Activity::query()->where('school_year',$request['school_year']))->make(true);
       
    } 
     public function getActivitiesByYearAndOrg(Request $request)
    {

    return Datatables::eloquent(Activity::query()->where('school_year',$request['school_year'])->where('organization',$request['organization']))->make(true);
       
    }

    public function getActivitiesByYearAndOrgAndStatus(Request $request)
    {
       if ($request['sort_by'] == "")
       {
         $data = Activity::where('school_year',$request['school_year'])->get();
       }

       elseif ($request['organizationName'] == 0)
       {
         $data = Activity::where('school_year',$request['school_year'])->where('status',$request['sort_by'])->get();
       }
       else
       {
         $data = Activity::where('school_year',$request['school_year'])->where('organization',$request['organization'])->where('status',$request['sort_by'])->get();
       }

  return response()->json(['data' => $data]);
       
    }    


       public function getOrganizationByYear(Request $request)
    {

      $organizations = DB::table('requirements')->where('school_year',$request['school_year'])->get();
       return response()->json(array('response' => $organizations));
       
    }    

    public function getActivitiesTable()
    {
        return Datatables::eloquent(Activity::query())->make(true);

    }    
     public function showAddActivity()
    { 

      $current_time = Carbon::now()->format('Y-m-d');


      $schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();

      
       $selected_year = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->pluck('school_year');


       $organizations = DB::table('requirements')->where('school_year',$selected_year)->get();
  


      return view('proposal_activities_monitoring_add',['organizations' => $organizations],['schoolyears' => $schoolyear]);
    }

       public function getActivityDetails(Request $request)
    {
       $activities = Activity::where('id', $request['id'])->first();
       return response()->json(array('response' => $activities));
    }

        public function postProposalActivitiesAdd(Request $request)
    {

        $tomorrow = Carbon::tomorrow()->format('y-m-d');

              $messages = [

            'date_committed.before' => 'Date must be not less than today.',
        ];
            
            $validator = Validator::make($request->all(),[
            'organizationName' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'date' => 'required|date|after:' .$tomorrow,
        
           
        ],$messages);

        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
          
        }
        else {
    

          $activity = new Activity();
          $activity->organization =  $request['organizationName'];
          $activity->school_year =  $request['school_year'];
          $activity->activity = $request['title'];
          $activity->date = $request['date'];
          $activity->status = $request['status'];
          $activity->save();
        return response()->json(array(
            'success' => true,
            'response' => $activity
        ));
        }
    }

        public function postProposalActivitiesUpdate(Request $request)
  {
    $validator = Validator::make($request->all(),[
          'organization' => 'required|alpha|max:255',                   
      ]);

        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
          
        }
    else {
  
      $activities = DB::table('activities')->where('id', $request['update_id'])->update([     
            'organization' => $request['organization'],
            'activity' => $request['title'],
            'date' => $request['date'],
            'status' => $request['status'],          
        ]);
      
      }

    }
    
 
         public function showProposalActivitiesReports()
    {
 $current_time = Carbon::now()->format('Y-m-d');


      $schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();

       $selected_year = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->pluck('school_year');


      $schoolyears = DB::table('school_years')->select('school_year')->where('term_name', 'School Year')->where('school_year', '<>', $selected_year)->get();

$organizations = DB::table('requirements')->where('school_year',$selected_year)->get();

       
        return view('proposal_activities_monitoring_reports',['organizations' => $organizations,'schoolyears' => $schoolyears,'schoolyear' => $schoolyear]);

       
       
        // return view('proposal_activities_monitoring_reports');
    }






}

