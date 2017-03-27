<?php

namespace App\Http\Middleware;

use Closure;
use App\Content;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $content = Content::where('page', '401')->first();

    	if ($request->user() == null){
    		return redirect('/login');
    	}

		$actions = $request->route()->getAction();
		$roles = isset($actions['roles']) ? $actions['roles'] : null;
		
		if ($request->user()->hasAnyRole($roles) || !$roles){ 
			 return $next($request);
		}
			 return response()->view('errors.401', ['content' => $content], 401);
       
    }
}
