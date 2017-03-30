<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exclusion extends Model
{
    public $timestamps = false;

    public static function table($request)
    {
    	$suspended = self::join('students', 'exclusions.student_id' , '=', 'students.student_no');
        
        return Datatables::of($suspended)
            ->filter(function ($query) use ($request) {
                if ($request->has('suspensions_student_no')) {
                    $query->where('student_no', 'like', "%{$request->get('suspensions_student_no')}%");
                }
            })
           ->make(true);
    }
}
