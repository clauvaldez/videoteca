@extends('layouts.app')
@section('content')
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $video->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Details:</strong>
                {{ $video->detail }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Format:</strong>
                {{ $video->format }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Size:</strong>
                {{ round($video->size/1048576, 2) .' MB' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Upload By:</strong>
                {{ $usuario->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>File Path:</strong>
                {{ $video->file_path }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Video:</strong>
                <video controls>
    <source src="{{ asset($video->file_path) }}" type="video/{{ $video->format }}">
    Tu navegador no admite la reproducción de video.
</video>

            </div>
        </div>
    </div>
    <p class="text-center text-primary"><small>Powered by CV</small></p>
@endsection
