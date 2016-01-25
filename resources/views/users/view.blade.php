@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <div class="col-md-3">
                            <img src="../{{ $user->avatar }}" border="1px" height="250" width="100%">
                            <h4 align="center">{{ $user->name }}</h4>
                            <h5 align="center">Learned {{ $learnedWords }} Words</h5>
                            @if(\Auth::user()->isAdmin())
                                <p>
                                    {!! Form::open(['method' => 'get', 'route' => ['user.edit', $user->id]]) !!}
                                    {!! Form::submit('Edit User', ['class' => 'btn btn-info']) !!}
                                    {!! Form::close() !!}
                                </p>
                                <p>
                                    {!! Form::open(['method' => 'delete', 'route' => ['user.destroy', $user->id]]) !!}
                                    {!! Form::submit('Delete User', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                </p>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h2>Activities</h2>
                            @if ($follow == 'self')
                            @elseif($follow == 'following')
                                {!! Form::model($user, array('method' => 'DELETE', 'route' => array('follows.destroy', $user->id))) !!}
                                {!! Form::submit('Unfollow', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            @else
                                {!! Form::open(['method' => 'post', 'route' => 'follows.store']) !!}
                                {!! Form::hidden('uid', $user->id), null !!}
                                {!! Form::submit('Follow', ['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
                            @endif
                            <hr>
                            @if (count($activities) > 0)
                                @foreach ($activities as $activity)
                                    <div class="row" style="margin-top: 15px; margin-bottom: 15px">
                                        <div class="col-xs-10 text-left ">
                                            {{ $activity->content }} - {{ $activity->created_at->format('Y/m/d') }}
                                        </div>
                                    </div>
                                @endforeach
                                {!! $activities->render() !!}
                            @else
                                <h3>No Record Found</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection