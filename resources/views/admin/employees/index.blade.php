@extends('layouts.backend.app')

@section('content')
<div class="card">
    <h3 class="card-header">Employees</h3>
    <div class="card-body">
        @if ($employees->count())
            <table class="table table-bordered table-striped datatable-custom">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $item)
                        @if ($item->role != 'ADMIN' && $item->role != 'SUPERADMIN')
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->department ? ucwords(str_replace('-', ' ', $item->department->name)) : '-'}}</td>
                                <td>{{$item->role}}</td>
                                <td>
                                    <a href="{{route('admin.employees.edit', $item)}}" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger delete" id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                    <form action="{{route('admin.employees.destroy', $item)}}" method="post" id="delete{{$item->id}}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-danger" role="alert">
                There are no employees available.
            </div>
        @endif
    </div>
</div>
@endsection
