<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Content;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $time = date("H");

        $content = Content::where('page', 'home')->first();

        if ($time < "12") {
            $message =  "Good morning";
            $icon = '<i class="wi wi-day-sunny-overcast fa-4x" id="weather-icon"></i>';
        } 
        else if ($time >= "12" && $time < "17") {
            $message =  "Good afternoon";
            $icon = '<i class="wi wi-day-cloudy fa-4x pull-left" id="weather-icon"></i>';
        } 
        else if ($time >= "17" && $time < "19") {
            $message = "Good evening";
            $icon = '<i class="wi wi-night-alt-cloudy fa-4x" id="weather-icon"></i>';
        } 
        else if ($time >= "19") {
            $message = "Good night";
            $icon = '<i class="wi wi-night-alt-partly-cloudy fa-4x" id="weather-icon"></i>';
        }   
        return view('index',['icon' => $icon, 'greeting' => $message, 'content' => $content]);
    }

}
