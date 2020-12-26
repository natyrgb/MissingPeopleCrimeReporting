@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">Add Employee</h3>
            <div class="card-body">
                <form action="{{route('superadmin.employees.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input required type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                        @error('name')
                            <small id="nameHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input required type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        @error('email')
                            <small id="emailHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input required type="tel" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp">
                        @error('phone')
                            <small id="phoneHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="station">Station</label>
                        <select required class="form-control" id="station" name="station_id" aria-describedby="stationHelp">
                            @foreach ($stations as $item)
                                @if ($item->id != 1)
                                    <option @if($item->id==2) selected @endif value="{{$item->id}}" data-deps="{{$item->departments}}">{{$item->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('station_id')
                            <small id="stationHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select required class="form-control" id="role" name="role" aria-describedby="roleHelp">
                            <option selected value="ATTORNEY">Attorney</option>
                            <option value="POLICE">Police</option>
                        </select>
                        @error('role')
                            <small id="roleHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group" id="dep_group">
                        <label for="department">Department</label>
                        <select class="form-control" id="department" name="department" aria-describedby="departmentHelp">
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
@endsection
 @section('js')
     <script>
         $(document).ready(function() {
            $('#dep_group').hide();
            let st = $('#station option:selected').data('deps');
            for(let dep in st) {
                let deps = st[dep];
                $('#department').append('<option value='+deps.id+'>'+makeTitle(deps.name)+'</option>');
            }
            $('#role').change(function() {
                let role = $('#role option:selected').val();
                if(role == 'ATTORNEY')
                    $('#dep_group').hide();
                else
                    $('#dep_group').show();
            })
         });
         $(function() {
            $('#station').change(function() {
                let st = $('#station option:selected').data('deps');
                $('#department').children().remove();
                for(let dep in st) {
                    let deps = st[dep];
                    $('#department').append('<option value='+deps.id+'>'+makeTitle(deps.name)+'</option>');
                }
            });
         });
     </script>
 @endsection
