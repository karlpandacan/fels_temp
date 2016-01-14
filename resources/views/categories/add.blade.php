<html>
<head>
    <title>Add Category</title>
</head>
<body>
    {!! Form::open(['method' => 'post', 'route' => 'categories.store']) !!}
        {!! Form::text('categoryName') !!}
        {!! Form::text('categoryDesc') !!}
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
</body>
</html>
