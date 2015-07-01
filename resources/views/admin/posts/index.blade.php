@extends('app')

@section('page-title')
    News
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    @yield('page-title')
                    <span id="page-actions">
                        <a href="{{ route('admin.home') }}" class="btn btn-primary">
                            Dashboard
                        </a>
                    </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.post.edit', [$post->id]) }}" class="btn btn-primary btn-xs">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="danger">
                            <td colspan="5">No post available</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="5" class="info text-center">
                            <a href="{{ route('admin.post.create') }}">Add a post</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection