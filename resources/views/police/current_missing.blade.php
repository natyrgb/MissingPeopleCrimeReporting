@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">Current Case</h1>
    @if ($has_case == 'yes')
        <div class="row px-4">
            <div class="col-md-4">
                <figure>
                    <img src="{{asset('images/'.$case->attachment->url)}}" alt="" class="img-fluid">
                    <figcaption><strong>Evidence</strong></figcaption>
                </figure>
            </div>
            <div class="col-md-8 px-4">
                <div class="card">
                    <h2 class="card-header">Missing Person</h2>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Reporter:</strong>
                            <i>{{$case->user->name}}<a href="#">Show User</a></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Missing Person Name:</strong>
                            <span>{{$case->name}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Missing Person Description:</strong>
                            <span>{{$case->description}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-center align-items-center">
                            <a href="{{route('police.mark_as_found', [$case->id])}}" class="btn btn-primary">Mark As Found</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            <p class="lead text-center">You have no case assigned to you.</p>
        </div>
    @endif
</div>
@endsection
