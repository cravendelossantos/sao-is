<?php

namespace App\Providers;

use Validator, DB;

use Illuminate\Support\ServiceProvider;

class CheckVenueAvailability extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		// Validator return true if pass validation for room availability
		Validator::extend('availablee', function($attribute, $value, $parameters, $validator) {
			
			
			
			
			$time = explode(" - ", $value);
			
			$start = $this->change_date_format($time[0]);
			$end = $this->change_date_format($time[1]);
			
			
			
			

			
			// search for any possible clash with available events
			
			$scene1 = DB::table('events')
							
							->where('start_time', '<=', $start)
							->where('end_time', '>=', $end)
							->count();
			

			
			// if any event exist, means more than 0, return false
			if($scene1  > 0)
			{
				
				return false;
				
			}
			
			return true;
		});
		
				Validator::extend('available', function($attribute, $value, $parameters,$validator) {


				$time1 = $validator->getData();
						
		
		

			$time = explode(" - ",$time1['time'] );
			// dd($time);
			$start = $time[0];
			$end = $time[1];
			// $start = $this->change_date_format($time[0]);
			// $end = $this->change_date_format($time[1]);
			
			
	
			
			// search for any possible clash with available events
			
			$scene1 = DB::table('events')
							->where('venue','=',$value)
							->where('start', '<=', $start)
							->where('end', '>=', $end)
							->count();

			$scene2 = DB::table('events')
							->where('venue','=',$value)
							->where('start', '<', $start)
							->where('end', '>', $end)
							->count();
							
			$scene3 = DB::table('events')
							->where('venue','=',$value)
							->where('start', '>=', $start)
							->where('end', '<=', $end)
							->count();
							
			$scene4 = DB::table('events')
							->where('venue','=',$value)
							->where('end', '>', $start)
							->where('end', '<', $end)
							->count();
			
			$scene5 = DB::table('events')
							->where('venue','=',$value)
							->where('start', '>', $start)
							->where('start', '<', $end)
							->count();		
			
			
			if($scene1 + $scene2 + $scene3 + $scene4 + $scene5  > 0)
			{
				
				return false;
				
			}
			

		return true;
		});

					Validator::extend('available1', function($attribute, $value, $parameters,$validator) {


				$time1 = $validator->getData();
						
		
			$id = $time1['update_id'];

			$time = explode(" - ",$time1['time'] );
			// dd($time);
			$start = $time[0];
			$end = $time[1];
			// $start = $this->change_date_format($time[0]);
			// $end = $this->change_date_format($time[1]);

			
			// dd($time1);
	
			
			// search for any possible clash with available events
			$scene1 = DB::table('events')
							->where('id','<>',$id)
							->where('venue','=',$value)
							->where('start', '<=', $start)
							->where('end', '>=', $end)
							->count();


			$scene2 = DB::table('events')
							->where('id','<>',$id)
							->where('start', '<', $start)
							->where('end', '>', $end)
							->count();
							
			$scene3 = DB::table('events')
							->where('id','<>',$id)
							->where('start', '>=', $start)
							->where('end', '<=', $end)
							->count();
							
			$scene4 = DB::table('events')
							->where('id','<>',$id)
							->where('end', '>', $start)
							->where('end', '<', $end)
							->count();
			
			$scene5 = DB::table('events')
							->where('id','<>',$id)
							->where('start', '>', $start)
							->where('start', '<', $end)
							->count();		
			
			
			if($scene1 +$scene2 + $scene3 + $scene4 + $scene5  > 0)
			{
				
				return false;
				
			}
			

		return true;
		});
		
		
		
		
		
		// check time validity
		Validator::extend('duration', function($attribute, $value, $parameters, $validator) {
			
			$time = explode(" - ", $value);
			
			$start = $this->change_date_format($time[0]);
			$end = $this->change_date_format($time[1]);
			
			if(abs(strtotime($end) - strtotime($start)) == 0)
			{
				return false;	
			}
			return true;
		});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
	
	public function change_date_format($date)
	{
		$time = \DateTime::createFromFormat('d/m/Y H:i:s', $date);
		return $time->format('Y-m-d H:i:s');
	}
}
