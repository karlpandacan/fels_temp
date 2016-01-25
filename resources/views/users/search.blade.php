@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">User Search</div>
                <div class="panel-body">

                    @if(Session::has('message_success'))
                        <ul class="alert alert-success">
                            <li>{{ Session::get('message_success') }}</li>
                        </ul>
                    @endif
                    @if(Session::has('message_failed'))
                        <ul class="alert alert-danger">
                            <li>{{ Session::get('message_failed') }}</li>
                        </ul>
                    @endif
                    <div class="col-md-3"> 
                        <img src="../{{ Auth::user()->avatar }}" border="1px" height="250" width="100%">
                        <h4 align="center">{{ Auth::user()->name }}</h4>
                    </div>
                    <div class="col-md-9">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#following" aria-controls="profile" role="tab" data-toggle="tab">Not Following</a>
                            </li>
                            <li role="presentation">
                                <a href="#not_following" aria-controls="home" role="tab" data-toggle="tab">Follwing</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpane1" class="tab-pane fade in active" id="following" width="100%">
                                @if (count($usersNotFollowing) > 0)
                                    @foreach ($usersNotFollowing as $user)
                                        <div class="row" style="margin-top: 15px; margin-bottom: 15px">
                                            <div class="col-xs-2 text-right">
                                                <img src="../{{ $user->avatar }}" width="60" height="60" >
                                            </div>
                                            <div class="col-xs-3 text-left">
                                                <p>
                                                    <a href="/user/{{ $user->id }}">
                                                        {{ $user->name }}
                                                        {{ $user->email }}
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col-xs-2 text-left">
                                                {!! Form::open(['method' => 'post', 'route' => 'follows.store']) !!}
                                                    {!! Form::hidden('uid', $user->id), null !!}
                                                    {!! Form::submit('Follow', ['class' => 'btn btn-primary']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    @endforeach
                                @else 
                                    <h3>No Record Found</h3>
                                @endif
                            </div>
                            <div role="tabpane2" class="tab-pane fade" id="not_following">
                                @if (count($usersFollowing) > 0)
                                    @foreach ($usersFollowing as $user)
                                        <div class="row" style="margin-top: 15px; margin-bottom: 15px">
                                            <div class="col-xs-2 text-right">
                                                <img src="../{{ $user->avatar }}" width="60" height="60" >
                                            </div>
                                            <div class="col-xs-3 text-left">
                                                <p>
                                                    <a href="/user/{{ $user->id }}">
                                                        {{ $user->name }}
                                                        {{ $user->email }}
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col-xs-2 text-left">
                                                {!! Form::model($user, array('method' => 'DELETE', 'route' => array('follows.destroy', $user->id))) !!}
                                                    {!! Form::submit('Unfollow', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                               
                                            </div>
                                        </div>        
                                    @endforeach
                                @else 
                                    <h3>No Record Found</h3>
                                @endif 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection