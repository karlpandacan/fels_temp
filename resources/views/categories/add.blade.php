<html>
<head>
    <title>Add Category</title>
</head>
<body>
    {!! Form::open(['method' => 'post', 'route' => 'categories.store', 'files' => 'true']) !!}
        {!! Form::text('category_name', null, ['placeholder' => 'Category Name']) !!}
        {!! Form::text('category_desc', null, ['placeholder' => 'Category Description']) !!}
        {!! Form::file('category_image') !!}
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}

    {!! Form::open(['method' => 'get', 'route' => 'categories.index']) !!}
        {!! Form::submit('Cancel') !!}
    {!! Form::close() !!}

</body>
</html>
