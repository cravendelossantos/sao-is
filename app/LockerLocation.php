<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LockerLocation extends Model
{

	public $timestamps = false;
	
    public function locker()
    {
    	return $this->hasMany('App/Locker', 'location_id', 'id');
    }
}
