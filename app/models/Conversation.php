<?php

class Conversation extends \Eloquent {
	protected $fillable = ['user1_id' , 'user2_id' , 'user1active' , 'user2active'];
}