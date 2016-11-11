@extends('layouts.app')

@section('content')

    <?php
    $textState = $post->state == $post::STATE_PUBLISHED ? 'Draft' : 'Publish';
    $textStated = $post->state != $post::STATE_PUBLISHED ? 'Draft text' : 'Published text';
    $classState = $post->state == $post::STATE_PUBLISHED ? 'warning' : 'success';
    $classStated = $post->state != $post::STATE_PUBLISHED ? 'warning' : 'success';
    $state = $post->state == $post::STATE_PUBLISHED ? $post::STATE_DRAFT : $post::STATE_PUBLISHED;
    ?>

    <div class="container">

        <h3>Edit Post <small class="label label-{{ $classStated }}">{{ $textStated }}</small></h3>

        {!! Form::Open(['method' => 'post', 'route' => ['admin.posts.store']]) !!}

            <div class="form-group">
                {!! Form::label('Title', 'Title:') !!}
                {!! Form::text('title', $post->title, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('Content', 'Content:') !!}
                {{-- Form::textarea('content', $post->content, ['class' => 'form-control']) --}}
                <textarea name="content" class="tinymce">{{ old('content') ? old('content') : $post->content}}</textarea>
                @include('tinymce::tpl')
            </div>

            <div class="form-group">
                {!! Form::submit('Submit', ['class'=>'btn btn-lg btn-primary']) !!}
            </div>

        {!! Form::Close() !!}

        @can('posts_publish')
        {!! Form::Open(['method' => 'patch', 'route' => ['admin.posts.update_state', $post->id]]) !!}


            <div class="form-group">
                {!! Form::hidden('state', $state) !!}
                {!! Form::submit($textState, ['class'=>"btn btn-lg btn-$classState"]) !!}
            </div>

        {!! Form::Close() !!}
        @endcan


    </div>

@endsection