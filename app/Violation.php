<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    public function reports()
    {
    	return $this->hasMany('App\ViolationReport');
    }
}
