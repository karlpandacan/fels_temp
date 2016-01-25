@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit User</div>
                    <div class="panel-body">
                        <div class="col-md-10">
                            @if(Session::has('flash_success'))
                                <ul class="alert alert-success">
                                        <li>{{ Session::get('flash_success') }}</li>
                                </ul>
                            @endif
                            @if($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            {!! Form::open(['method' => 'patch', 'route' => ['user.update', $user->id], 'files' => 'true']) !!}
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::file('image') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Update User', ['class' => 'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="panel-heading">Change Password</div>
                    <div class="panel-body">
                        <div class="col-md-10">
                            {!! Form::open(['method' => 'patch', 'route' => ['user.update_password', $user->id]]) !!}
                            <div class="form-group">
                                {!! Form::label('password', 'Password') !!}
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('password_confirmation', 'Confirm Password') !!}
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Update Password', ['class' => 'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
