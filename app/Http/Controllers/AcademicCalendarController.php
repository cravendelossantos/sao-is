<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AcademicCalendar;
use App\Http\Requests;

class AcademicCalendarController extends Controller
{
    public function showCalendar()
    {
    	return view('academic_calendar');
    }

    public function postEvents()
    {
    	$data  = AcademicCalendar::all();

      foreach ($data as $key)
      {
        $events[] = array(
          'id' => $key->id,
          'title' => $key->title,
          'start' => $key->start,
          'end' => $key->end,
          ); 
      }

      return response()->json($events);  
    }
}
