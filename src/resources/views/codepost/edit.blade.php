@extends('layouts.app')

@section('content')

    <div class="container">

        <h3>Edit Post</h3>

        {!! Form::Open(['method' => 'post', 'route' => ['admin.posts.store']]) !!}

            <div class="form-group">
                {!! Form::label('Title', 'Title:') !!}
                {!! Form::text('title', $post->title, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('Content', 'Content:') !!}
                {!! Form::textarea('content', $post->content, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
            </div>

        {!! Form::Close() !!}

    </div>

@endsection