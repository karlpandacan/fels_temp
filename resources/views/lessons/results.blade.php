@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Results for {{ $user->name }} taken on <b>{{ date_format($results[0]->created_at, 'M d, y h:i') }}</b>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row col-md-12 text-center">
                                <h1>
                                    <b>{{ ucwords($results[0]->word->category->name) }}</b> -
                                    {{ $count->correct }} / {{ $count->total }}
                                </h1>
                            </div>

                            @foreach($results as $result)
                            <div class="row col-md-2">
                                @if($result->word->id == $result->word_answered_id)
                                    <span class="glyphicon glyphicon-ok"></span>
                                @else
                                    <span class="glyphicon glyphicon-remove"></span>
                                @endif
                            </div>
                            <div class="row col-md-3">
                                    {{ $result->word->word_japanese }}
                            </div>
                            <div class="row col-md-3">
                                {{ $result->wordAnswered->word_vietnamese }}
                            </div>
                            <div class="row col-md-4">
                                <audio controls>
                                    <source src="{{ asset('audio/thats-it.wav') }}">
                                </audio>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
