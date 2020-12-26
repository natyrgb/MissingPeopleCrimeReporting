@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">Edit News</h3>
            <div class="card-body">
                <form action="{{route('superadmin.blogs.update', $blog)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input required type="text" class="form-control" id="title" name="title" aria-describedby="nameHelp" value="{{$blog->title}}">
                        @error('title')
                            <small id="titleHelp" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="url">Image(Optional)</label>
                        <input type="file" class="form-control-file" id="url" name="url" aria-describedby="urlHelp">
                        @error('url')
                            <small id="urlHelp" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="article">Article</label>
                        <textarea required class="form-control" id="article" name="article" aria-describedby="descriptionHelp">{{$blog->article}}</textarea>
                        @error('article')
                            <small id="articleHelp" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
