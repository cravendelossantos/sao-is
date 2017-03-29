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
use App\SchoolYear;

class ProposalActivitiesMonitoringController extends Controller
{
    public function __construct()
    {
    	$this->middleware('roles');
    }


    public function showProposalActivities()
    {
      $current_school_year = SchoolYear::currentSchoolYear();
      $school_year_selection = SchoolYear::schoolYearSelection();
      $organizations = DB::table('requirements')->where('school_year',$current_school_year)->get();

       
        return view('proposal_activities_monitoring',['organizations' => $organizations,'school_year_selection' => $school_year_selection,'current_school_year' => $current_school_year]);

    }


       public function getActivitiesByYear(Request $request)
    {

    return Datatables::eloquent(Activity::query()->where('school_year',$request['school_year']))
      ->editColumn('status', function($act){
                if ($act == true){
                    $badge = '<center><span class="label label-primary"><big>Submitted</big></span></center>';
                }  else {
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
     public function getActivitiesByYearAndOrg(Request $request)
    {

    return Datatables::eloquent(Activity::query()->where('school_year',$request['school_year'])->where('organization',$request['organization']))
    ->editColumn('status', function($act){
                if ($act == true){
                    $badge = '<center><span class="label label-primary"><big>Submitted</big></span></center>';
                }  else {
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

      $current_school_year = SchoolYear::currentSchoolYear();
      $school_year_selection = SchoolYear::schoolYearSelection();
      $organizations = DB::table('requirements')->where('school_year',$current_school_year)->get();

      return view('proposal_activities_monitoring_add',['organizations' => $organizations,'school_year_selection' => $school_year_selection,'current_school_year' => $current_school_year]);
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
      $current_school_year = SchoolYear::currentSchoolYear();
      $school_year_selection = SchoolYear::schoolYearSelection();
      $organizations = DB::table('requirements')->where('school_year',$current_school_year)->get();

      return view('proposal_activities_monitoring_reports',['organizations' => $organizations,'school_year_selection' => $school_year_selection,'current_school_year' => $current_school_year]);;

       
       
       
    }






}

