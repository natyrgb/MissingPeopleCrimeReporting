@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">Edit Account</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-success">
                <h3 class="card-header">Edit Account</h3>
                <div class="card-body">
                    <form action="{{route('employee.update_account', [$employee])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" value="{{$employee->name}}">
                            @error('name')
                                <small id="nameHelp" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{$employee->email}}">
                            @error('email')
                                <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" value="{{$employee->phone}}">
                            @error('phone')
                                <small id="phoneHelp" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input @if($employee->password_changed != true) required @endif type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp">
                            @error('password')
                                <small id="passwordHelp" class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        @if($employee->password_changed)
                        <input type="hidden" name="password_changed" value="{{$employee->password_changed}}">
                        @endif
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input @if($employee->password_changed != true) required @endif type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        <div class="form-group">
                            <label for="old_password">Old Password</label>
                            <input @if($employee->password_changed == true) required @endif type="password" class="form-control" id="old_password" name="old_password" aria-describedby="oldPasswordHelp">
                            @error('old_password')
                                <small id="oldPasswordHelp" class="form-text text-danger">{{$message}}</small>
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
@if($employee->password_changed == false)
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                Swal.fire('Ooops...', "There was an error on in your input.", 'error');
            })
        </script>
    @else
        <script>
            $(document).ready(function() {
                Swal.fire('Welcome', "You should change the default password now.", 'success');
            })
        </script>
    @endif
@else
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                Swal.fire('Ooops...', "There was an error on in your input.", 'error');
            })
        </script>
    @endif
@endif
@endsection
