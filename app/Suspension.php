<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    public $timestamps = false;

    public static function table($request)
    {
    	$suspended = self::join('students', 'suspensions.student_id' , '=', 'students.student_no')
    	->where('status', 'On going');
        
        return Datatables::of($suspended)
            ->filter(function ($query) use ($request) {
                if ($request->has('suspensions_student_no')) {
                    $query->where('student_no', 'like', "%{$request->get('suspensions_student_no')}%");
                }
            })
        ->make(true);
    }
}
