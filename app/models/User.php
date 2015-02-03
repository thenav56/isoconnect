<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = ['email','name' , 'password', 'address', 'dob', 'gender'];

	public function Post()
	{
	return $this->hasMany('Post' , 'user_id');
	}

	public function Notification()
	{
	return $this->hasMany('Notification' , 'user_id');
	}

	public function NotificationUnseen()
	{
	return $this->hasMany('Notification' , 'user_id')->where('seen','=',0);
	}


	public function groups()
	{
	 
	 $UserGroups =  UserGroup::where('user_id' , '=' , $this->id )->where('active' , '=' , '1' )->get() ;
	 $AdminGroups = Group::where('admin_id' , '='  , Auth::id())->get() ;

		 $x = $UserGroups->count() + $AdminGroups->count() ; 
		
		 if($x){

			 foreach($UserGroups as $UserGroup)
			 {

			 	$groupId[$x] = $UserGroup->group_id ;
			 
			 	$x--;
			 }

			 foreach ($AdminGroups as $UserGroup) {
			 	
			 	$groupId[$x] = $UserGroup->id ;
			 
			 	$x--;
			 }
			
			 $group = Group::whereIn('id', $groupId ) ;

			 return $group ;
		
		}else{
		
			return Null ;
			
		}
	}



}
