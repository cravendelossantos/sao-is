<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use DB;
use App\User;
use App\LostAndFound;
use App\Requirements;
use Carbon\Carbon;
use DateTime;
use Auth;
use Yajra\Datatables\Facades\Datatables;
use Response;
use App\SchoolYear;

class OrganizationsRenewalController extends Controller
{
    public function __construct()
    {
        $this->middleware('roles');
    }

    public function showOrganizationsRenewal()
    {
        $current_school_year = SchoolYear::currentSchoolYear();
        $school_year_selection = SchoolYear::schoolYearSelection();
        $organizations = DB::table('requirements')
        ->where('school_year',$current_school_year)
        ->get();
    
        return view('organizations_renewal',['organizations' => $organizations],['current_school_year' => $current_school_year]);
    }

    public function showOrganizationsRenewalList()
    {
        $current_school_year = SchoolYear::currentSchoolYear();
        $school_year_selection = SchoolYear::schoolYearSelection();

        return view('organizations_renewal_list',['school_year_selection' => $school_year_selection],['current_school_year' => $current_school_year]);
    }

    public function showOrganizationsRenewalAdd()
    {
        $current_school_year = SchoolYear::currentSchoolYear();
        return view('organizations_renewal_add',['current_school_year' => $current_school_year]);
    }

    public function getRequirementsTable()
    {
        return Datatables::eloquent(Requirements::query())
        ->addColumn('action', function ($req) {
            return '<center><a href="#edit-'.$req->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
        <a href="#delete-'.$req->id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Edit</a></center>';
        })
        ->make(true);
    }   

    public function getRequirementsByName(Request $request)
    {
        return Datatables::eloquent(Requirements::query()
        ->where('organization',$request['organizationName']))
        ->first()->make(true);  
    }   

    public function searchRequirements(Request $request)
    {
        $term = $request->organization;
        $data = Requirements::where('organization', $request['organization'])
        ->where('school_year',$request['year'])
        ->first();

        return response()->json($data);
    }

    public function searchRequirementsByYear(Request $request)
    {
        return Requirements::filterYear($request);  
    }

    public function searchRequirementsByYearAndStatus(Request $request)
    {   
        return Requirements::filterYearAndStatus($request);
    }

    public function postRequirementsRenewalAdd(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'organizationName' => 'required|string|max:255',
        'deadline' => 'required|date',
        ]);

        if ($validator->fails()){
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
        }
        else{
            $current_time = Carbon::now()->format('Y-m-d');
            $sy = DB::table('school_years')->select('school_year')
            ->where('term_name' , 'School Year')
            ->whereDate('start', '<' ,$current_time)
            ->whereDate('end' , '>', $current_time)
            ->first();

            $requirement = new Requirements();
            $requirement->school_year =  $request['school_year'];
            $requirement->organization =  $request['organizationName'];
            $requirement->deadline     =  $request['deadline'];
            $requirement->requirement1 = $request['requirement1'];
            $requirement->requirement2 = $request['requirement2'];
            $requirement->requirement3 = $request['requirement3'];
            $requirement->requirement4 = $request['requirement4'];
            $requirement->requirement5 = $request['requirement5'];
            $requirement->requirement6 = $request['requirement6'];
            $requirement->requirement7 = $request['requirement7'];
            $requirement->requirement8 = $request['requirement8'];
            $requirement->requirement9 = $request['requirement9'];
            $requirement->requirement10 = $request['requirement10'];
            $requirement->requirement11 = $request['requirement11'];
            $requirement->save();
            
            return response()->json(array(
            'success' => true,
            'response' => $requirement,
            'response1' =>$current_time,
            'response4' =>$sy,
            ));
        }
    }

    public function postRequirementsRenewalUpdate(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'organizationName' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()){
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
        }
        else{
            $requirements = DB::table('requirements')
            ->where('id', $request['update_id'])->update([     
            'requirement1' => $request['requirement1'],
            'requirement2' => $request['requirement2'],
            'requirement3' => $request['requirement3'],
            'requirement4' => $request['requirement4'],
            'requirement5' => $request['requirement5'],
            'requirement6' => $request['requirement6'],
            'requirement7' => $request['requirement7'],
            'requirement8' => $request['requirement8'],
            'requirement9' => $request['requirement9'],
            'requirement10' => $request['requirement10'],
            'requirement11' => $request['requirement11'],
            ]);
        }
    }
}



