@extends('layouts.app')

@section('content')

    <div class="container">

        <h3>Create Post</h3>

        {!! Form::Open(['method' => 'post', 'route' => ['admin.posts.store']]) !!}

            <div class="form-group">
                {!! Form::label('Title', 'Title:') !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('Content', 'Content:') !!}
                {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
            </div>

        {!! Form::Close() !!}

    </div>

@endsection