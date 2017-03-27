<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use DB;
use App\User;
use App\LostAndFound;
use App\events;
use Carbon\Carbon;
use DateTime;

use App\Student;
use App\Violation;
use App\ViolationReport;


class CampusVenueReservationController extends Controller
{
    public function __construct()
    {
    	$this->middleware('roles');
    }
    
 	public function showCampusVenueReservation()
    {

 $current_time = Carbon::now()->format('Y-m-d');


      $schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();
      


      // $schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();

      
       $selected_year = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->pluck('school_year');


       $organizations = DB::table('requirements')->where('school_year',$selected_year)->get();
       
        $schoolyears = DB::table('school_years')->select('school_year')->where('term_name', 'School Year')->where('school_year', '<>', $selected_year)->get();


    	// $campus_venue_reservation = DB::table('campus_venue_reservation')->get();
        $events = DB::table('events')->get();


       
        return view('campus_venue_reservation', ['CampusVenueReservationTable' => $events,'organizations' => $organizations,'schoolyears' => $schoolyears,'schoolyear' => $schoolyear]);
    }

          public function showCampusVenueReservationReports()
    {
      // $campus_venue_reservation = DB::table('campus_venue_reservation')->get();
        $events = DB::table('events')->get();

         $current_time = Carbon::now()->format('Y-m-d');


      $schoolyear = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->get();

       $selected_year = DB::table('school_years')->select('school_year')->where('term_name' , 'School Year')->whereDate('start', '<' ,$current_time)->whereDate('end' , '>', $current_time)->pluck('school_year');


      $schoolyears = DB::table('school_years')->select('school_year')->where('term_name', 'School Year')->where('school_year', '<>', $selected_year)->get();
       
        return view('campus_venue_reservation_reports', ['CampusVenueReservationTable' => $events,'schoolyears' => $schoolyears,'schoolyear' => $schoolyear ]);
    }



    public function getEvents()
    {
      $data  = DB::table('events')->get();

      foreach ($data as $key)
      {
        $events[] = array(
          'id' => $key->id,
          'title' => $key->title,
          'venue' => $key->venue,
          'organization' => $key->organization,
          'school_year' => $key->school_year,
          'status' => $key->status,
          'start' => $key->start,
          'end' => $key->end,
          'remark_status' => $key->remark_status,
          'cvf_no' => $key->cvf_no,
          ); 
      }

      return response()->json($events);  

    }
      public function getCampusVenueReservation()
    
    {
      // $campus_venue_reservation = DB::table('campus_venue_reservation')->get();
        $events = DB::table('events')->get();



        return Response::json($events);
    }
	
 	
    public function postCampusVenueReservationAdd(Request $request)
    {

        $validator = Validator::make($request->all(),[
            // 'title' => 'required',
          'title' => 'required|string|max:255',
          'venue' => 'required|string|max:255|available',
          'organization' => 'required|string|max:255',
          'status' => 'required|string|max:255',
          'time' => 'required',

        ]);

        
        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
          
        }

        else {
        $time = explode(" - ", $request->input('time'));


          $event = DB::table('events')->insert([  

            'title' => $request['title'],
            'venue' => $request['venue'],
            'organization' => $request['organization'],
            'school_year' => $request['school_year'],
            'status' => $request['status'],
            'start' => $time[0],
            'end'   => $time[1],
           // 'start'    => $this->change_date_format($time[0]),
           //  'end'    => $this->change_date_format($time[1]),


            // 'remark_status' => $request['remark_status'],
            'cvf_no' => $request['cvf_no']

            ]);



         return response()->json(array(
         'success' => true,
         'response' => $event,
          ));

          }


       
    }

     public function postCampusVenueReservationUpdate(Request $request)
    {


        $validator = Validator::make($request->all(),[
          
          'title' => 'required|string|max:255',
          'venue' => 'required|string|max:255|available1',
          'organization' => 'required|string|max:255',
          'status' => 'required|string|max:255',
          'time' => 'required',

        ]);
     
        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
          
        }
        else {
           
        $time = explode(" - ", $request->input('time'));

          $event = DB::table('events')->where('id', $request['update_id'])->update([ 
            'title' => $request['title'],
            'venue' => $request['venue'],
            'organization' => $request['organization'],
            'status' => $request['status'],
            'start' => $time[0],
            'end'   => $time[1],
            

            ]);
       
        return response()->json(array(
            'success' => true,
            'response' => $event
        ));
    }

}

  public function change_date_format($date)
  {
    $time = DateTime::createFromFormat('d/m/Y H:i:s', $date);
    return $time->format('Y-m-d H:i:s');
  }



      public function getCVFno()
    {

      $data = events::select(DB::raw('max(cast(substring(cvf_no,4,length(cvf_no)) as UNSIGNED)) as max_cvf'))->first();
      $data = $data->max_cvf;


      // $data  = DB::table('events')->max('cvf_no');

       // $data  = DB::table('events')->where('cvf_no', '1')->get();


      $year = date('y');

      $dog = "hoy";


      if($data == null)
      {
        $data =$year.'-1';
      }
      else
      {

        $data = $year.'-'.++$data;
      }

return response()->json($data);  
      // return json($data); 

    }


      public function postCampusVenueReservationReports(Request $request)
  {
  //WALA LAHAT ITO
    if ($request['v_reports_offense_level'] == "" and $request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['venue']=="" and $request['month']=="")
    {
          $data = events::where('school_year',$request['school_year'])->get();

    }
      //MERON MONTHS
    elseif ($request['v_reports_offense_level'] == "" and $request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['venue']=="")
    {
          $data = events::where('school_year',$request['school_year'])->whereMonth('start', '=',$request['month'])->get();

    }

        //PAG WALANG FROM AT TO AT VENUE AT MONTH
   elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['venue'] =="" and $request['month']=="" )
    {
          $data = events::where('school_year',$request['school_year'])->where('status',$request['v_reports_offense_level'])->get();

    }

                //PAG WALANG FROM AT TO AT VENUE
   elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['venue'] ==""  )
    {
          $data = events::where('school_year',$request['school_year'])->where('status',$request['v_reports_offense_level'])->whereMonth('start', '=',$request['month'])->get();

    }
    //PAG WALANG FROM AT TO AT CATEGORY AT MONTH
   elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['v_reports_offense_level'] =="" and $request['month']=="" )
    {
          $data = events::where('school_year',$request['school_year'])->where('venue',$request['venue'])->get();

    }

        //PAG WALANG FROM AT TO AT CATEGORY 
   elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['v_reports_offense_level'] =="" )
    {
          $data = events::where('school_year',$request['school_year'])->where('venue',$request['venue'])->whereMonth('start', '=',$request['month'])->get();

    }
    //PAG WALANG FROM AT TO AT MONTH
   elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="" and $request['month']=="")
    {
          $data = events::where('school_year',$request['school_year'])->where('venue',$request['venue'])->where('status',$request['v_reports_offense_level'])->get();

    }

        //PAG WALANG FROM AT TO 
   elseif ($request['v_reports_from'] =="" and $request['v_reports_to']=="")
    {
          $data = events::where('school_year',$request['school_year'])->where('venue',$request['venue'])->where('status',$request['v_reports_offense_level'])->whereMonth('start', '=',$request['month'])->get();

    }
    //PAG WALANG CATEGORY AT VENUE
    elseif ($request['v_reports_offense_level'] == "" and $request['venue'] =="" )
    {
          $data = events::whereBetween('start', [$request['v_reports_from'], $request['v_reports_to']])->where('school_year',$request['school_year'])->get();  
                      
    }
    //PAG WALANG VENUE
    elseif ($request['venue'] =="")
    {
          $data = events::whereBetween('start', [$request['v_reports_from'], $request['v_reports_to']])->where('school_year',$request['school_year'])->where('status',$request['v_reports_offense_level'])->get();  
                      
    }
        //PAG WALANG VENUE
    elseif ($request['v_reports_offense_level'] =="")
    {
          $data = events::whereBetween('start', [$request['v_reports_from'], $request['v_reports_to']])->where('school_year',$request['school_year'])->where('venue',$request['venue'])->get();  
                      
    }

    else
    {
 //LAHAT MERON
$data = events::whereBetween('start', [$request['v_reports_from'], $request['v_reports_to']])->where('status',$request['v_reports_offense_level'])->where('school_year',$request['school_year'])->where('venue',$request['venue'])->get();  
    // $data = events::join('students' , 'violation_reports.student_id' , '=' , 'students.student_no')->join('violations' , 'violation_reports.violation_id' , '=' ,'violations.id')->whereBetween('date_reported', [$request['v_reports_from'], $request['v_reports_to']])->where('violation_reports.offense_level' , $request['v_reports_offense_level'])->get();
    }    
     return response()->json(['data' => $data]);
  }

}



