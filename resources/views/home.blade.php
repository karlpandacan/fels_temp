@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Home</div>

                <div class="panel-body">
                    <div class="col-md-3">
                        <img src="{{ Auth::user()->avatar }}" border="1px" height="250" width="100%">
                        <h4 align="center">{{ Auth::user()->name }}</h4>
                        <h5 align="center">Learned {{ $words }} Words</h5>
                    </div>
                    <div class="col-md-9">
                        <a href="/words" class="btn btn-default btn-lg" role="button">Word</a> 
                        <a href="/categories" class="btn btn-default btn-lg" role="button">Lesson</a>
                        <h2>Activities</h2>
                        <hr>
                        @if (count($activities) > 0)
                            @foreach ($activities as $activity)
                                <div class="row" style="margin-top: 15px; margin-bottom: 15px">
                                    <div class="col-xs-2 text-right">
                                        <img src="{{ $activity->user->avatar }}" width="60" height="60" >
                                    </div>
                                    <div class="col-xs-10 text-left ">
                                        {{ $activity->user->name }} <br>
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
