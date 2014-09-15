<nav class="navigate">

<ul>
	<li><a href="{{URL::route('home')}}">Home</a></li>

	@if(Auth::check())
		<li><a href="{{ URL::route('account-sign-out')}}">Sign out</a></li>
		<li><a href="{{ URL::route('account-change-password')}}">Change password</a></li>
		


	@else
		<li><a href="{{ URL::route('account-sign-in' )}}">Sign In</a></li>
		<li><a href="{{ URL::route('account-create' )}}">Create and account</a></li>
		<li><a href="{{ URL::route('account-forgot-password')}}">Forgot Password</a></li>
	@endif
</ul>

</nav>