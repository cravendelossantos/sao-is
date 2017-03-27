<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class LostAndFound extends Model
{
	protected $fillable = ['item_description','endorser_name','founded_at','owner_name'];
	
	public $timestamps = false;

    public function user()
	{
		return $this->belongsTo('App\User');
	}

}
