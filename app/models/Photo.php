<?php

class Photo extends \Eloquent {
	protected $fillable = ['user_id' , 'location' , 'source_id','source_type'];
}