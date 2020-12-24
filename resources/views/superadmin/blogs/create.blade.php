@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">News</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Add News</h3>
                <div class="card-body">
                    <form action="{{route('superadmin.blogs.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input required type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp">
                            @error('title')
                                <small id="titleHelp" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="url">Image</label>
                            <input required type="file" class="form-control-file" id="url" name="url" aria-describedby="urlHelp">
                            @error('url')
                                <small id="nameHelp" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="article">Article</label>
                            <textarea required class="form-control" id="article" name="article" aria-describedby="articleHelp"></textarea>
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
</div>
@endsection
