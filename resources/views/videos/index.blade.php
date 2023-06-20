@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Videos</h2>
            </div>
            <div class="pull-right">
                @can('video-create')
                <a class="btn btn-success" href="{{ route('videos.create') }}"> Create New Video</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>videos
        @foreach ($videos as $video)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $video->name }}</td>
            <td>{{ $video->detail }}</td>
            <td>
                <form action="{{ route('videos.destroy',$video->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('videos.show',$video->id) }}">Show</a>
                    @can('video-edit')
                    <a class="btn btn-primary" href="{{ route('videos.edit',$video->id) }}">Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('video-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $videos->links() !!}
    <p class="text-center text-primary"><small>Powered by CV</small></p>
@endsection