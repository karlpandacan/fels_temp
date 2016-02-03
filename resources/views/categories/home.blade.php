@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Categories</div>
                    <div class="panel-body">
                        @if(auth()->user()->isAdmin())
                            {!! Form::open(['method' => 'get', 'route' => 'categories.create']) !!}
                                {!! Form::submit('Add Category', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        @endif
                        <br>
                        @foreach($categories as $category)
                            <div class="row">
                                <div class="col-xs-2">
                                    @if(!empty($category->image))
                                        {!! Html::image('images/categories/' . $category->image, $category->name, ['style' => 'max-height: 100px; max-width:140px']) !!}
                                    @else
                                        {!! Html::image('images/cat_default.png', $category->name, ['style' => 'max-height: 100px; max-width:140px']) !!}
                                    @endif
                                </div>
                                <div class="col-xs-2">
                                    {{ $category->name }}
                                </div>
                                <div class="col-xs-4">
                                    {{ $category->description }}
                                </div>
                                <div class="col-xs-4">
                                    @if(auth()->user()->isAdmin())
                                        {!! Form::open(['method' => 'get', 'route' => ['categories.edit', $category->id]]) !!}
                                            {!! Form::submit('Edit', ['class' => 'btn btn-info']) !!}
                                        {!! Form::close() !!}
                                        <br>
                                        {!! Form::open(['method' => 'delete', 'route' => ['categories.destroy', $category->id]]) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </div>
                            </div>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
