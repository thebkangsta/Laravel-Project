@extends('layout')

@section('body')
    <div class="container">
        @if (\Session::has('loggedin'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('loggedin') !!}</li>
                </ul>
            </div>
        @endif
            @if (\Session::has('status'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('status') !!}</li>
                    </ul>
                </div>
            @endif
            @if (!empty($errors))
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            @endif
            <div class="content">
                <div style="font-size:60px;">Password Reset</div>
            </div>
            <form class="form-horiztonal" method="post" action="/project/server.php/reset">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-6 col-md-offset-3" style="padding-bottom:15px;">
                        <input name="email" type="email" class="form-control form-control-static" value="{{ $email }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label for="password">New Password</label>
                    </div>
                    <div class="col-md-6 col-md-offset-3" style="padding-bottom:15px;">
                        <input name="password" type="password" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3" style="padding-bottom:15px;">
                        <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button class="btn btn-primary" type="submit">Reset</button>
                    </div>
                </div>
            </form>
    </div>
@stop