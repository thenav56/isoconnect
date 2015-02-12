<?php

class Message extends \Eloquent {
	protected $fillable = ['conversation_id','user_id' , 'message' , 'seen'];
}