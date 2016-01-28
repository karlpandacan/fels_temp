@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Word</div>
                    <div class="panel-body">
                        <div class="col-md-10">
                            {!! Form::open(['method' => 'patch', 'route' => ['words.update', $word->id], 'files' => 'true']) !!}
                                <div class="form-group">
                                    {!! Form::label('word_category', 'Word Category') !!}
                                    {!! Form::select('word_category', $categories, $word->category['id'], ['class' => 'form-control']) !!}
                                    {!! Form::hidden('word_id', $word->id) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('word_japanese', 'Word Japanese') !!}
                                    {!! Form::text('word_japanese', $word->word_japanese, ['class' => 'form-control', 'placeholder' => 'Japanese Word']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('word_vietnamese', 'Word Japanese') !!}
                                    {!! Form::text('word_vietnamese', $word->word_vietnamese, ['class' => 'form-control', 'placeholder' => 'Vietnamese Word']) !!}
                                </div>
                                <div class="form-group">
                                    @if(!empty($word->sound_file))
                                        {!! Form::label('audio', 'Word Japanese') !!}
                                        <audio controls>
                                            <source src="{{ asset('audio/' . $word->sound_file) }}">
                                        </audio>
                                    @endif
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
