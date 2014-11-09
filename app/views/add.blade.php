@extends('_master')

@section('title')
Add a new book
@stop

@section('content')
<h1>Add a new book</h1>
	{{ Form::open(array('url' => '/add')) }}
		<p>{{ Form::text('title') }} title </p>
		<p>{{ form::text('author') }} author </p>
		{{ Form::submit() }}
	{{ Form::close() }}
@stop
