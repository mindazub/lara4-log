<?php

class HomeController extends BaseController {

	
	public function home(){

		
		// Mail::send('emails.auth.test', array('name' => 'Mindaugas'), function($message){
		// 	$message->to('mindaugas.azubalis@ktu.lt', 'Mindaugas Azubalis')->subject('Test Email');
		// });

		// echo $user = User::find(1)->username;
		// echo '<pre>', print_r($user), '</pre>';

		return View::make('home');
	}

}
