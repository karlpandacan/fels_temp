<html>
<head>
    <title>Add Word</title>
</head>
<body>
    {!! Form::open(['method' => 'patch', 'route' => ['words.update', $word->id]]) !!}
        {!! Form::label('word_category', 'Word Category') !!}
        {!! Form::select('word_category', $categories, $word->category['id']) !!}
        <p>
            <p>{!! Form::text('word_japanese', $word->word_japanese, ['placeholder' => 'Japanese Word']) !!}</p>
            <p>{!! Form::text('word_vietnamese', $word->word_vietnamese, ['placeholder' => 'Vietnamese Word']) !!}</p>
        </p>

        {!! Form::submit('Save') !!}
    {!! Form::close() !!}

    {!! Form::open(['method' => 'get', 'route' => 'words.index']) !!}
        {!! Form::submit('Cancel') !!}
    {!! Form::close() !!}

</body>
</html>
