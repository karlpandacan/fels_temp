@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Categories</div>
                    <div class="panel-body">
                        <div class="col-md-10">
                            {!! Form::open(['method' => 'post', 'route' => 'categories.store', 'files' => 'true']) !!}
                                <div class="form-group">
                                    {!! Form::label('category_name', 'Name') !!}
                                    {!! Form::text('category_name', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('category_desc', 'Description') !!}
                                    {!! Form::textarea('category_desc', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('category_image', 'Image') !!}
                                    {!! Form::file('category_image') !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::open(['method' => 'get', 'route' => 'categories.index']) !!}
                                    {!! Form::submit('Cancel', ['class' => 'btn btn-danger']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection