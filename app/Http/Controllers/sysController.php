<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\User;
use App\LostAndFound;
use Carbon\Carbon;
use DateTime;
use App\Course;
use Response;
use App\Role;
use Yajra\Datatables\Facades\Datatables;
use Image;
use Hash;
use App\Content;
use App\Classes\Gammu;
use Redirect;
use App\TextMessage;
use App\College;

class sysController extends Controller {
	
	public function __construct()
    {
        $this->middleware('roles');
    }

    public function showNotes()
    {
        return view('notes');
    }

    public function showCMSpage()
    {
        $pages = Content::all();

        return view('content_management',['pages' => $pages]);
    }
 
    public function loadContent(Request $request)
    {
        return Content::where('id', $request['page_id'])->first();
    }

    public function postCMS(Request $request)
    {
        $messages = [
            'page_id.required' => 'Please choose a page to be edited',
        ];
        
        $validator= Validator::make($request->all(),[
            'page_id' => 'required',
        ],$messages);
    
        if($validator->fails()){
        
             return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 

        } else {
       
            $new_content = Content::where('id',$request['page_id'])->update(['value' => $request['new_content']]);
        
            return Response::json(['success' => true, 'response' => ''], 200);
        }
    }

    public function changePassword(Request $request)
    {

        $validator= Validator::make($request->all(),[
            'old_password' => 'required',
            'password'=>'required|alpha_num|min:6|confirmed',
            'password_confirmation' =>'required',

        ]);
    
        if($validator->fails()){
        
                 return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
        }
        else {
            $old_pass = Auth::user()->password;

            if ( Hash::check($request['old_password'], $old_pass)){
                $user = Auth::user();
                $user->password = Hash::make($request['password']); 
                $user->save();

                return Response::json(['success' => true, 'response' => 'Password Successfully Changed!'], 200);
            }   
            else{
                $messages = ['message' => 'Old password is wrong!'];
                return Response::json(['success' => false, 'errors' => $messages], 400);
            }
        }
    }

    public function updateAvatar(Request $request)
    {
     
        $validator= Validator::make($request->all(),[
            'avatar' => 'image|mimes:jpeg,jpg,png',

        ]);
    
        if($validator->fails()){
            //wrong extension
            return back()->with('errors' , 'Image must be a type of JPG/JPEG or PNG' );
        }


        if ($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' .$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/img/avatars/' .$filename));

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        } else {
            //no file
            return back()->with('errors' , 'Please choose an image' );
        }

       
        return back()->with('success' , 'Profile picture successfully saved!');
    }

    public function showEditAccount()
    {
        return view('edit_account');
    }

    public function getEditAccount(Request $request)
    {   


        $messages = [
            'contact_number.regex' => 'Contact number must start with (+63)',
            'contact_number.digits' => 'Contact number must be 13 digits',
        ];
         $validator= Validator::make($request->all(),[
            'first_name'  => 'required|min:2|string',  
            'last_name'  => 'required|min:2|string',
            'birthdate' => 'required|date',
            'contact_number' => array ('required', 'numeric', 'regex:/^(\+639)\d{9}$/', 'digits:13'),
            'address' => 'required|string', 
            'email' => 'email|required|unique:users,email,'.Auth::user()->id, 
            

        ],$messages);
    
        if($validator->fails()){
        
                 return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
        }
    }

    public function postEditAccount(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        $user->first_name = ucwords($request['first_name']);
        $user->last_name = ucwords($request['last_name']);
        $user->birthdate = $request['birthdate'];
        $user->contact_no = $request['contact_number'];
        $user->address = ucwords($request['address']);
        $user->email = $request['email'];
        $user->save();

       return Response::json(['success' => true, 'data' => $user, 'response' => 'Account successfully updated'], 200);

    }   

    public function showDateSettings()
    {   
        $semesters = DB::table('school_years')->get();
        return view('date_settings', ['semesters' => $semesters]);
    }

    public function getDateSettings(Request $request)
    {
        $validator= Validator::make($request->all(),[
            
            'first_semester_start_date'  => 'required|date',  
            'first_semester_end_date'  => 'required|date',
            'second_semester_start_date' => 'required|date',
            'second_semester_end_date'=> 'required|date',
            'summer_start_date' => 'required|date',
            'summer_end_date' => 'required|date',
            'school_year' =>'required|unique:school_years,term_name', 


        ]);
        
        if($validator->fails()){
        
                 return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
        }
          



        
    }

    public function postDateSettings(Request $request)
    {




     /*   $ranges = array($request['first_semester_start_date'],
                       $request['first_semester_end_date'],
                       $request['second_semester_start_date'],
                       $request['second_semester_end_date'],
                       
                );

    

             $sems = (count($ranges)/2);


             $ranges = implode(",", $ranges);
             

             DB::table('school_years')->insert([
                'name' => $request['description'],
                'no_of_terms' => $sems,    
                'range' => $ranges,


                ]);

            for ($i=0; $i <= $sems; $i++)
            {   
            DB::table('semesters')->insert([
                'range' => $ranges,
                
                ]); 
            }*/
$data = array(
    array('school_year' => $request['school_year']  ,
          'term_name' => 'First Semester',
          'start'=> Carbon::parse($request['first_semester_start_date'])->format('Y-m-d'),
          'end'=> Carbon::parse($request['first_semester_end_date'])->format('Y-m-d')),
    
    array('school_year' => $request['school_year'],
          'term_name' => 'Second Semester',
          'start'=> Carbon::parse($request['second_semester_start_date'])->format('Y-m-d'),
          'end'=> Carbon::parse($request['second_semester_end_date'])->format('Y-m-d')),

    array('school_year' => $request['school_year'], 
          'term_name' => 'Summer',
          'start'=> Carbon::parse($request['summer_start_date'])->format('Y-m-d'), 
          'end'=> Carbon::parse($request['summer_end_date'])->format('Y-m-d')),

    array('school_year' => $request['school_year'], 
          'term_name' => 'School Year',
          'start'=> Carbon::parse($request['first_semester_start_date'])->format('Y-m-d'), 
          'end'=> Carbon::parse($request['summer_end_date'])->format('Y-m-d')),
            
    
    //...
);



        $sy = DB::table('school_years')->insert($data);
/*
        $a = DB::table('school_years')->insert([
                'name' => $request['description'],
                'no_of_terms' => 2,
            ]);*/


        
         /*return Response::json(['success' => true, 'sems' => $sems , 'shool_year' => $request['description'], 'date_ranges' => $ranges, ], 200);*/
         return Response::json(['success' => true, 'data' => $data], 200);
  
       
    }

    public function showSchoolYears()
    {

            $sy = DB::table('school_years')->where('term_name', 'School Year')->get();             
/*
             foreach ($sy as $key => $value) {
                    $data[] = ['ranges' => [$value->range],
                            'school_year' => $value->school_year,
                            'semesters' => $value->semesters,

                    ];

                }  */


             


            return response()->json(['data' => $sy]);
    }



    //Admin secretary/admin account registration

      public function showRegisterAdmin()
    {
        $roles = Role::all();
        return view('user_management_admin',['roles' => $roles]);
    }

    public function getRegisterAdmin(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'first_name'  => 'required|min:2|string',  
            'last_name'  => 'required|min:2|string',
            'birthdate' => 'required|date',
            'contact_number' => 'required|numeric|digits:10|unique:users,contact_no',
            'address' => 'required|string', 
            'email' => 'email|required|unique:users,email', 
            'password'=>'required|alpha_num|min:6|confirmed',
            'password_confirmation' =>'',
            'user_type' => 'required|exists:roles,name', 

        ]);
    
        if($validator->fails()){
        
                 return Response::json(['success'=> false, 'errors' =>$validator->getMessageBag()->toArray()],400); 
        }
    }

    public function postRegisterAdmin(Request $request)
    {

        if ($request['user_type'] == 'Admin')
        {
            $role = Role::where('name', 'Admin')->first();   
          
        }
        else if ($request['user_type'] == 'Secretary') 
        {
            $role = Role::where('name' , 'Secretary')->first();
            
        } 
        

        $user = new User();
        $user->first_name = ucwords($request['first_name']);
        $user->last_name = ucwords($request['last_name']);
        $user->birthdate = $request['birthdate'];
        $user->contact_no = "+63".$request['contact_number'];
        $user->address = ucwords($request['address']);
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();
        $user->roles()->attach($role);
        //Auth::logout($user);

        return Response::json(['success' => true, 'response' => $user], 200);
    }

    public function showRoles()
    {   
        $users = User::all();
        return view('roles_management', ['users' => $users]);
    }

    public function postAdminAssignRoles(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();
   

        if ($request['role_admin']) {
            $user->roles()->attach(Role::where('name', 'Admin')->first());
        }


        if ($request['role_secretary']) {
            $user->roles()->attach(Role::where('name', 'Secretary')->first());
        }

        return back()->with('success' , 'Role(s) successfully assigned.');
    }

    public function postAdminRevoke(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();
       /* $user->delete();*/

         return back()->with('success' , 'User access successfully revoked.');
       
    }


    public function showSMS()
    {
        $credits = $this->itexmoBalance();
        $keys = DB::table('itexmo_key')->first();

        return view('text_messaging',['credits' => $credits, 'keys' => $keys]);
    }

    public function updateApiCode(Request $request)
    {   
        $messages = [
            'api_code.required' => 'API Code is required',
        ];
        
        $validator= Validator::make($request->all(),[
            'api_code' => 'required',
        ],$messages);
    
        if($validator->fails()){
        
            return Redirect::back()->withErrors($messages);

        } else {
       
            $update = DB::table('itexmo_key')->where('id', $request['api_code_id'])
            ->update(['api_code' => $request['api_code']]);
            
            return back()->with('api_code_response' , 'API Code Successfully Changed!');
        }
        
    }

    /*public function getussd(Request $request)
    {
        $ussd_code = $request['ussd_code'];

        try {
            
        $a = system("gammu getussd $ussd_code".$ussd_code, $message);
        
          return back()->with('ussd' , $message);
        
        } catch (Exception $e) {
            return back()->with('ussd' , $e);
        }
        
    }*/


    public function compose(Request $request)
    {
        $_number = $request['mobile_number'];
        $_message = $request['message'];
        $_apikey = $request->input('api_key');
        $_message_type = "Manual";

        if (strpos($request['mobile_number'] , '+63') !== false)
        {
            $_number = str_replace("+63", "0", $_number);          
        }
        $response = $this->sendSMS($_number,$_message,$_apikey,$_message_type);
    
        return Response::json(['success' => true, 'response' => $response], 200);
    }


    public function sendSMS($_number,$_message,$_apikey,$message_type)
    {
       
        
        $result = $this->itexmo($_number,$_message,$_apikey);
        if ($result == ""){
            $is_sent = false;
            $response = "iTexMo: Please check your internet connection.";  
        }else if ($result == 0){

            $response = "Message Successfully Sent!";
            $is_sent = true;
            $date_sent = Carbon::now()->format('Y-m-d');
            $time_sent = Carbon::now()->format('h:i');

            $new_message = new TextMessage();
            $new_message->recipient = $_number;
            $new_message->message = $_message;
            $new_message->sent = $is_sent;
            $new_message->type = $message_type;
            $new_message->date_sent = $date_sent;
            $new_message->time_sent = $time_sent;
            $new_message->save();

        }
        else{

            $is_sent = false;
            $date_sent = "";
            $time_sent = "";

            switch ($result) {
                case '1':
                    $response = "Invalid number";
                    break;
                case '2':
                    $response = "Number not Supported";
                    break;
                case '3':
                    $response = "Invalid API Code";
                    break;
                case '4':
                    $response = "Maximum Message per day reached.";
                    break;
                case '5':
                    $response = "Maximum allowed characters for message reached. 
";
                    break;
                case '6':
                    $response = "System OFFLINE";
                    break;
                case '7':
                    $response = "Your API Code is expired. Please go to iTexMo.com and purchase a new package.";
                    break;
                case '8':
                    $response = "Server Error";
                    // iTexMo Error. Please try again later. 
                    break;
                case '9':
                    $response = "Invalid Function Parameters.";
                    break;
                case '10':
                    $response = "Recipient's number is blocked due to FLOODING, message was ignored.";
                    break;
                case '11':
                    $response = "Recipient's number is blocked temporarily due to HARD sending (after 3 retries of sending and message still failed to send) and the message was ignored. Try again after an hour.";
                    break;
                case '12':
                    $response = "Invalid request. You can't set message priorities on non corporate API Codes";
                    break;
                default:
                    $response = "Message Successfully Sent!";
                    break;
            }
            //echo "Error Num ". $result . " was encountered!";
        }

        return array(['response' => $response, 'sent' => $is_sent]);
        

        //GAMMU   
        /*$a = popen('gammu sendsms TEXT '.$_number.' -text "'.$_message.'"', 'r'); 
        while($b = fgets($a, 2048)) { 
            
            $message = $b."\n"; 
            if (strpos($message, 'OK') !== false){
                $message = 'Message Sent!';
            }
            return back()->with('response' , $message);
            ob_flush();flush(); 
        } 
        pclose($a); 
        */
     

   }

    public function showSMSLog()
    {
        $messages = TextMessage::all();
        return view('sms_log',['messages' => $messages]);
    }

    public function itexmo($number,$message,$apicode)
    {
        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
        $param = array(
                'http' => array(
                //'ignore_errors' => TRUE,
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($itexmo),
            ),
        );
        $context  = stream_context_create($param);
        return @file_get_contents($url, false, $context);


        /*if ($contents == false) {
            return null;
        }
        else{
            $credits = $contents;
            return $credits;
        }*/


    }

    public function itexmoBalance()
    {
        $apicode = DB::table('itexmo_key')->first();

        if (empty($apicode->api_code))
        {
            $credits = false;
            return $credits;
        }
        else
        {
        $url = 'https://www.itexmo.com/php_api/api.php';
        $itexmo = array('4' => $apicode->api_code);
        $param = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($itexmo),
            ),
        );

        $context  = stream_context_create($param);
        $contents = @file_get_contents($url, false, $context);

        if ($contents == false) {
            return null;
        }
        else{
            $credits = $contents;
            return $credits;
        }
        }
        
    }

    public function itexmoStatus()
    {
      $apicode = 'JOHNA237118_FZX48';
      $url = 'https://www.itexmo.com/php_api/serverstatus.php';
      $itexmo = array('apicode' => $apicode);
      $param = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET',
            'content' => http_build_query($itexmo),
            ),
        );
      $context  = stream_context_create($param);
      return @file_get_contents($url, false, $context);
    }   

	public function showCommunityService()
    {
        return view('community_service');
    }
	
	public function showViolation()
    {
    	$violation_table = DB::table('violations')->get();
        return view('violation', ['violationTable' => $violation_table ]);
    }

	/*public function postViolation(Request $request)
	{
		$validator = Validator::make($request->all(),[
        	
            'offense_level' => 'required|max:255',
            'violationName' => 'required|max:255',
            'violationDescription' => 'required|max:255',            
      		'first_offense_sanction' => 'required|max:255',
            'second_offense_sanction' => 'required|max:255',
            'third_offense_sanction' => 'required|max:255',
	    ]);

        if ($validator->fails()) {
            return response()->json(array('success'=> false, 'errors' =>$validator->getMessageBag()->toArray())); 
          
        }
		else {
	
			$violation = DB::table('violations')->insert([			
            
            'offense_level' => $request['offense_level'],
            'name' => $request['violationName'],
            'description' => $request['violationDescription'],
            'first_offense_sanction' => $request['first_offense_sanction'],
            'second_offense_sanction' => $request['second_offense_sanction'],
 	        'third_offense_sanction' => $request['third_offense_sanction'],
            'created_at' => Carbon::now(),
        ]);
			
		}
		
	}*/
	public function showSanctions()
    {
        return view('sanction_monitoring');
    }
	
		
	public function showCourses()
    {
    	$courses = Course::with('college')->get();
        $colleges = College::all();

        return view('courses',['courses' => $courses], ['colleges' => $colleges]);
    }

	public function postCourse(Request $request)
	{
        $validator = Validator::make($request->all(),[
            
            'course_description' => 'required|max:255|unique:courses,description',
            'college_id' => 'required',
            'course_length' => 'required|integer|between:1,5',
        ]);

        if ($validator->fails()) {
            return Response::json(['success'=> false, 'errors' => $validator->getMessageBag()->toArray()],400); 
        }
        else {
            

            $course = new Course();
            $course->description = ucwords($request['course_description']);
            $course->college_id = $request['college_id'];
            $course->no_of_years = $request['course_length'];
            $course->save();    

            return Response::json(['success'=> true, 'response' => 'Course Added!'], 200); 
        }
	}
	
    public function showColleges()
    {
        $courses = Course::with('college')->get();
        $colleges = College::all();

        return view('colleges',['courses' => $courses], ['colleges' => $colleges]);
    }

    public function postColleges(Request $request)
    {
        $validator = Validator::make($request->all(),[
            
            'college_description' => 'required|max:255|unique:colleges,description',
        ]);

        if ($validator->fails()) {
            return Response::json(['success'=> false, 'errors' => $validator->getMessageBag()->toArray()],400); 
        }
        else {
    
            $course = new College();
            $course->description = ucwords($request['college_description']);
            $course->save();    

            return Response::json(['success'=> true, 'response' => 'College Added!'], 200); 
        }
    }

	
}
