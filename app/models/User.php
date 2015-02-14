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

	protected $fillable = ['email','name' , 'profile_pic' , 'password', 'address', 'contact' , 'company', 'dob', 'gender' ,'confirmed' , 'confirmation_code'];

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



	public function isadmin($group_id)
		{
			 $AdminGroups = Group::where('admin_id' , '='  , Auth::id())->get() ;

			 $x =$AdminGroups->count() ; //including user group where he/she is admin
			
			 if($x){

				 foreach ($AdminGroups as $UserGroup) {
				 	
				 	if($group_id == $UserGroup->id)
				 		return true; 
				 		
				 }
				 return false ;
			
			}else{
			
				return false ;
				
			}
		}

	public function group_lists()
	{
		 $UserGroups =  UserGroup::where('user_id' , '=' , $this->id )->where('active' , '=' , '1' )->get() ;
		 $AdminGroups = Group::where('admin_id' , '='  , $this->id)->get() ;

		 $x = $UserGroups->count() + $AdminGroups->count() + 1 ; //including user group where he/she is admin
		
		 $groupId[$x] = 0 ;//public post Group is 0
		 $x-- ;
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
			 return $groupId ;
		
		}else{
		
			return $groupId ;
			
		}
	}

	public function groups()
	{
	 
	 $UserGroups =  UserGroup::where('user_id' , '=' , $this->id )->where('active' , '=' , '1' )->get() ;
	 $AdminGroups = Group::where('admin_id' , '='  , $this->id)->get() ;

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
			
			 $group = Group::whereIn('id', $groupId )->get() ;

			 return $group ;
		
		}else{
		
			$group = Null ;

			return $group ;
			
		}
	}

	public static function unreadmessage(){

		$user_id = Auth::id() ;
		$Conversationlist = array();
		$conversations = Conversation::where('user1_id','=',$user_id)
		->orWhere('user2_id','=',$user_id)->get() ;

		foreach ($conversations as $Conversation) {
			$Conversationlist[] = $Conversation->id ;
		}
		
		if(!empty($Conversationlist)){
			$message = Message::whereIn('conversation_id',$Conversationlist)
			->where('seen','=',0)->where('user_id','!=',$user_id)->get()->count() ;
		}else{
			return 0 ;
		}
		return $message ;

	}


}
