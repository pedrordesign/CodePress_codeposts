@extends('layouts.app')

@section('content')

    <div class="container">

        <h3>Posts</h3>

        <a href="{{ route('admin.posts.create') }}">Create Post</a>
        <br><br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->content }}</td>
                        <td>{{ $category->action}}</td>
                        <td>
                            <a href="{{route('admin.posts.edit', ['id' => $post->id])}}">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

@endsection