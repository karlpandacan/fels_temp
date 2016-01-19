@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="col-md-3"> 
                        <img src="{{ Auth::user()->avatar }}" border="1px" height="250" width="100%">
                    </div>
                    <div class="col-md-9">
                        <h2>{{ $user->name }} </h2>
                        <p>
                            {{ $user->email }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection