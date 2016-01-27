@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Lesson for {{ $user->name }}</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="col-md-6">
                                <b><h1>{{ $questions[\Session::get('questionIndex')]->word->word_japanese }}</h1><b>
                                <p>
                                    <audio controls>
                                        <source src="">
                                    </audio>
                                </p>
                            </div>
                            <div class="col-md-6">
                                @foreach($options as $option)
                                    {!! Form::open(['method' => 'post', 'route' => 'exams']) !!}
                                        {!! Form::hidden('word_answer_id', $option['id']) !!}
                                        {!! Form::hidden('lesson_word_id',
                                            $questions[\Session::get('questionIndex')]->id) !!}
                                        {!! Form::submit($option['word_vietnamese'], [
                                                'class' => 'btn btn-default btn-block'
                                            ]) !!}
                                    {!! Form::close() !!}
                                @endforeach
                                </br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
