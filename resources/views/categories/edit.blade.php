@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Category</div>
                    <div class="panel-body">
                        <div class="col-md-10">
                            @if(!empty($category->image))
                                <p>
                                    {!! Html::image('images/categories/' . $category->image, $category->name, ['style' => 'max-height: 100px;']) !!}
                                </p>
                            @endif
                            {!! Form::open(['method' => 'patch', 'route' => ['categories.update', $category->id], 'files' => 'true']) !!}
                                <div class="form-group">
                                    {!! Form::label('category_name', 'Name') !!}
                                    {!! Form::text('category_name', $category->name, ['class' => 'form-control']) !!}
                                    {!! Form::hidden('category_id', $category->id) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('category_desc', 'Description') !!}
                                    {!! Form::textarea('category_desc', $category->description, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('category_image', 'Image') !!}
                                    {!! Form::file('category_image') !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                </div>
                            {!! Form::close() !!}
                            {!! Form::open(['method' => 'get', 'route' => 'categories.index']) !!}
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
