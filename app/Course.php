<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Student;

class Course extends Model
{
	public $timestamps = false;
	
    public function students()
    {
    	return $this->hasOne('App\Student');
    }

    public function college()
    {
    	return $this->hasOne('App\College' , 'id' , 'college_id');
    }
}
