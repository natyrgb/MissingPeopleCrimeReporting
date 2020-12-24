@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">Employees</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Edit Employee</h3>
                <div class="card-body">
                    <form action="{{route('admin.employees.update', $employee)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input required value="{{$employee->name}}" type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                            @error('name')
                                <small id="nameHelp" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input required value="{{$employee->email}}" type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                            @error('email')
                                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input required value="{{$employee->phone}}" type="tel" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp">
                            @error('phone')
                                <small id="phoneHelp" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select required class="form-control" id="role" name="role" aria-describedby="roleHelp">
                                <option @if($employee->role == 'POLICE') selected @endif value="POLICE">Police</option>
                                <option @if($employee->role == 'ATTORNEY') selected @endif value="ATTORNEY">Attorney</option>
                            </select>
                            @error('role')
                                <small id="roleHelp" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group" id="dep_group">
                            <label for="department">Department</label>
                            <select required class="form-control" id="department" name="department" aria-describedby="departmentHelp">
                                @foreach ($departments as $item)
                                    <option value="{{$item->id}}" @if($item->id == $employee->department_id) selected @endif>{{ucwords(str_replace('-', ' ', $item->name))}}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <small id="departmentHelp" class="form-text text-danger">{{$message}}</small>
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
 @section('js')
     <script>
         $(document).ready(function() {
            $('#role').change(function() {
                let role = $('#role option:selected').val();
                if(role == 'ATTORNEY')
                    $('#dep_group').hide();
                else
                    $('#dep_group').show();
            });
         });
     </script>
 @endsection
