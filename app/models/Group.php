<?php

class Group extends \Eloquent {
	protected $fillable = ['admin_id','name' , 'about'];

	public function post($value='')
	{
		return $this->hasMany('Post' , 'group_id');
	}

	public function admin()
	{
		return $this->belongsTo('User' , 'admin_id');
	}

	public function users()
	{
		 $UserGroups =  UserGroup::where('group_id' , '=' , $this->id , 'active' , '=' , '1' ) ;

		 $x = $UserGroups->count ; 
		
		 if($x){

		 	$userId = $UserGroups[0]->user_id ; 
		 
		 	$x--;
		 
			 foreach($UserGroups as $UserGroup)
			 {

			 	$userId .= ','.$UserGroup->user_id ;
			 
			 	$x--;
			 }

			 $user = User::where('id' , '=', $userId ) ;
		
			 return $user ;
		
		}else{
		
			return Null ;
			
		}
	}
}