<?php 
class AccountController extends BaseController{
	

	public function getSignIn(){
		return View::make('account.signin');


	}

	public function postSignIn(){

		$validator = Validator::make(Input::all(),
			array(
				'email'=>'required|email',
				'password'=>'required'
				)
			);
		if ($validator->fails()) {
			//Redirects to sign in page
			return Redirect::route('account-sign-in')
					->withErrors($validator)
					->withInput();
		} else {
			// attempt user sign in

			$remember = (Input::has('remember')) ? 'true' : 'false';

			$auth = Auth::attempt(array(
				'email'=> Input::get('email'),
				'password'=> Input::get('password'),
				'active'=> 1
				), $remember);
			if ($auth) {
				// redirect to intended page.
				return Redirect::intended('/');
			} else {
				return Redirect:: route('account-sign-in')
						->with('global', 'Email/Password ir wrong on account is not activated!');
			}
		}	
		
		return Redirect::route('account-sign-in')
		->with('global', 'There was a problem signing you in.');

	}
	public function getSignOut(){
		Auth::logout();
		return Redirect::route('home');

	}

	public function getCreate(){
		Return View::make('account.create');
	}

	public function postCreate(){
		//print_r(Input::all());
		$validator = Validator::make(Input::all(),
			array(
				'email'=>'required|max:50|unique:users',
				'username'=>'required|max:20|min:3|unique:users',
				'password'=>'required|min:6',
				'password_again'=>'required|same:password'

				)
			);
		if($validator->fails()){
			// you failed
			return Redirect::route('account-create')
			->withErrors($validator)
			->withInput();
			
		}else{
			//Create an account.
			$email = Input::get('email');
			$username = Input::get('username');
			$password = Input::get('password');

			// Activation code

			$code = str_random(60);

			$user = User::create(array(
				'email'=> $email,
				'username'=> $username,
				'password'=> Hash::make($password),
				'code'=> $code,
				'active' => 0
				));

			if($user){

				// Send email  
				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user) {
					$message->to($user->email, $user->username)->subject('Activate your account!');
				});

				// Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user) {
    //             	$message->to($user->email, $user->username)->subject('Activate your account'); });﻿

				// Mail::send('emails.auth.test', array('name' => 'Mindaugas'), function($message){
				// 	$message->to('mindaugas.azubalis@ktu.lt', 'Mindaugas Azubalis')->subject('Test Email'); });


				return Redirect::route('home')->with('global', 'Your account has been created, we\'ve sent you an email!');

			}
		}
	}

	public function getActivate($code) {
		$user = User::where('code', '=', $code)->where('active', '=', '0');
		// return $code;
		if ($user->count()) {

			$user = $user->first();

			// echo '<pre>', print_r($user), '</pre>';

			// Update user to active state
			$user->active = 1;
			$user->code = '';

			if ($user->save()) {
				return Redirect::route('home')
				->with('global', 'Activated, you now can sign in.');
			}

		}
		
		return Redirect::route('home')
				->with('global', 'We could not activated your user account!');
		
	}

	public function getChangePassword(){

		return View::make('account.password');
	}

	public function postChangePassword(){

		$validator = Validator::make(Input::all(), 
			array(
				'old_password'  =>'required',
				'password'      =>'required|min:6',
				'password_again'=>'required|same:password'
			)
		);
		if($validator->fails()){
			// redirect
			return Redirect::route('account-change-password')
					->withErrors($validator);
		} else {
			// change password
			$user = User::find(Auth::user()->id);

			$old_password = Input::get('old_password');
			$password = Input::get('password');

			if(Hash::check($old_password, $user->getAuthPassword())){
				// password is good matches...

				$user->password = Hash::make($password);

				if($user->save()){
					return Redirect::route('home')
							->with('global', 'Your password has been changed. ');
				}

			} 

		}

		return Redirect::route('account-change-password')
				->with('global', 'Your password could not be changed.');
	}

	public function getForgotPassword(){
		return View::make('account.forgot');
	}

	public function postForgotPassword(){
		$validator = Validator::make(Input::all(), 
			array(
				'email' => 'required|email'	
			));

		if($validator->fails()){
			return Redirect::route('account-forgot-password')
						->withErrors($validator)
						->withInput();
		} else {
			// change password

			$user = User::where('email', '=', Input::get('email'));

			if($user->count()) {
				$user 					= $user->first();
				// Generate new code and password_again
				$code     				= str_random(60);
				$password 				= str_random(10);

				$user->code 			= $code;
				$user->password_temp 	= Hash::make($password);

					if($user->save()) {
						Mail::send('emails.auth.forgot', array(
								'link' => URL::route('account-recover', $code),
								'username' => $user->username, 
								'password' => $password), 
								function($message) use ($user){
									$message->to($user->email, $user->username)->subject('Your new password');
								});

						return Redirect::route('home')
								->with('global', 'We have sent you a  new password to his email.');
					}
			}
		}

		return Redirect::route('account-forgot-password')
		->with('global', 'Could not request new password.');
	}

	public function getRecover($code) {
			$user = User::where('code', '=', $code)
				->where('password_temp', '!=', '' );

		if($user->count()){
		
			$user = $user->first();

			$user->password = $user->password_temp;
			$user->password_temp = '';
			$user->code = '';

			if($user->save()) {

				// Addtional  func tionality could be here :)

				return Redirect::route('home')
						->with('global', 'Your account has been recovered, you can now log in with your new password.');
			}

		}
		return Redirect::route('home')
				->with('global', 'Could not recover your account');
	}

}

 ?>