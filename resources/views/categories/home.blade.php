<html>
<head>
    <title>Categories</title>
</head>
<body>
    @foreach($categories as $category)
        <p><u>{{ $category->name }}</u></p>
        <p>{{ $category->description }}</p>
        @if(!empty($category->image))
            <p>
                {!! HTML::image('images/categories/' . $category->image, $category->name, ['style' => 'max-height: 100px;']) !!}
            </p>
        @endif

        @if($user->isAdmin())
            <p>
                {!! Form::open(['method' => 'get', 'route' => ['categories.edit', $category->id]]) !!}
                    {!! Form::submit('Edit (id: ' . $category->id . ')') !!}
                {!! Form::close() !!}
            </p>
            <p>
                {!! Form::open(['method' => 'delete', 'route' => ['categories.destroy', $category->id]]) !!}
                    {!! Form::submit('Delete (id: ' . $category->id . ')') !!}
                {!! Form::close() !!}
            </p>
        @endif
    @endforeach

    @if($user->isAdmin())
        {!! Form::open(['method' => 'get', 'route' => 'categories.create']) !!}
            {!! Form::submit('NEW CATEGORY') !!}
        {!! Form::close() !!}
    @endif
</body>
</html>
