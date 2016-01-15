<html>
<head>
    <title>Add Category</title>
</head>
<body>
    {!! Form::open(['method' => 'patch', 'route' => ['categories.update', $category->id]]) !!}
        {!! Form::text('categoryName', $category->name) !!}
        {!! Form::text('categoryDesc', $category->description) !!}
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}
</body>
</html>
