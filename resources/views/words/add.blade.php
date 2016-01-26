<html>
<head>
    <title>Add Category</title>
</head>
<body>
    {!! Form::open(['method' => 'post', 'route' => 'words.store']) !!}
        {!! Form::label('word_category', 'Word Category') !!}
        {!! Form::select('word_category', $categories) !!}
        <p>
            <p>{!! Form::text('word_japanese', null, ['placeholder' => 'Japanese Word']) !!}</p>
            <p>{!! Form::text('word_vietnamese', null, ['placeholder' => 'Vietnamese Word']) !!}</p>
            <p>{!! Form::file('sound_file') !!}</p>
        </p>
        {!! Form::submit('Save') !!}
    {!! Form::close() !!}

    {!! Form::open(['method' => 'get', 'route' => 'words.index']) !!}
        {!! Form::submit('Cancel') !!}
    {!! Form::close() !!}
</body>
</html>
