@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">News</h3>
            <div class="card-body">
                @if ($blogs->count())
                    <table class="table table-bordered table-striped datatable-custom">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Image Url</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($blogs as $item)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$item->title}}</td>
                                    <td>
                                        <a data-toggle="tooltip" title="<img src='{{asset($item->url)}}' class='img-fluid'>">{{$item->url}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('superadmin.blogs.edit', $item)}}" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger delete" id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                        <form action="{{route('superadmin.blogs.destroy', $item)}}" method="post" id="delete{{$item->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger" role="alert">
                        There are no news available.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
