@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Words</div>
                    <div class="panel-body">
                        {!! Form::open(['method' => 'get', 'route' => ['words.search']]) !!}
                            {!! Form::select('category', $categories) !!}
                            {!! Form::label('learned', 'Learned') !!}
                            {!! Form::radio('status', 'learned', true) !!}
                            {!! Form::label('unlearned', 'Not Learned') !!}
                            {!! Form::radio('status', 'unlearned', true) !!}
                            {!! Form::label('all', 'All') !!}
                            {!! Form::radio('status', 'all', true) !!}
                        {!! Form::submit('Filter') !!}
                        {!! Form::close() !!}
                        @foreach($words as $word)
                            <div class="row">
                                <div class="col-xs-3">
                                    {{ $word->word_japanese }}
                                </div>
                                <div class="col-xs-1">
                                    :
                                </div>
                                <div class="col-xs-4">
                                    {{ $word->word_vietnamese }}
                                </div>
                                <div class="col-xs-2">
                                    @if($user->isAdmin())
                                        {!! Form::open(['method' => 'get', 'route' => ['words.edit', $word->id]]) !!}
                                        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                        {!! Form::open(['method' => 'delete', 'route' => ['words.destroy', $word->id]]) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        {{ $words->render() }}
                        @if($user->isAdmin())
                            {!! Form::open(['method' => 'get', 'route' => 'words.create']) !!}
                            {!! Form::submit('NEW WORD') !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
