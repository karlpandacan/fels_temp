@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Word</div>
                    <div class="panel-body">
                        <div class="col-md-10">
                            {!! Form::open(['method' => 'post', 'route' => 'words.store']) !!}
                                <div class="form-group">
                                    {!! Form::label('word_category', 'Word Category') !!}
                                    {!! Form::select('word_category', $categories, null,['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('word_japanese', 'Word Japanese') !!}
                                    {!! Form::text('word_japanese', null, ['class' => 'form-control', 'placeholder' => 'Japanese Word']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('word_vietnamese', 'Word Japanese') !!}
                                    {!! Form::text('word_vietnamese', null, ['class' => 'form-control', 'placeholder' => 'Vietnamese Word']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::file('sound_file') !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                </div>
                            {!! Form::close() !!}
                            {!! Form::open(['method' => 'get', 'route' => 'words.index']) !!}
                                <div class="form-group">
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
