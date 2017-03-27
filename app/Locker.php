<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{

	public $timestamps = false;

    public function location()
    {
    	return $this->belongsTo('App\LockerLocation', 'id' , 'location_id');
    }
}
