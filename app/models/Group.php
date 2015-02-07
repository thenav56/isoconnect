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
		 $UserGroups =  UserGroup::where('group_id' , '=' , $this->id )->where('active' , '=' , '1' )->get() ;

		 $x = $UserGroups->count() + 1 ; 
		
		 $userId[$x] = $this->admin_id ; 
		 $x-- ;

		 if($x){		 
			 foreach($UserGroups as $UserGroup)
			 {

			 	$userId[$x]  = $UserGroup->user_id ;
			 
			 	$x--;
			 }

			 $user = User::whereIn('id' , $userId )->get() ;
		
			 return $user ;
		
		}else{
		
			return Null ;
			
		}
	}
}