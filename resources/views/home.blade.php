@extends('layout')
    @section('head')
		<link href="/css/master.css" rel="stylesheet" type="text/css">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            label {
                font-size: 20px;
            }

            .title {
                font-size: 96px;
            }
        </style>
    @stop
    @section('body')
        @if (\Session::has('badcredentials'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('badcredentials') !!}</li>
                </ul>
            </div>
        @elseif (\Session::has('registered'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('registered') !!}</li>
                </ul>
            </div>
        @elseif (\Session::has('emailreset'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('emailreset') !!}</li>
                </ul>
            </div>
        @elseif (\Session::has('status'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('status') !!}</li>
                </ul>
            </div>
        @endif
            <ul class="nav nav-pills">
                <li>
                    <a href="{!! url('register')!!}">Register</a>
                </li>
            </ul>
            <div class="content">
                <div class="title">Login</div>
            </div>
			<form class="form-horiztonal" method="post" action="home" style="height:220px;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
					<div class="col-md-6 col-md-offset-3">
						<button class="btn btn-primary" type="submit">Login</button>
					</div>
				</div>
			</form>

        <a href="reset" style="text-decoration: none;display:block;">Forgot Password?</a>

	@stop
