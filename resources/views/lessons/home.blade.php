@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Lessons</div>

                <div class="panel-body">
                @foreach($categories as $category)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">{{ ucwords($category->name) }}</div>
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        {!! Html::image('images/categories/' . $category->image,
                                            $category->name,
                                            [
                                                'style' => 'max-width: 350px; max-height: 300px;',
                                                'onerror' => 'this.src = "images/default-image.png"'
                                            ]);
                                        !!}
                                    </div>
                                    <div class="col-md-8">
                                        {!! Form::open(['method' => 'post', 'route' => 'lessons.store']) !!}
                                            {!! Form::hidden('category_id', $category->id) !!}
                                            {!! Form::submit('Start Lesson', ['class' => 'btn btn-success']) !!}
                                        {!! Form::close() !!}
                                        {{ $category->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
