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
}