<html>
<head>
    <title>Add Category</title>
</head>
<body>
    {!! Form::open(['method' => 'patch', 'route' => ['categories.update', $category->id], 'files' => 'true']) !!}
        {!! Form::text('category_name', $category->name) !!}
        {!! Form::text('category_desc', $category->description) !!}

        @if(!empty($category->image))
            <p>
                {!! Html::image('images/categories/' . $category->image, $category->name, ['style' => 'max-height: 100px;']) !!}
            </p>
        @endif

        {!! Form::file('category_image') !!}
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}

    {!! Form::open(['method' => 'get', 'route' => 'categories.index']) !!}
        {!! Form::submit('Cancel') !!}
    {!! Form::close() !!}

</body>
</html>
