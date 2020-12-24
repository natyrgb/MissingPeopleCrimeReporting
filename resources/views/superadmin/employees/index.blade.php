@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">Employees</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">All Employees</h3>
                <div class="card-body">
                    @if ($employees->count())
                        <table class="table table-bordered table-striped datatable-custom">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Station</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $item)
                                    @if ($item->role != 'SUPERADMIN')
                                        <tr>
                                            <th scope="row">{{$item->id}}</th>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->station->name}}</td>
                                            <td>{{$item->role}}</td>
                                            <td>{{ $item->department!=null ? ucwords(str_replace('-', ' ', $item->department->name)) : 'None' }}</td>
                                            <td>
                                                <a href="{{route('superadmin.employees.edit', $item)}}" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a class="btn btn-danger delete" id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                                <form action="{{route('superadmin.employees.destroy', $item)}}" method="post" id="delete{{$item->id}}">
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
        </div>
    </div>
</div>
@endsection
