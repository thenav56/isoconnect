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


	public static function handleText($text){
		 
		 // The Regular Expression filter for links
                $reg_exUrl = "/(((http|https|ftp|ftps)\:\/\/)|())[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                $_reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                

		if(preg_match($reg_exUrl, $text, $url)) {

           // make the urls hyper links
           return preg_replace_callback($reg_exUrl, 
            function($url) use($_reg_exUrl){
                if(preg_match($_reg_exUrl, $url[0]))
                    return "<a target='_blank' href=".$url[0].">".$url[0]."</a> " ;
                else
                    return "<a target='_blank' href=http://".$url[0].">".$url[0]."</a> " ;
            }, $text);

    } else {

           // if no urls in the text just return the text
           return $text;

    }
	}
}

