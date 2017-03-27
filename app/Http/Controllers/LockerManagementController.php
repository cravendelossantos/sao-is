<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Locker;
use Validator;
use DB;
use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;
use App\SchoolYear;
use Response;
use App\LockerLocation;
use Auth;
use App\Content;

class LockerManagementController extends Controller
{
   /* public function __construct()
    {
    	$this->middleware('roles');
    }*/

    public function showLockers()
    {
      $content = Content::where('page', 'locker contract')->first();

      $dates = SchoolYear::all();
      $locations = LockerLocation::all();

      return view('locker_management',[ 'dates' => $dates, 'locations' => $locations, 'content' => $content]);
  }

  public function showLockersTable(Request $request)
  {  

    Locker::where('end_of_contract', '<', Carbon::now()->format('Y-m-d'))->where('end_of_contract' , '<>', date(null))->update(['status' => 'Available', 
      'updated_by' => Auth::user()->id,
      'lessee_id' => null, 'lessee_name' => null, 'start_of_contract' => null, 'end_of_contract' => null]);



    if ( $request['status_sort'] ==  "" && $request['location_sort'] == ""){
     $lockers = DB::table('lockers')->join('locker_locations' , 'lockers.location_id', '=', 'locker_locations.id');
 }
 else if ( $request['status_sort'] ==  ""){
  $lockers = DB::table('lockers')->join('locker_locations' , 'lockers.location_id', '=', 'locker_locations.id')->where('location_id' ,$request['location_sort']);
} else if($request['location_sort'] == ""){
  $lockers = DB::table('lockers')->join('locker_locations' , 'lockers.location_id', '=', 'locker_locations.id')->where('status', $request['status_sort']);
}
else{
    $lockers = DB::table('lockers')->join('locker_locations' , 'lockers.location_id', '=', 'locker_locations.id')->where('status', $request['status_sort'])->where('location_id' ,$request['location_sort']);
}
return Datatables::of($lockers)->make(true);

}

public function getLockerDetails(Request $request)
{
    $locker = Locker::where('locker_no', $request['id'])->first();
    return response()->json(array('response' => $locker));
}

public function addLockers(Request $request)
{
 $validator = Validator::make($request->all(),[
   'no_of_lockers' => 'required|numeric|min:1',
   'location' => 'required',

   ]);

 if ($validator->fails()) {
   return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 


}
else {
    // $new_location = $request['new_location'];
    $location = $request['location'];    

    


    // if ($location == 'new') {
    //     DB::table('locker_locations')->insert(['location_id' => $new_location, 'date_added' => Carbon::now()]);
    //     $loc =  $new_location;
    // } else {
    //     $loc =  $location;
    // }
    // $floor = $request['floor_no'];

    $start_no = $request['from'];



    
    
    
    $no_of_lockers = $request['no_of_lockers'];
    for ($i = 0; $no_of_lockers > $i; $i++)
    {

      try{
         $new_locker = new Locker();
         $new_locker->locker_no = $start_no;
         $new_locker->location_id = $location;
         $new_locker->status = 1;
         $new_locker->date_created = Carbon::now()->format('Y-m-d');
         $new_locker->added_by = Auth::user()->id;
         $new_locker->save();

         $start_no++;
     }
     catch(\Illuminate\Database\QueryException $e){
      $errors= ['errors' => 'Locker numbers are already taken.'];
      return Response::json(['success'=> false, 'errors' => $errors],400); 
  }

}

return response()->json(['success' => true, 'response' => $new_locker], 200); 


}
}



public function updateLocker(Request $request)
{

  $contract_dates = SchoolYear::where('id' , $request['contract'])->first();

  $validator = Validator::make($request->all(),[
      'm_update_status' => 'required',
      ]);

  if ($validator->fails()) 
  {
    return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
}

else
{

  $update_status = $request['m_update_status'];
  if ($update_status == 'Occupied')
  {
    $messages = [
    'm_lessee_id.required' => 'The Lessee ID is required.',
    'm_lessee_id.unique' => 'This Lessee already has a contract',
    'm_lessee_name.required' => 'The Lessee name is required.',
    'm.lessee_id.min' => 'The Lessee name must be atleast 4 characters',
    'm_lessee_id.regex' => 'Invalid Lessee ID format.',

    ];


    $validator = Validator::make($request->all(),[
        'm_lessee_name' => 'required|string|min:4',
        'm_lessee_id' =>  array('required', 'regex:/^[0-9A-Za\s-]+$/', 'unique:lockers,lessee_id'),
        'contract' => 'required',
        ],$messages);

    $locker_status = Locker::where('locker_no', $request['_m_locker_no'])->first();

    if ($validator->fails()) 
    {
      return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
  }
  else 
  {
      if ($locker_status->status == 'Occupied')
      {
        $errors= ['errors' => 'The selected locker is already occupied'];
        return Response::json(['success'=> false, 'errors' => $errors],400); 
    }
    else 
    {
      if ($contract_dates->end <= Carbon::now()->format('Y-m-d')){
        $errors= ['errors' => 'The dates in selected contract already ended'];
        return Response::json(['success'=> false, 'errors' => $errors],400); 
    }
    else 
    {

      $update_occupied = DB::table('lockers')->where('locker_no' , $request['_m_locker_no'])
      ->update(['status' => $request['m_update_status'], 'lessee_name' => ucwords($request['m_lessee_name']), 'lessee_id' => $request['m_lessee_id'], 'start_of_contract' => $contract_dates->start, 'end_of_contract' => $contract_dates->end , 'updated_by' => Auth::user()->id
          ]);

      return Response::json(['success'=> true, 'response' => $update_occupied, 'occupied' => true],200); 
  }
}     

}  

}
else
{
  $new = DB::table('lockers')->where('locker_no' , $request['_m_locker_no'])->update(['status' => $request['m_update_status'],  'updated_by' => Auth::user()->id]);
  return Response::json(['success'=> true, 'response' => $new],200); 

}
}

}


public function showLockerLocations()
{   
  $locations = LockerLocation::all();
  return view('locker_locations',['locations' => $locations]);
}

public function getLockerLocations(Request $request)
{

   $validator = Validator::make($request->all(),[
      'new_building' => 'required|string',
      'no_of_floors' => 'required',

      ]);

   if ($validator->fails()) {
      return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 

  }
}

public function postLockerLocations(Request $request)
{ 

  $no_of_floors = $request['no_of_floors'];
  for ($i=1; $i <= $no_of_floors; $i++) { 
    $floors[] = $i;
}

$max_key = max(array_keys($floors))+1;


for ($i=0; $i < $max_key ; $i++) { 

    $ends = array('th','st','nd','rd','th','th','th','th','th','th');

    if (($floors[$i] %100) >= 11 && ($floors[$i]%100) <= 13){
       $floor_sequence[] = $floors[$i]. 'th';
   }
   else{
       $floor_sequence[] = $floors[$i]. $ends[$floors[$i] % 10];
   }

   try{
    $new_locker_location = new LockerLocation();
    $new_locker_location->building = ucwords($request['new_building']);
    $new_locker_location->floor = $floor_sequence[$i];
    $new_locker_location->date_added = Carbon::now();
    $new_locker_location->added_by = Auth::user()->id; 
    $new_locker_location->save();
}
catch(\Illuminate\Database\QueryException $e){
    $errors= ['errors' => 'Location(s) are already added. Please check your inputs.'];
    return Response::json(['success'=> false, 'errors' => $errors],400); 
}


}

return Response::json(['success'=> true, 'new_locker_location' => $new_locker_location],200); 
}

public function showLockerReports()
{
    $locations = LockerLocation::all();
    $current_school_year = SchoolYear::currentSchoolYear();
    $school_year_selection = SchoolYear::schoolYearSelection();

    return view('locker_reports',['school_year_selection' => $school_year_selection,'current_school_year' => $current_school_year,'locations' => $locations ]);
}

public function showLockerStatistics()
{
    $locations = LockerLocation::all();
    $current_school_year = SchoolYear::currentSchoolYear();
    $school_year_selection = SchoolYear::schoolYearSelection();

    return view('locker_statistics',['school_year_selection' => $school_year_selection,'current_school_year' => $current_school_year,'locations' => $locations ]);
}



public function postLockerReportsTable(Request $request)
{


   $total = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])

   ->count();
   

   $available = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])

   ->where('status' , 'Available')
   ->count();
   
   $occupied = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])

   ->where('status' , 'occupied')
   ->count();
   
   $locked = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])

   ->where('status' , 'locked')
   ->count();
   
   $damaged = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])

   ->where('status' , 'damaged')
   ->count();
   


      // into objects..
   $data = [
   [ 
   'total' => $total, 
   'available' => $available,
   'occupied' =>$occupied,
   'locked' => $locked,
   'damaged' => $damaged
   ]
   ];


   // return Datatables::of($lockers)->make(true);
   return response()->json(['data' => $data]);


}

public function postLockerStatistics(Request $request)
{
    $total = DB::table('lockers')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])

    ->count();

    $available = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])

    ->where('status' , 'Available')
    ->count();

    $occupied = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])

    ->where('status' , 'occupied')
    ->count();

    $locked = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
    
    ->where('status' , 'locked')
    ->count();

    $damaged = DB::table('lockers')->select('status')->whereBetween('date_created', [$request['locker_reports_from'], $request['locker_reports_to']])
    
    ->where('status' , 'damaged')
    ->count();

    



      // into objects..
    $data = [
    
    'total' => $total, 
    'available' => $available,
    'occupied' =>$occupied,
    'locked' => $locked,
    'damaged' => $damaged,
    
    ];




   // return Datatables::of($lockers)->make(true);
return response()->json($data); 


}



}
