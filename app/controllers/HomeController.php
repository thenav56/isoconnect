<?phpclass HomeController extends BaseController {	/*	|--------------------------------------------------------------------------	| Default Home Controller	|--------------------------------------------------------------------------	|	| You may wish to use controllers instead of, or in addition to, Closure	| based routes. That's great! Here is an example controller method to	| get you started. To route to this controller, just add the route:	|	|	Route::get('/', 'HomeController@showWelcome');	|	*/	// public function showWelcome()	// {	// 	return View::make('hello');	// }	//Register	public function showRegister(){		//show the form		return View::make('register');	}	public function doRegister(){		//custom message		$messages = array(   		 'g-recaptcha-response.required' => 'We need to know if you are a human!',   		 'name.required' => 'You Must Have A Name' ,   		 'email.required' => 'We need your email' , 		);		//validate the info , create rules for the inputs		$rules = array(			'email' => 'required|email|Unique:users' , //make sure the email is present and is email			'password' => 'required|alphaNum|min:3|Confirmed', //password can only be alphanumeric and has to be greater than 3 characters			'password_confirmation' => 'required' ,			'name' => 'required|alpha_spaces|min:4|max:32',			'g-recaptcha-response' => 'required|recaptcha'		);		// run the validation rules on the inputs from the form		$validator = Validator::make(Input::all() ,$rules , $messages) ;		//if the validator fails, redirect back to the form		if($validator->fails()) {			return Redirect::to('register')				->withErrors($validator) //send back all errors to the				->withInput(Input::except('password'));		}else{			$confirmation_code = str_random(30);			$data = Input::only(['email','name','password']);			$data['password'] = Hash::make($data['password']) ;			$data['confirmation_code'] = $confirmation_code ; 			$newUser = User::create($data);			Mail::queue('emails.verify', array('confirmation_code' =>$confirmation_code), function($message) {            $message->to(Input::get('email'), Input::get('username'))                ->subject('Verify your email address');			});			if($newUser){				//Auth::login($newUser);				return Redirect::to('login')->with('flash_notice' , 'Thanks For Singing Up! <br> Please Check Your Email Adderss For Verification')				->withInput(Input::only('email'));;			}			return Redirect::to('register')->withInput();		}	}	//Login	public function showLogin(){			//show the form			return View::make('login');		}	public function doLogin(){	 	//validate the info , create rules for the inputs		$rules = array(			'email' => 'required|email|exists:users,email' , //make sure the email is present and is email			'password' => 'required|alphaNum|min:3' //password can only be alphanumeric and has to be greater than 3 characters		);		// run the validation rules on the inputs from the form		$validator = Validator::make(Input::all() ,$rules) ;		//if the validator fails, redirect back to the form		if($validator->fails()) {			return Redirect::to('login')				->withErrors($validator); //send back all errors to the		}else{			//create our user data for the authentication			$userdata = array(				'email' => Input::get('email'),				'password' => Input::get('password')			);			$remember = (Input::get('remember') == 'on')? true : false ; //for remember me			//attempt to do the login			if(Auth::attempt($userdata, $remember)){				if(Auth::user()->confirmed == 0){					Auth::logout() ;					return Redirect::to('login')->with('flash_error' , 'Email Verification is required<br>Please check your email');				}								//validation successful!				//redirect them the secure section or whatever				//return Rediret::to('secure');				//for now we'll jush echo success(even though echoing in a controller is bad				return Redirect::to('home')->with('flash_notice' , 'You have successfully logged in!');			}else{				//validation not successful, send back to form				return Redirect::to('login')->withErrors(['password' => ['Wrong Password::Try Again']])				->withInput(Input::except('password'));			}		}	}	public function doLogout(){		Auth::logout() ; //log the user out of our application		return Redirect::to('login')->with('flash_notice' , 'You have successfully logged out!') ; //redirect the user to the login page	}	public function showPost( )	{		//for groups		$groups = User::find(Auth::id())->groups() ; //Note::use get() in the function directly				$x = 2 ;		$gpid[1] = 0 ;				if($groups){						$groups = $groups->get() ;					foreach ($groups as $key => $value) {				$gpid[$x] = $value->id ;					$x++ ;			}		}		//for post according to the groups		$posts = Post::whereIn('group_id' , $gpid)->orderBy('id','desc')->simplePaginate(10);		 		return View::make('home')->with('posts' , $posts)->with('groups' , $groups) ;	}	public function confirm($confirmation_code){		if( ! $confirmation_code)        {            throw new InvalidConfirmationCodeException;        }        $user = User::whereConfirmationCode($confirmation_code)->first();        if ( ! $user)        {            throw new InvalidConfirmationCodeException;        }        $user->confirmed = 1;        $user->confirmation_code = null;        $user->save();        return Redirect::to('login')->with('flash_notice','You have successfully verified your account.<br>Please Log In');	}		}