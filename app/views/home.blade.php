@extends('layout.main')

@section('content')
	@if(Auth::check())
		<p>Hello, {{ Auth::user()->username }} . </p>
	@else
		<p>Youre not signed in.</p>
		@endif
@stop