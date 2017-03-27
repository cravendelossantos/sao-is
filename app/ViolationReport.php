<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ViolationReport extends Model
{
	public $timestamps = false;
	
    public function students()
    {
    	return $this->belongsToMany('App\Student');
    }

    public function violations()
    {
    	return $this->hasMany('App\Violation');
    }

    public static function maxViolationId()
    {
        $id = ViolationReport::select(DB::raw('max(cast((substring(rv_id, 5)) as UNSIGNED)) as max_id'))->first();
            
            if ($id == null){
                $id = 'SAO_VR-1';
            }
            else{
                $id = $id->max_id;
                $id = 'SAO_VR-'.++$id;
            } 

        return $id;
    }
}
