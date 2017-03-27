<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    public function course()
    {
    	return $this->hasMany('App\Course', 'college_id', 'id');
    }

}
