@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">Edit Station</h3>
            <div class="card-body">
                <form action="{{route('superadmin.stations.update', $station)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input required value="{{$station->name}}" type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                        @error('name')
                            <small id="nameHelp" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="woreda">Woreda</label>
                        <select name="woreda" id="woreda" class="form-control" aria-describedby="woredaHelp">
                            @for ($i = 1; $i <= 5; $i++)
                                <option @if($i==$station->woreda) selected @endif value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        @error('woreda')
                            <small id="woredaHelp" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">Edit Station Administrator</h3>
            <div class="card-body">
                @if ($station->admin_id==null)
                    <div class="alert alert-secondary" role="alert">
                        <p>There is no station administrator appointed.</p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#employees">
                            Appoint Station Administrator
                        </button>
                    </div>
                @else
                    <div class="alert alert-success">
                        <p><strong>Administrator: </strong>{{$station->admin->name}}</p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#employees">
                            Change Station Administrator
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="employees" tabindex="-1" role="dialog" aria-labelledby="employeesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeesLabel">Employees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($station->employees->count())
                    <table id="datatable_emp" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($station->employees as $item)
                                @if ($item->role == 'POLICE')
                                    <tr>
                                        <th scope="row">{{$item->id}}</th>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->role}}</td>
                                        <td>
                                            <a class="btn btn-success" href="{{route('superadmin.add_admin', [$station, $item])}}">
                                                Appoint As Administrator
                                            </a>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
