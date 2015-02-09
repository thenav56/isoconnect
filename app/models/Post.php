<?php

class Post extends Eloquent {
	protected $fillable = ['user_id' ,'post_body' , 'like' ,  'dislike' , 'group_id'];

	public function User()
	{
	return $this->belongsTo('User' , 'user_id');
	}

	public function comment()
	{
	 return $this->hasMany('Comment', 'post_id');
	}

	public function group()
	{
	 return $this->belongsTo('Group', 'group_id');
	}

	public function userlist()//list of users connected to post ..post author and user who commented
	{
		$comments = Comment::Distinct()->groupBy('user_id')->select('user_id')->where('post_id','=',$this->id)->get() ;
		  

		$x = $comments->count() + 1 ; 

		if($x){
			$userList[$x] = $this->user_id ;
			$x-- ;

			foreach ($comments as $comment) {
			  	$userList[$x] = $comment->user_id ;
				$x-- ;

			  }  

			  $users = User::whereIn('id',$userList)->get();
			  return $users ;
		}else{
			return Null ;
		}	

	}
}