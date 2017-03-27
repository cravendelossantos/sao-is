<?php

namespace App;
use App\LostAndFound;
use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as ResetPassword;


class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    public function roles()
	{
		return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
	}
    
	public function hasAnyRole($roles)
	{
		if (is_array($roles)){
			foreach ($roles as $role){
				if ($this->hasRole($role)){
					return true;
				}				
			}
		} else{
			if ($this->hasRole($role)){
					return true;
			}				
		}
		return false;
	}
	
	public function hasRole($role)
	{
		if ($this->roles()->where('name', $role)->first()){
			return true;
		}
		return false;
	}
	
    public function postItem()
	{
		return $this->hasMany('App\LostAndFound');
	} 
	protected $table="users";
	

    protected $fillable = [
        'first_name' , 'last_name' , 'email', 'password', 'address', 'birthdate', 'contact_no',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}