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
use App\SchoolYear;
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
        $events = DB::table('events')->get();
        $current_school_year = SchoolYear::currentSchoolYear();
        $organizations = DB::table('requirements')
        ->where('school_year',$current_school_year)
        ->get();
        
        return view('campus_venue_reservation', ['CampusVenueReservationTable' => $events,'organizations' => $organizations,'current_school_year' => $current_school_year]);
    }

    public function showCampusVenueReservationReports()
    {
        $events = DB::table('events')->get();
        $current_school_year = SchoolYear::currentSchoolYear();
        $school_year_selection = SchoolYear::schoolYearSelection();

        return view('campus_venue_reservation_reports', ['CampusVenueReservationTable' => $events,'school_year_selection' => $school_year_selection,'current_school_year' => $current_school_year ]);
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
        $events = DB::table('events')->get();
        return Response::json($events);
    }

    public function postCampusVenueReservationAdd(Request $request)
    {
        $validator = Validator::make($request->all(),[
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
              'start' => Carbon::parse($time[0]),
              'end'   => Carbon::parse($time[1]),
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

    public function getCVFno()
    {
        $data = events::select(DB::raw('max(cast(substring(cvf_no,4,length(cvf_no)) as UNSIGNED)) as max_cvf'))
        ->first();
        
        $data = $data->max_cvf;
        $year = date('y');

        if($data == null){
            $data =$year.'-1';
        } 
        else {
            $data = $year.'-'.++$data;
        }

        return response()->json($data);  
    }

    public function postCampusVenueReservationReports(Request $request)
    {
        return events::reports($request);
    }

}



