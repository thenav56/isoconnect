<?php

class MessagesController extends \BaseController {

 
	public function showMessagelist()
	{
		//show the list of user with recent message
		// $messages = Message::orderBy('id' , 'desc')->distinct()->groupBy()
		// ->where('user1_id' , '=' , Auth::id())
		// ->orWhere('user2_id' , '=' , Auth::id())->simplepaginate() ;

		// $messages = Message::select(DB::raw('DISTINCT  if(user1_id = ? , user2_id,user1_id )',array(Auth::id())))
		// ->whereRaw('user1_id = ? or user2_id = ? ',array( Auth::id(),Auth::id(),Auth::id()))->get();		

		// foreach ($messages as $message) {
		//  	$userList[] =  $message['if(user1_id = ? , user2_id,user1_id )'] ;
		//  } 

		//  foreach ($userList as $user) {
		//  	$messages[$user] = Message::orderBy('id','desc')->where(function($query)  use($user)  {
		// 			$query->where('user1_id' , '=' , Auth::id())->Where('user2_id' , '=' , $user);
		// 				})->orWhere(function($query) use($user) {
		// 					$query->where('user1_id' , '=' , $user)->Where('user2_id' , '=' , Auth::id());
		// 				})->first() ;
		//  }
		//  foreach ($userList as $user_id) {
		//  	echo User::find($user_id)->name.'<br>'.$messages[$user_id]->message.' '.$messages[$user_id]->created_at->diffForHumans().'<br><br>' ;
		//  }
		//  die();

		// //inbox
		// Paginator::setPageName('inbox') ;
		// $inboxMessages = Message::orderBy('created_at' , 'desc')->distinct()->groupBy('user1_id')
		// ->where('user2_id' , '=' , Auth::id())->simplepaginate(5) ;

		// //sent
		// Paginator::setPageName('sent') ;
		// $sentMessages = Message::orderBy('created_at' , 'desc')
		// ->where('user1_id' , '=' , Auth::id())->simplepaginate(5) ;

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

		return View::make('messages.show')
		->with('messages' , $messages)
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
				'message' =>  $message
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

	 
}