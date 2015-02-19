<?php

class MessagesController extends \BaseController {

 
	public function showMessagelist()
	{
		 
		$conversations =  Conversation::
		 where('user1_id','=',Auth::id())->orWhere('user2_id','=',Auth::id())->orderBy('updated_at','desc')->simplepaginate();

		$messages = array() ;
		foreach ($conversations as $conversation) {
			$message = Message::where('conversation_id','=',$conversation->id)->orderBy('updated_at','desc')->first() ;

			if($message)
			$messages[$conversation->id] = $message ;
		}

		return View::make('messages.index')->with('conversations',$conversations)->with('messages',$messages) ;
	}

	 
	public function showMessage($user_id)
	{
		
		$conversation = Conversation::where(function($query)  use($user_id)  {
			$query->where('user1_id' , '=' , Auth::id())->Where('user2_id' , '=' , $user_id);
		})->orWhere(function($query) use($user_id) {
			$query->where('user1_id' , '=' , $user_id)->Where('user2_id' , '=' , Auth::id());
		})->first();

		if(!$conversation){  //if there is no conversation
			$conversation = Conversation::create([
				'user1_id' =>  Auth::id(),
				'user2_id' => $user_id,
					]);
		}

		$messages = Message::where('conversation_id','=',$conversation->id)
		->orderBy('created_at' , 'desc')->simplepaginate();
		
		$otherUser = User::find($user_id) ;
		$Updownmessage = $messages->sortBy(function($messages){
				return $messages->created_at ;
		});

		return View::make('messages.show')
		->with('messages' , $messages)
		->with('Updownmessage' , $Updownmessage)
		->with('otherUser', $otherUser) 
		->with('conversation_id', $conversation->id) ;
	}



	 
	public function messagehandler()
	{
		$sender = Auth::id() ;
		$receiver = Input::get('otherUserId') ;
		$message = Input::get('user_message') ;
		$conversation_id = Input::get('conversation') ;

		$conversation = Conversation::find($conversation_id);

		if($conversation->count()){

			$permission = (
				( ($conversation->user1_id == $sender) && ($conversation->user2_id == $receiver) )
					||
				( ($conversation->user1_id == $receiver) && ($conversation->user2_id == $sender) ) 
				)? true : false ;

			if(!$permission)
				return Redirect::back()->with('flash_error' , 'Something Real Bad Happened<br>Please refresh the page') ;

			$success = Message::create([
				'user_id' => $sender,
				 'conversation_id' => $conversation->id ,
				'message' =>  $message,
				'seen' => 0 ,
				]) ;

			if($success){
				$conversation->update([]);
				return Redirect::back() ;
			}else{
				return Redirect::back()->with('flash_error' , 'Cant Send Message') ;
			}
		}else{
				return Redirect::back()->with('flash_error' , 'Something Bad Happened<br>Please refresh the page') ;
			}
	}

	 

	 public function messengerHandler(){

	 	$function = Input::get('function');

	 	$conversation = Conversation::find(Input::get('conversation')) ;
		$permission = false ;	           
		if( ($conversation->user1_id == Auth::id()) || ($conversation->user2_id == Auth::id())   ){
			$permission = true ; 
       }
    	

    	if($permission){
	   	    $log = array();
	   	  
				    switch($function) {
				    
				       case('getState'):
				       	  $message = Message::where('conversation_id','=',$conversation->id)
				       	  ->where('user_id','=',Input::get('otherUser'))
				       	  ->orderBy('id','desc')
				       	  ->first() ;
				          $log['last_message'] = $message->id; 
				          $log['seen'] = $message->seen ;
				          break ;


				       case('update'):
				          $last_message = Input::get('last_message');
				          
				          $message = Message::where('conversation_id','=',$conversation->id)
				       	  ->where('user_id','=',Input::get('otherUser'))
				       	  ->orderBy('id','desc')
				       	  ->first() ;
				       
				          $last_messageRecent = $message->id;

				          if($last_messageRecent == $last_message){
				             $log['last_message'] = $last_message;
				        	
				             $log['text'] = false;
				          } else {
				         //	echo $last_message.'and'.$last_messageRecent ;
				             $log['last_message'] = $last_messageRecent;
				             $log['user'] = User::find(Input::get('otherUser'))->name ;
				             $log['user_link'] = asset('user/'.Input::get('otherUser')) ;
				             $log['date'] = $message->created_at->diffForHumans() ;
				             $log['text'] = $message->message ; 
				          	 $message->update([
				          	 	'seen' => 1 ,
				          	 	]) ;


				          }
				            
				          break;
				       
				       case('send'):
				       	 $nickname = htmlentities(strip_tags($_POST['nickname']));
					     $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
					     $message = htmlentities(strip_tags($_POST['message']));
					     if (($message) != "\n") {
					       if (preg_match($reg_exUrl, $message, $url)) {
					          $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
					       } 
					          fwrite(fopen('chat.txt', 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 
					     }
				         break;
				    }
		    echo json_encode($log);
		}
	}
}