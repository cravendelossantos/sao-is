<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Student;

class YearLevel extends Model
{
    public function students_year()
    {
    	return $this->belongsToMany('App\Student');
    }
}
