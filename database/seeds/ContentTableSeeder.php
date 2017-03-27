<?php

use Illuminate\Database\Seeder;
use App\Content;


class ContentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$login_page = new Content();
    	$login_page->page = "Login Page";
        $login_page->value = '<h3 style="box-sizing: border-box; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: #8c0001; margin-top: 20px; margin-bottom: 10px; font-size: 14pt;"><span style="font-family: verdana, geneva, sans-serif;"><strong style="box-sizing: border-box;">Vision</strong></span></h3>
        <p style="box-sizing: border-box; margin: 0px 0px 10px; color: #333333; font-family: Times New Roman; font-size: 14.6667px;"><span style="font-family: verdana, geneva, sans-serif;">An internationally accredited university dedicated to innovation and excellence in the service of God and country.</span></p>
        <h3 style="box-sizing: border-box; font-family: Helvetica Neue, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: #8c0001; margin-top: 20px; margin-bottom: 10px; font-size: 14pt;"><span style="font-family: verdana, geneva, sans-serif;"><strong style="box-sizing: border-box;">Mission</strong></span></h3>
        <p style="box-sizing: border-box; margin: 0px 0px 10px; color: #333333; font-family: Times New Roman; font-size: 14.6667px;"><span style="font-family: verdana, geneva, sans-serif;">The Lyceum of the Philippines University - Cavite, espousing the ideals of Jose P. Laurel, is committed to the following mission:</span></p>
        <ol style="box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: #333333; font-family: Times New Roman; font-size: 14.6667px;">
            <li style="box-sizing: border-box;"><span style="font-family: verdana, geneva, sans-serif;">Advance and preserve knowledge by undertaking research and disseminating and utilizing the results. -&nbsp;<strong style="box-sizing: border-box;">RESEARCH</strong></span></li>
            <li style="box-sizing: border-box;"><span style="font-family: verdana, geneva, sans-serif;">Provide equitable access to learning through relevant, innovative, industry-based and environment-conscious programs and services in the context of nationalism and internationalism. -&nbsp;<strong style="box-sizing: border-box;">INSTRUCTION</strong>&nbsp;and&nbsp;<strong style="box-sizing: border-box;">QUALITY SERVICES</strong></span></li>
            <li style="box-sizing: border-box;"><span style="font-family: verdana, geneva, sans-serif;">Provide necessary knowledge and skills to meet entrepreneurial development and the managerial requirements of the industry. -&nbsp;<strong style="box-sizing: border-box;">INSTRUCTION</strong></span></li>
            <li style="box-sizing: border-box;"><span style="font-family: verdana, geneva, sans-serif;">Establish local and international linkages that will be the source of learning and growth of the members of academic community. -&nbsp;<strong style="box-sizing: border-box;">INSTRUCTION</strong>&nbsp;and&nbsp;<strong style="box-sizing: border-box;">INSTITUTIONAL</strong><strong style="box-sizing: border-box;">DEVELOPMENT</strong></span></li>
            <li style="box-sizing: border-box;"><span style="font-family: verdana, geneva, sans-serif;">Support a sustainable community extension program and be a catalyst for social transformation and custodian of Filipino culture and heritage. -&nbsp;<strong style="box-sizing: border-box;">COMMUNITY EXTENSION</strong></span></li>
            <li style="box-sizing: border-box;"><span style="font-family: verdana, geneva, sans-serif;">Build a community of God-centered, nationalistic, environment conscious, and globally competitive professionals with wholesome values and attitudes. -&nbsp;<strong style="box-sizing: border-box;">PROFESSIONALISM</strong>&nbsp;and&nbsp;<strong style="box-sizing: border-box;">VALUES</strong></span></li>
        </ol>';
        $login_page->save();




        $home_page = new Content();
        $home_page->page = "Home";
        $home_page->value = "Welcome to Student Affairs Office Home Page!";
        $home_page->save();




        $error_401 = new Content();
        $error_401->page = "401";    
        $error_401->value = '<div class="middle-box text-center animated fadeInDown">
        <h1 style="box-sizing: border-box; margin: 20px 0px 10px; font-size: 170px; font-family: open sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-weight: 100; line-height: 1.1; color: #676a6c; text-align: center; background-color: #f3f3f4;">401</h1>
        <h3 class="font-bold" style="box-sizing: border-box; font-family: open sans, Helvetica Neue, Helvetica, Arial, sans-serif; line-height: 1.1; color: #676a6c; margin-top: 5px; margin-bottom: 10px; font-size: 16px; text-align: center; background-color: #f3f3f4;">401 - Unauthorized: Access Denied!</h3>
        <div class="error-desc" style="box-sizing: border-box; color: #676a6c; font-family: open sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 13px; font-weight: normal; text-align: center; background-color: #f3f3f4;">You do not have permission to view this directory or page!</div>
    </div>';

    $error_401->save();


    $error_404 = new Content();
    $error_404->page = "404"; 
    $error_404->value = '<div class="middle-box text-center animated fadeInDown">
    <h1 style="box-sizing: border-box; margin: 20px 0px 10px; font-size: 170px; font-family: open sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-weight: 100; line-height: 1.1; color: #676a6c; text-align: center; background-color: #f3f3f4;">404</h1>
    <h3 class="font-bold" style="box-sizing: border-box; font-family: open sans, Helvetica Neue, Helvetica, Arial, sans-serif; line-height: 1.1; color: #676a6c; margin-top: 5px; margin-bottom: 10px; font-size: 16px; text-align: center; background-color: #f3f3f4;">Page Not Found</h3>
    <div class="error-desc" style="box-sizing: border-box; color: #676a6c; font-family: open sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 13px; font-weight: normal; text-align: center; background-color: #f3f3f4;">Sorry, but the page you are looking for has not been found. Try checking the URL for errors, then hit the refresh button on your browser.</div>
</div>';
$error_404->save();
}
}
