@extends('layout')

@section('head')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css" />

    <link href="../../assets/main.css" rel="stylesheet" type="text/css" />
    <!-- JS -->
    <script type="text/javascript" src="../../assets/plugins/js/jquery-2.1.4.min.js"></script>
    <script src="../../assets/plugins/js/moment.js" type="text/javascript"></script>
    <script src="../../assets/plugins/react/react.js"></script>
    <script src="../../assets/plugins/react/react-dom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>

@stop

@section('dashboard')
    <!-- NAVIGATION -->
    <div class="topNav">
        <img src="../../assets/images/BannerWhite.png" style="width:200px;"/>
        <ul class="navButtons">
            <li><a>Home <span class="fa fa-home"></span></a></li>
            <li class="active"><a>Communities <span class="fa fa-users"></span></a></li>
            <li><a href="analytics">Analytics <span class="fa fa-line-chart"></span></a></li>
            <li><a>Earnings <span class="fa fa-dollar"></span></a></li>
            <li class="last"><a href="{!! url('logout') !!}">Logout <span class="fa fa-sign-out"></span></a></li>
        </ul>
    </div>
    <!-- END OF NAV -->
    <div class="dashboard">
        <!-- MAIN CHART DATA -->
        <div class="mainContent">
            @if (\Session::has('message-good'))
                <div class="alert alert-success">{!! \Session::get('message-good') !!}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif
            <div class="alert alert-danger" id="message-bad" style="display:none;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @if (!empty($errors))
                @foreach($errors->all() as $error)
                    <script>
                        $('#message-bad')
                                .show()
                                .html("<strong>Whoops!</strong> {{ $error }}");
                        window.scrollTo(0, 0);
                    </script>
                @endforeach
            @endif
            <div class="row">
                <div class="wrapper">
                </div>
            </div> <!-- END OF FIRST ROW -->
            <div class="row">
                <div class="wrapper">
                    <section class="submitCommentContainer">
                        <div class="charttop">Write a Comment
                        </div>
                        <div class="submitComment">
                            <form class="form-group" method="post" action="communities">
                                <textarea class="form-control" style="max-width:100%;margin-bottom:20px;height:200px;" id="inputdefault" name="comment_text" maxlength="1000" ></textarea>
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            </form>
                        </div>
                    </section>
                    <section class="viewCommentContainer">
                        <div class="charttop">All Comments
                        </div>
                        <div class="viewComment" id="viewComment">
                            @foreach($comments as $comment)
                                <p style="font-size:15px;"><strong>{{ $comment['name'] }}</strong>
                                {{ $comment['comment_text'] }}</p>
                                <p style="font-size:10px;">Posted on {{ $comment['created_at'] }}</p><br/>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div> <!-- END OF SECOND ROW -->
    </div>
    {{--<script type="text/babel" src="../../assets/js/communities.js"></script>--}}
@stop