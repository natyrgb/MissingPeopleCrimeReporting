@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">Missing People</h1>
    <div class="row">
        <div class="col-md-12">
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
                            @foreach ($missing_people as $item)
                                <tr>
                                    <th scope="row">{{$item->id}}</th>
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
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#datatable_emp').DataTable();
        });
    </script>
@endsection
