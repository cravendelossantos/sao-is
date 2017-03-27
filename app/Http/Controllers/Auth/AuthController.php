<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Role;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Content;
use Lang;
use Session;
use Cache;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $loginPath = '/login';
    protected $redirectAfterLogout = '/home';
    protected $loginView ="/login";


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
        

    public function showLoginForm()
    {
   
        $content = Content::where('page', 'LIKE', '%login%')->first();

        $view = property_exists($this, 'loginView')
                    ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }


        return view('auth.login', ['content' => $content]);
    }
    
    protected function getFailedLoginMessage()
    {
        return trans('validation.wrong_credentials');
    }
    
    public function logout()
    {
        Auth::guard($this->getGuard())->logout();
        Session::flush();
        Cache::flush();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/home');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json(array('success'=> false,'errors' => $validator->getMessageBag()->toArray()));
        }
        else{
            $this->create($data->all());
        }
    }

    protected function postRegister(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'first_name'  => 'required|min:2|string',  
            'last_name'  => 'required|min:2|string',     
            'email' => 'email|required|unique:users,email', 
            'password'=>'required|alpha_num|min:6|confirmed',
            'password_confirmation' =>'', 

        ]);
    
        if($validator->fails()){
                return response()->json(array('success'=> false,'errors' => $validator->getMessageBag()->toArray()));
        }
        else{
       
        $role_admin = Role::where('name', 'Admin')->first();    

        $user = new User();
        $user->first_name = ucwords($request['first_name']);
        $user->last_name = ucwords($request['last_name']);
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();
        $user->roles()->attach($role_admin);
        Auth::logout($user);

        }
    }

  
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(Request $Request)
    {
        
    }


    public function showForgotPassword()
    {
        return view('forgot_password');
    }
}
