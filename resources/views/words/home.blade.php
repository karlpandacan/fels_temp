<html>
<head>
    <title>Words</title>
</head>
<body>

     @foreach($words as $word)
        @if($user->isAdmin())
            @if(!empty($word->category->name))
                <p><b>category: {{ $word->category->name }}</b></p>
            @else
                <p><b>
                    category: <span style='color:red;'>NO CATEGORY</span>
                </b></p>
            @endif

            <p>{{ $word->word_japanese }} : {{ $word->word_vietnamese }}</p>
            <p>
                @if($user->isAdmin())
                    {!! Form::open(['method' => 'get', 'route' => ['words.edit', $word->id]]) !!}
                        {!! Form::submit('Edit (id: ' . $word->id . ')') !!}
                    {!! Form::close() !!}

                    {!! Form::open(['method' => 'delete', 'route' => ['words.destroy', $word->id]]) !!}
                        {!! Form::submit('Delete (id: ' . $word->id . ')') !!}
                    {!! Form::close() !!}
                @endif
            </p>
        @else
            @if(!empty($word->category->name))
                <p><b>category: {{ $word->category->name }}</b></p>
                <p>{{ $word->word_japanese }} : {{ $word->word_vietnamese }}</p>
            @endif
        @endif
    @endforeach

    {{ $words->render() }}

    @if($user->isAdmin())
        {!! Form::open(['method' => 'get', 'route' => 'words.create']) !!}
            {!! Form::submit('NEW WORD') !!}
        {!! Form::close() !!}
    @endif
</body>
</html>
