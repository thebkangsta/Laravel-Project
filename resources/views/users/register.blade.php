@extends('layout')

@section('body')
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<ul class="nav nav-pills">
		<li>
			<a href="home">Back</a>
		</li>
	</ul>
<div class="title">
	<h1>Create Your Account</h1>
</div>

	<form class="form-horiztonal" method="post" action="register">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-group">
			<div class="col-md-12">
				<label for="name">Full Name</label>
			</div>
			<div class="col-md-6 col-md-offset-3" style="padding-bottom:15px;">
				<input name="name" type="text" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<label for="email">Email</label>
			</div>
			<div class="col-md-6 col-md-offset-3" style="padding-bottom:15px;">
				<input name="email" type="email" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<label for="password">Password</label>
			</div>
			<div class="col-md-6 col-md-offset-3" style="padding-bottom:15px;">
				<input name="password" type="password" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3" style="padding-bottom:15px;">
				<input name="confirmpassword" type="password" class="form-control" placeholder="Confirm Password"/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<button class="btn btn-primary" type="submit">Register</button>
			</div>
		</div>
	</form>

@stop
