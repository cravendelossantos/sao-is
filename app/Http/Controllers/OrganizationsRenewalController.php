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


class OrganizationsRenewalController extends Controller
{
       public function __construct()
    {
    	$this->middleware('roles');
    }
    
 	    public function showOrganizationsRenewal()
    {
       
      $current_time = Carbon::now()->format('Y-m-d');


      $schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();

      
       $selected_year = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->pluck('school_year');


       $organizations = DB::table('requirements')->where('school_year',$selected_year)->get();
      return view('organizations_renewal',['organizations' => $organizations],['schoolyear' => $schoolyear]);
    }

      public function showOrganizationsRenewalList()
    {
       $current_time = Carbon::now()->format('Y-m-d');


      $schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();

       $selected_year = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->pluck('school_year');


      $schoolyears = DB::table('school_years')->select('school_year')->where('term_name', 'School Year')->where('school_year', '<>', $selected_year)->get();



       
        return view('organizations_renewal_list',['schoolyears' => $schoolyears],['schoolyear' => $schoolyear]);
    }


      public function showOrganizationsRenewalAdd()
    {


     $current_time = Carbon::now()->format('Y-m-d');



$schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();
       
        return view('organizations_renewal_add',['schoolyears' => $schoolyear]);
    }


    //     public function getOrganizationList()
    // {
      
    //     $organizations = DB::table('requirements')->get();
    //   return view('organizations_renewal',['organization' => $organizations]);
    // }


        public function getRequirementsTable()
    {


        return Datatables::eloquent(Requirements::query())->make(true);

    }




        public function getRequirementsByName(Request $request)
    {
       // $requirements = Requirements::where('organization', $request['organizationName'])->first();
       // return response()->json(array('response' => $requirements));

       //  $requirements = DB::table('requirements')->where('organization', $request['organizationName'])->get();

       // return Datatables::of($requirements)->make(true);



        return Datatables::eloquent(Requirements::query()->where('organization',$request['organizationName']))->first()->make(true); 




    }

    public function searchRequirements(Request $request)
    {


   $term = $request->organization;
          
    $data = Requirements::where('organization', $request['organization'])->where('school_year',$request['year'])->first();

     return response()->json($data);
// return response()->json(array('response' => $data));


    }

        public function searchRequirementsByYear(Request $request)
    {
      
    

    return Datatables::eloquent(Requirements::query()->where('school_year',$request['school_year']))->make(true);
    }

        public function searchRequirementsByYearAndStatus(Request $request)
    {

if ($request['sort_by'] == "All")

     $data = DB::table('requirements')->where('school_year',$request['school_year'])->get();


elseif ($request['sort_by'] == "Submitted All Requirements")

     $data = DB::table('requirements')->where('school_year',$request['school_year'])->where('requirement1',1)->where('requirement2',1)->where('requirement3',1)->where('requirement4',1)->where('requirement5',1)->where('requirement6',1)->where('requirement7',1)->where('requirement8',1)->where('requirement9',1)->get();

elseif ($request['sort_by'] == "Not Submitted All Requirements")

     $data = DB::table('requirements')->where('school_year',$request['school_year'])->where('requirement1',0)->orWhere('requirement1',0)->where('requirement2',1)->orWhere('requirement2',0)->where('requirement3',1)->orWhere('requirement3',0)->where('requirement4',1)->orWhere('requirement4',0)->where('requirement5',1)->orWhere('requirement5',0)->where('requirement6',1)->orWhere('requirement6',0)->where('requirement7',1)->orWhere('requirement7',0)->where('requirement8',1)->orWhere('requirement8',0)->where('requirement9',1)->orWhere('requirement9',0)->get();
    
    return response()->json(['data' => $data]);
    }


        public function postRequirementsRenewalAdd(Request $request)
    {
            
            
            $validator = Validator::make($request->all(),[
            'organizationName' => 'required|string|max:255',
            'deadline' => 'required|date',
           
        ]);

        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
          
        }
        else {


     $current_time = Carbon::now()->format('Y-m-d');



$sy = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->first();


 $asdad = json_encode($sy);


     
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

        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
          
        }
    else {
  
      $requirements = DB::table('requirements')->where('id', $request['update_id'])->update([     
            
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



