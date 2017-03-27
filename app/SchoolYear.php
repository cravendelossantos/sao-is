<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SchoolYear extends Model
{
    protected static function now()
    {
        return Carbon::now()->format('Y-m-d');
    }

    public static function currentSchoolYear()
    {
    	$school_year = SchoolYear::where('term_name' , 'School Year')
    		->whereDate('start', '<' ,self::now())
    		->whereDate('end' , '>', self::now())
    		->first();

    	if (is_null($school_year))
    	{
            return null;
    	}
        else
        {
            $current_sy = $school_year->school_year;
            return $current_sy;
        }
    }

    public static function selectedYear()
    {
        $selected_year = SchoolYear::select('school_year')
            ->where('term_name' , 'School Year')
            ->whereDate('start', '<' ,self::now())
            ->whereDate('end' , '>',self::now())
            ->pluck('school_year');

        if ($selected_year->isEmpty())
        {
            return null;
        }    
        return $selected_year;
    }

    public static function schoolYearSelection()
    {
        $schoolyears = SchoolYear::select('school_year')
            ->where('term_name', 'School Year')
            ->where('school_year', '<>', self::selectedYear())
            ->get();

        if ($schoolyears->isEmpty())
        {
            return null;
        }
            $selection = $schoolyears;
            return $selection;
    }
}
