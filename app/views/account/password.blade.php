@extends('layout.main')

@section('content')

	 <form action="{{ URL::route('account-change-password-post')}}" method="post">
	 	
	 	<div class="field">
	 		Old password: <input class="password" name="old_password"></input>
	 		@if($errors->has('old_password'))
	 			{{ $errors->first('old_password') }}
	 		@endif
	 	</div>
	 	<div class="field">
	 		New password: <input class="password" name="password"></input>
	 		@if($errors->has('password'))
	 			{{ $errors->first('password') }}
	 		@endif
	 	</div>
	 	<div class="field">
	 		New password again: <input class="password" name="password_again"></input>
	 		@if($errors->has('password_again'))
	 			{{ $errors->first('password_again') }}
	 		@endif
	 	</div>

	 	<input type="submit" value="Change password">
	 	{{Form::token()}}
	 </form>

@stop