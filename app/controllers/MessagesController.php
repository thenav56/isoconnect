<?php

class MessagesController extends \BaseController {

 
	public function showMessagelist()
	{
		//show the list of user with recent message
		$messages = Message::orderBy('id' , 'desc')->distinct()->groupBy('user1_id')
		->where('user1_id' , '=' , Auth::id())
		->orWhere('user2_id' , '=' , Auth::id())->get() ;

		foreach($messages as $message){
			if($message->user1_id == Auth::id())
			echo 'YOU::'.User::find($message->user2_id)->name.' '.$message->message.'<br>' ;
			else
				echo User::find($message->user1_id)->name.'::YOU '.$message->message.'<br>' ;

			echo '<br><br><br><br>' ;
		}

		die() ;
	}

	 
	public function showMessage($user_id)
	{
		
		$messages = Message::orderBy('id','desc')->where(function($query)  use($user_id)  {
			$query->where('user1_id' , '=' , Auth::id())->Where('user2_id' , '=' , $user_id);
		})->orWhere(function($query) use($user_id) {
			$query->where('user1_id' , '=' , $user_id)->Where('user2_id' , '=' , Auth::id());
		})->simplepaginate();


		 

		$otherUser = User::find($user_id) ;

		return View::make('messages.show')->with('messages' , $messages)->with('otherUser', $otherUser) ;
	}



	 
	public function messagehandler()
	{
		$sender = Auth::id() ;
		$receiver = Input::get('otherUserId') ;
		$message = Input::get('user_message') ;

		$success = Message::create([
			'user1_id' => $sender,
			'user2_id' => $receiver,
			'message' =>  $message
			]) ;

		if($success){
			return Redirect::back() ;
		}else{
			return Redirect::back()->with('flash_error' , 'Cant Send Message') ;
		}
	}

	 
}