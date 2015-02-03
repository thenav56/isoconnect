<?php

class Comment extends \Eloquent {
	protected $fillable = ['post_id' , 'user_id' , 'like' , 'dislike' , 'comment_body'];


	public function Post()
	{
		return $this->belongsTo('Post' , 'post_id') ;
	}

	public function User()
	{
		return $this->belongsTo('User' , 'user_id');
	}


}