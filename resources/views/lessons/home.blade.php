<html>
<head>
    <title>Categories</title>
</head>
<body>
    @foreach($lessons as $lesson)
    <pre>
        {{ print($lesson) }}
    </pre>
    @endforeach

    {!! Form::open(['method' => 'post', 'route' => 'lessons.store']) !!}
        {!! Form::submit('New Lesson') !!}
    {!! Form::close() !!}
</body>
</html>
