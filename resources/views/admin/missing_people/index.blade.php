@extends('layouts.backend.app')

@section('content')
<div class="card">
    <h3 class="card-header">Missing People</h3>
    <div class="card-body">
        @if ($missing_people->count())
        <table class="datatable-custom table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Reporter</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $$i = 0;
                @endphp
                @foreach ($missing_people as $item)
                    <tr>
                        <th scope="row">{{$i}}</th>
                        <td>{{$item->user->name}}</td>
                        <td>{{ucwords(str_replace('_', ' ', $item->status))}}</td>
                        <td>
                            @if ($item->status == 'new')
                                <a href="{{route('admin.mark_as_found', $item->id)}}" class="btn btn-success">Mark As Found</a>
                            @endif
                            <a class="btn btn-danger delete" id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="far fa-trash-alt"></i>
                            </a>
                            <form action="{{route('admin.missing_people.destroy', $item)}}" method="post" id="delete{{$item->id}}">
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
                There are no missing people.
            </div>
        @endif
    </div>
</div>
@endsection
