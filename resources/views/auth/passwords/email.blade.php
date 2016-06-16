@extends('layout')

@section('body')
    <div class="container">
        @if (\Session::has('loggedin'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('loggedin') !!}</li>
                </ul>
            </div>
        @elseif (\Session::has('status'))
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
        <ul class="nav nav-pills">
            <li>
                <a href="{!! url('home') !!}">Back</a>
            </li>
        </ul>

        <div class="content">
            <div style="font-size:60px;">Password Reset</div>
        </div>
        <form class="form-horiztonal" method="post" action="email">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-md-12">
                    <label for="email">Email</label>
                </div>
                <div class="col-md-6 col-md-offset-3" style="padding-bottom:15px;">
                    <input name="email" type="email" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button class="btn btn-primary fa fa-envelope" type="submit"> Send Reset Instructions</button>
                </div>
            </div>
        </form>
    </div>
@stop
