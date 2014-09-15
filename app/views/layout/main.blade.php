<!DOCTYPE html>
<html>
<head>
	<title>Authentication System</title>
	<link href=" {{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
</head>
	<body>

		@if(Session::has('global'))
		<p>{{ Session::get('global')}}</p>
		@endif



		@include('layout.navigation')
		@yield('content')

		<article>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</article>

	</body>
</html>